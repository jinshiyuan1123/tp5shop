<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: wangjingjing<1064868847@qq.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\index\controller;

include 'wechatH5Pay.php';

use think\Db;
use think\Log;

/**
* 微信支付
* @author tangtanglove
*/
class Wxpay extends Base   
{

	    //$data 金额和订单号
		public function wxh5Request(){

			$uid = session('wap_user_auth.uid');
			if (empty($uid)) {
				$this->error('未登录！');
			}
			$order_no = input('get.order_no');
			$ordersInfo = Db::name('Orders')->where(['order_no'=>$order_no,'uid'=>$uid])->find();
	
			if(empty($ordersInfo)){
				$this->error('参数错误');
			}
			$wzurl = config("enter_url");//网站url
			$wzname = config("web_site_title");//网站名称

			$appid = config("wechat_appid");  
			$mch_id = config("wechat_mchid");//商户号
			$key = config("wechat_appkey");//商户key
			$notify_url   = config('enter_url').'/Wxpay/notify_url.html';//回调地址
			
			$wechatAppPay = new \wechatAppPay($appid, $mch_id, $notify_url, $key);
			$params['body'] = '商品订单号'.$order_no;                       //商品描述
			$params['out_trade_no'] = $order_no;    //自定义的订单号
			$params['total_fee'] = $ordersInfo['amount']*100;                       //订单金额 只能为整数 单位为分
			$params['trade_type'] = 'MWEB';                   //交易类型 JSAPI | NATIVE | APP | WAP 
			$params['scene_info'] = '{"h5_info": {"type":"Wap","wap_url": "'.$wzurl.'","wap_name": "'.$wzname.'"}}';
			$result = $wechatAppPay->unifiedOrder($params);
			
			
			$url = $result['mweb_url'].'&redirect_url='.config('enter_url');//redirect_url 是支付完成后返回的页面

			echo "<script>window.location.href='" . $url . "';</script>";

			exit;
			//  return $url;
			
		
		}
	

	/**
	* 微信同步通知
	* @author tangtanglove
	*/
	public function return_url() {

		
		$out_trade_no = input('get.out_trade_no');
		

	

		$appid = config("wechat_appid");
		$mch_id = config("wechat_mchid");//商户号
		$key = config("wechat_appkey");//商户key
		$notify_url   = config('enter_url').'/wxpay1/notify_url.html'.'out_trade_no/' . $out_trade_no;//回调地址
		
		$wechatAppPay = new \wechatAppPay($appid, $mch_id, $notify_url, $key);
		$result       = $wechatAppPay->orderQuery($out_trade_no);
	
		$uid = session('wap_user_auth.uid');
		if (empty($uid)) {
			$this->error('未登录！');
		}
		if($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS'){
		
		$ordersInfo = Db::name('Orders')->where(['order_no'=>$result['out_trade_no'],'uid'=>$uid])->find();
		if ($result['trade_state'] == 'SUCCESS') {

			if(empty($ordersInfo)){
				$this->error('参数错误');
			}
			if ( $ordersInfo['status'] != 'paid') {
				
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
			}
				
		}else{
			$content = "订单号:".$out_trade_no."，（错误码：'".$result['trade_state_desc']."'）";
			
		}
			$this->assign('content',$content);
			$this->assign('ordersInfo',$ordersInfo);
			return $this->themeFetch('return_url');
		}
	}
	/**
	* 微信异步通知
	* @author tangtanglove
	*/
	public function notify_url(){
		// 获取返回的post数据包
		$postStr = file_get_contents("php://input");			
		if (!empty($postStr)){
			libxml_disable_entity_loader(true);
			$postObj = (array)simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$key    = config('wechat_appkey'); 
		
			$para_filter = $this->paraFilter($postObj);
		
			//对待签名参数数组排序
			$para_sort = $this->argSort($para_filter);
			//把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
			$prestr = $this->createLinkstring($para_sort);
			$strSignTmp = $prestr."&key=$key"; //拼接字符串  注意顺序微信有个测试网址 顺序按照他的来 直接点下面的校正测试 包括下面XML  是否正确
			$sign = strtoupper(MD5($strSignTmp)); // MD5 后转换成大写	
			if($sign==$postObj['sign']){
				$out_trade_no = $postObj['out_trade_no'];

				$ordersInfo = Db::name('Orders')->where(['order_no'=>$out_trade_no])->find();
				
				if(empty($ordersInfo)){
					$this->error('参数错误');
				}
				if ( $ordersInfo['status'] != 'paid') {
					
					Db::startTrans();
					$uid = $ordersInfo['uid'];

					// 更新订单状态
					$orderdata['status'] = 'paid';
					$orderdata['is_pay'] = 1;
					$ordersrResult = Db::name('Orders')->where(['order_no'=>$out_trade_no])->update($orderdata);
					
				
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

					// $up_order_status=up_scoreorder_status($order_sn,'wxpay',$postObj['transaction_id'],$postObj['time_end']);
					if ($ordersrResult && $ordersStatusResult && $ordersgoods_ispay) {
						Db::commit();
							$result = "<xml>
							<return_code><![CDATA[SUCCESS]]></return_code>
							<return_msg><![CDATA[OK]]></return_msg>
							</xml>";
						}else{
							Db::rollback();
							$result = "<xml>
							<return_code><![CDATA[FAIL]]></return_code>
							<return_msg><![CDATA[未接收到post数据]]></return_msg>
							</xml>";
						}
				}else{
					$result = "<xml>
					<return_code><![CDATA[FAIL]]></return_code>
					<return_msg><![CDATA[未接收到post数据]]></return_msg>
					</xml>";
				}

			}else {	
				$result = "<xml>
				<return_code><![CDATA[FAIL]]></return_code>
				<return_msg><![CDATA[未接收到post数据]]></return_msg>
				</xml>";
			}
			return $result;	
		}				
		
	}
	
	
	
			/**
			 * 除去数组中的空值和签名参数
			 * @param $para 签名参数组
			 * return 去掉空值与签名参数后的新签名参数组
			 */
			function paraFilter($para) {
			
				$para_filter = array();
				while (list ($key, $val) = each ($para)) {
					if($key == "sign" || $key == "sign_type" || $val == "")continue;
					else    $para_filter[$key] = $para[$key];
				}
				return $para_filter;
			}
			/**
			 * 对数组排序
			 * @param $para 排序前的数组
			 * return 排序后的数组
			 */
		function argSort($para) {
				ksort($para);
				reset($para);
				return $para;
			}
		/**
		 * 把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
		 * @param $para 需要拼接的数组
		 * return 拼接完成以后的字符串
		 */
		function createLinkstring($para) {
			$arg  = "";
			while (list ($key, $val) = each ($para)) {
				$arg.=$key."=".$val."&";
			}
			//去掉最后一个&字符
			$arg = substr($arg,0,count($arg)-2);
			//file_put_contents("log.txt","转义前:".$arg."\n", FILE_APPEND);
			//如果存在转义字符，那么去掉转义
			if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
			//file_put_contents("log.txt","转义后:".$arg."\n", FILE_APPEND);
			return $arg;
		}
	
	
	


}