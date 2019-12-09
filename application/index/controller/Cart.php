<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: wangjingjing<1064868847@qq.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\index\controller;

use think\Db;

/**
 * 购物车控制器
 * @author tangtanglove
 */
class Cart extends Common
{
	/**
	* 购物车首页
	* @author tangtanglove
	*/
	public function index_linshi()
	{
		$carlists 	 = json_decode(cookie('mini_car'));
		
		$selectGoods = '';
		$cartMoney   = 0;
		if ($carlists) {
			foreach ($carlists as $key => $value) {
				$hasCart = Db::name('Cart')->where(['goods_id'=>$value[0],'uid'=>UID,'status'=>1])->find();
				if($hasCart) {
					$data['goods_id'] 	= $value[0];
					$data['uid'] 		= UID;
					$data['num'] = $hasCart['num']+$value[3];
					$data['createtime'] = $hasCart['createtime'];
					Db::name('Cart')->where(['goods_id'=>$value[0],'uid'=>UID,'status'=>1])->update($data);
				} else {
					$data['goods_id'] 	= $value[0];
					$data['uid'] 		= UID;
					$data['num'] 		= $value[3];
					$data['createtime'] = time();
					Db::name('Cart')->insert($data);
				}
				// 定义被选中的goods_id
				$selectGoods[$key] = $value[0];
				// 计算购物车合计
				$cartMoney = $cartMoney+$data['num']*$value[2];
			}

			// 删除cookie
			cookie('mini_car', null);
		}
 
		$where['a.uid'] 	= UID;
		$where['a.status'] 	= 1;
		$where['b.status']  = 1;
        $lists = Db::name('Cart')->alias('a')->join('goods b','b.id=a.goods_id','LEFT')
        ->where($where)
		->order('id desc')
        ->field('a.num as cart_num,b.*')
        ->select();
		// 输出选中的商品id
		$this->assign('cartMoney',$cartMoney);
		$this->assign('selectGoods',$selectGoods);
		$this->assign('lists',$lists);
		var_dump($lists);exit;
        return $this->themeFetch('cart_index');
	}


	/**
	* 购物车首页
	* @author tangtanglove
	*/
	public function index()
	{
		$carlists 	 = json_decode(cookie('mini_car'));
		$selectGoods = '';
		$cartMoney   = 0;
		$lists = array();
		$i = 0;
		if ($carlists) {
			
			foreach ($carlists as $key => $value) {

					$lists[$i] = Db::name('goods')->where('id',$value[0])->find();
					$lists[$i]['cart_num'] = $value[3];
				
				// 定义被选中的goods_id
				$selectGoods[$key] = $value[0];
				// 计算购物车合计
				$cartMoney = $cartMoney+$value[3]*$value[2];
				$i++;
			}

			// 删除cookie
			//cookie('mini_car', null); cookie 不能在此清除
		} 
 
		// 输出选中的商品id
		$this->assign('cartMoney',$cartMoney);
		$this->assign('selectGoods',$selectGoods);
		$this->assign('lists',$lists);
        return $this->themeFetch('cart_index');
	}

	/**
	* 缓存订单数据
	* @author tangtanglove
	*/
	public function sessionorder()
	{
		$cart = input('cart/a'); 

		foreach ($cart as $key => $value) {
			$arrvalue = explode(',',$value);
			if (trim($arrvalue['0']) == 'yes') {
				$goodsInfo = Db::name('Goods')->where(['id'=>$arrvalue['1'],'status'=>1])->find();
				if(empty($goodsInfo)) {
					return $this->error('此商品已下架！');
				}
				if($goodsInfo['categoryIds'] == 2){
					$user_gongpai = Db::name('gongpai')->where(['uid'=>UID])->find();
					if(!empty($user_gongpai)){
					 return $this->error('公排产品每人只允许购买一次');
					}
				 }
				$lists[$key]['num']  = $arrvalue['3'];
				if($arrvalue['3']>$goodsInfo['num']) {
					return $this->error('库存不足');
				}
			}
		}
		if (empty($lists)) {
			return $this->error('请选择数据！');
		}
 		session('cartInfo',$cart);
 		return $this->success('马上跳转',url('checkOrder'));
	}



	/**
	* 检查订单信息
	* @author tangtanglove
	*/
	public function checkOrder()
	{
		$cart = session('cartInfo');
		if (!$cart) {
			return $this->error('请选择数据！',url('index'));
		}
		$cartMoney   = 0;
		foreach ($cart as $key => $value) {
			$arrvalue = explode(',',$value);
			if (trim($arrvalue['0']) == 'yes') {
				$goodsInfo = Db::name('Goods')->where(['id'=>$arrvalue['1'],'status'=>1])->find();
				if(empty($goodsInfo)) {
					return $this->error('此商品已下架！',url('index'));
				}
				if($goodsInfo['categoryIds'] == 2){
					$user_gongpai = Db::name('gongpai')->where(['uid'=>UID])->find();
					if(!empty($user_gongpai)){
					 return $this->error('公排产品每人只允许购买一次');
					}
				 }
				$lists[$key]['info'] = $goodsInfo;
				$lists[$key]['num']  = $arrvalue['3'];
				// 计算购物车合计
				$cartMoney = $cartMoney+$arrvalue['3']*$goodsInfo['price'];
			}
		}
		if (empty($lists)) {
			return $this->error('请选择数据！',url('index'));
		}
		// 判断是否在微信中
		if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
			$agent = 'wxpay';
		} else {
			$agent = 'alipay';
		}
		// $bdscore=config('web_user_bdscore');//保底积分
 		// $userinfo  = Db::name('Users')->where('id',UID)->find();
 		// if(($userinfo['score'])<$cartMoney){
 		// 	$hcscore=ceil($cartMoney-$userinfo['score']);
 		// }else{
 		// 	$hcscore='yes';
		 // }
		 $hcscore='yes';
 		$this->assign('hcscore',$hcscore); 
		$this->assign('cartMoney',$cartMoney);
		$this->assign('agent',$agent);
		$this->assign('lists',$lists);
        return $this->themeFetch('cart_check_info');
	}

	/**
	* 提交订单
	* @author tangtanglove
	*/
	public function postOrder()
	{
		$cart 		= session('cartInfo');
		$consignee_name 	= input('consignee_name');
		$paytype 	= input('paytype');
		$mobile 	= input('mobile');
		$address 	= input('address');

		
		if (!$cart) {
			return $this->error('请选择数据！');
		}

		// 计算总金额
		$cartMoney   = 0;
		foreach ($cart as $key => $value) {
			$arrvalue = explode(',',$value);
			if (trim($arrvalue['0']) == 'yes') {
				$goodsInfo = Db::name('Goods')->where(['id'=>$arrvalue['1'],'status'=>1])->find();
				if(empty($goodsInfo)) {
					return $this->error('此商品已下架！',url('index'));
				}
				if($goodsInfo['categoryIds'] == 2){
					$user_gongpai = Db::name('gongpai')->where(['uid'=>UID])->find();
					if(!empty($user_gongpai)){
					 return $this->error('公排产品每人只允许购买一次');
					}
				 }
				// 判断数量是合法
				$arrvalue['3'] = intval($arrvalue['3']);
				if($arrvalue['3']<=0 || !is_int($arrvalue['3'])) {
					return $this->error('请输入正确的数量！',url('index'));
				}
				if($arrvalue['3']>$goodsInfo['num']) {
					return $this->error('库存不足');
				}
				// 保存数据
				$lists[$key]['info'] = $goodsInfo;
				$categoryIds = $goodsInfo['categoryIds'];
				$lists[$key]['num']  = $arrvalue['3'];
				// 计算购物车合计
				$cartMoney = $cartMoney+$arrvalue['3']*$goodsInfo['price'];
			}
		}
		// $userInfo = Db::name("Users")->where('id', UID)->find();
		//  // $kyjf=score_ky(UID);
		//  $kyjf=$userInfo['score'];
 		// if($kyjf<$cartMoney){
 		// 	return $this->error('可用'.config('web_score_name').'不足');
 		// }
		if (empty($consignee_name) || empty($mobile) || empty($address)) {
			return $this->error('请填写收货信息');
		}
		Db::startTrans();
		// 订单号
		$order_no 	= date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
		$amount 	= $cartMoney;

		$data['uuid'] 		= create_uuid();
		$data['uid']  		= UID;
		$data['order_no']  	= $order_no;
		$data['amount']  	= $amount;
		$data['pay_type']  	= $paytype;
		$data['consignee_name'] = $consignee_name;
		$data['address'] = $address;
		$data['mobile'] 	= $mobile;
		$data['createtime'] = time();
		$data['status'] = 'nopaid';
		$data['is_pay'] = 0; 
		$data['categoryIds'] = $categoryIds;
		$hasOrder = Db::name('Orders')->where(['order_no'=>$order_no])->find();
		if ($hasOrder) {
			return $this->error('此订单号已经存在！');
		}

		$ordersResult = Db::name('Orders')->insert($data);
		

		$orders_id = Db::getLastInsID();

		// $jiesuan=jiesuanscore(UID,strtotime("+1 day"));//结算积分
		// $users_zj=up_score(UID,0,-$cartMoney,'购物消费',time());//减少自己积分
 

					// 插入订单状态
		// $data_ords['order_id'] 		= $orders_id;
		// $data_ords['status']   		= 'paid'; 
		// $data_ords['createtime'] 	= time();
		// $ordersStatusResult = Db::name('OrdersStatus')->insert($data_ords);

            if($ordersResult){

					foreach ($lists as $key => $value) {
						$ordersGoodsData['order_id'] 	= $orders_id;
						$ordersGoodsData['goods_id'] 	= $value['info']['id'];
						$ordersGoodsData['name'] 		= $value['info']['name'];
						$ordersGoodsData['num'] 		= $value['num'];
						$ordersGoodsData['price'] 		= $value['info']['price'];
						$ordersGoodsData['standard'] 	= $value['info']['standard'];
						$ordersGoodsData['cover_path'] 	= $value['info']['cover_path'];
						$ordersGoodsData['categoryIds'] = $value['info']['categoryIds'];
						$ordersGoodsResult = Db::name('OrdersGoods')->insert($ordersGoodsData);

					}

						// 更改购物车状态
						// $goodsList = Db::name('OrdersGoods')->where('order_id',$orders_id)->select();
						// foreach ($goodsList as $key => $value) {
						// 	Db::name('Cart')->where('goods_id',$value['goods_id'])->where(['status'=>1])->update(['status'=>2]);
						// }
					// 清空购物车信息
					session('cartInfo',null);  
					// 删除cookie
					cookie('mini_car', null); 

					if ($paytype == 'wxpay') {
						Db::commit(); // 提交事务
						return $this->success('正在跳转支付中...',url('index/Wxpay/wxh5Request').'?order_no='.$order_no);
						
					} elseif($paytype == 'alipay') {
						Db::commit(); // 提交事务
						return $this->success('正在跳转支付中...',url('index/alipay/pay').'?order_no='.$order_no);
				
					}elseif($paytype == 'yepay') {
						Db::commit(); // 提交事务
						return $this->success('正在支付中...',url('yue_pay').'?order_no='.$order_no);
						
					} else {
						// 回滚事务
					Db::rollback();
						return $this->error('支付方式错误！');
					}				 
             }else{
                // 回滚事务
                Db::rollback();
                return $this->error('购买失败');
             }
	}

	/**
	* 余额支付
	* @author tangtanglove
	*/
	public function yue_pay(){
		$out_trade_no = input('order_no');
		$uid =  UID;
		$orders_xx = Db::name('Orders')->where(['order_no'=>$out_trade_no])->find();
		$users_xx = Db::name('Users')->where(['id'=>$uid])->find();
	
		if($users_xx['score']<$orders_xx['amount']){
			return $this->error('可用余额不足',url('index/index'));
		}
		$users_zj=up_score(UID,0,-$orders_xx['amount'],'购物消费',time());//减少自己积分

		if ($users_zj) {

			// ——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
		
			$ordersInfo = Db::name('Orders')->where(['order_no'=>$out_trade_no,'uid'=>$uid])->find();
			
			if (empty($ordersInfo)) {
				$this->error('订单异常！');
			} else {
				if ($ordersInfo['status'] != 'paid') {
					// 开启事务
					Db::startTrans();

					// 更新订单状态
					$orderdata['status'] = 'paid';
					$orderdata['is_pay'] = 1;
					$ordersrResult = Db::name('Orders')->where(['order_no'=>$out_trade_no,'uid'=>$uid])->update($orderdata);
					
				
					// 插入订单状态
					$data['order_id'] 		= $ordersInfo['id'];
					$data['status']   		= 'paid';
					$data['createtime'] 	= time();
					// $data['trade_no'] 		= $trade_no;
					// $data['trade_status'] 	= $trade_status;
					$ordersStatusResult = Db::name('OrdersStatus')->insert($data);
					
					//查询会员信息
					$user_is_shop = Db::name('Users')->where('id',$uid)->find();
					//判断购买产品是何种类型商品
					if($ordersInfo['categoryIds']==2){//公排产品
						gongpai($ordersInfo['uid'],$user_is_shop['reid'],$out_trade_no,$ordersInfo['amount']);//会员id 推荐人id 订单号 投资金额
						//判断用户是否是第一次购买
						if($user_is_shop['is_shop'] == 0){//如果会员是第一次购买发放各种奖励
							Db::name('Users')->where('id',$uid)->update(['is_shop' =>1]);
							Db::name('Users')->where('id ='.$user_is_shop['reid'])->update(['zt_num'=>['exp','zt_num+1']]);//推荐人直推人数加一
						}
					}

					//改变商品表中商品数量
					$ordersgoods_list = Db::name('OrdersGoods')->where(['order_id'=>$ordersInfo['id']])->select();
					foreach($ordersgoods_list as $key=>$value){
						$goods_list = Db::name('Goods')->where(['id'=>$value['goods_id']])->find();

						if($goods_list['num']>$value['num']){
							$goods_data['num'] = $goods_list['num']-$value['num'];
							$goods_data['sell_num'] = $goods_list['sell_num']+$value['num'];	
						}else{
							$goods_data['num'] = 0;
							$goods_data['sell_num'] = $goods_list['sell_num']+$value['num'];
						}
						$ordersrResult = Db::name('Goods')->where(['id'=>$value['goods_id']])->update($goods_data);
					}
					
										

					if ($ordersrResult && $ordersStatusResult) {
					
						Db::commit();
					
					} else {
						Db::rollback();
					}
							
					$content = "您已成功支付".$ordersInfo['amount']."元，订单号：".$out_trade_no;
				} else {
					$content = "订单号:".$out_trade_no."，支付失败";
				}
			}
		} else {
			$this->error('支付失败，请重试！');
		}

		if (empty($content)) {
			$content = '支付失败，请重新购买！';
		}

		$this->assign('content',$content);
		$this->assign('ordersInfo',$ordersInfo);
		return $this->themeFetch('return_url');
	}
 
	/**
     * 删除单个购物信息
     * @author tangtanglove
	 */
	public function delete()
	{exit;
		$goodsid = input('post.id');
		if(empty($goodsid)) {
			return $this->error('请选择数据！');
		}
		$result = Db::name('Cart')->where('goods_id',$goodsid)->where(['uid'=>UID,'status'=>1])->delete();
		if(false !=$result) {
			return $this->success('删除成功！');
		} else {
			return $this->error('删除失败！');
		}
	}

	/**
     * 删除多个购物信息
     * @author tangtanglove
	 */
	public function deleteAll()
	{exit;
		$goodsids = input('post.ids');
		if(empty($goodsids)) {
			return $this->error('请选择数据！');
		}
		$result = Db::name('Cart')->where('goods_id','in',$goodsids)->where(['uid'=>UID,'status'=>1])->delete();
		if(false !=$result) {
			return $this->success('删除成功！');
		} else {
			return $this->error('删除失败！');
		}
	}

	/**
	* 订单收藏
	* @author tangtanglove
	*/
	public function collection()
	{exit;
		$cart = input('cart/a');
		if (!$cart) {
			return $this->error('请选择数据！');
		}
		$hasSelect = 0;
		foreach ($cart as $key => $value) {
			$arrvalue = explode(',',$value);
			if (trim($arrvalue['0']) == 'yes') {
				$data['uid'] 		= UID;
				$data['goods_id'] 	= $arrvalue['1'];
				$data['createtime'] = time();
				$hasGoodsCollection = Db::name('GoodsCollection')->where(['uid'=>UID,'goods_id'=>$arrvalue['1']])->find();
				if(empty($hasGoodsCollection)) {
					Db::name('GoodsCollection')->insert($data);
				}
				$hasSelect = 1;
			}
		}

		if($hasSelect) {
			return $this->success('收藏成功！');
		} else {
			return $this->error('请选择数据！');
		}

	}

}