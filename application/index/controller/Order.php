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
use think\Log;

/**
 *	订单
 * @author  wangjingjing
 */
class Order extends Common
{
	/**
     * 个人订单
     * @author ILsunshien
     */
    public function orderLists()
    {   
        // 筛选订单状态
        $status = input('status');
        if (!empty($status)) {
            $map['status'] = $status;
        }else{
            $map['status'] = array('not in',['cancel','delete']);
        }
        $map['uid'] = UID;
        $orders_ids = Db::name('Orders')->where($map)->order('createtime desc')->column('id');
        if($orders_ids){
            $where['order_id'] = ['in',$orders_ids];
            $goods = Db::name('OrdersGoods')
            ->where($where)
            ->order('id desc')
            ->paginate(10,false,['query' => ['status'=>$status] ]); 
            // 获取分页显示
            $page = $goods->render();         
            $this->assign('page',$page);
            $this->assign('lists',$goods);
            
        }else{
            $this->assign('page',"");
            $this->assign('lists',"");
        }
        return $this->themeFetch('user_order');
    }
	   
    /**
     * 个人订单详情页
     * @author ILsunshine
     */
    public function orderDetail()
    {
        $order_id = input('get.order_id');
        if(empty($order_id)){
            $this->error('参数错误');
        }
        $map['uid']      = UID;
        $map['id']       = $order_id;        
        $orders = Db::name('Orders')->where($map)->find();        
        if(empty($orders)){
            $this->error('订单不存在');
        }
        $this->assign('ordersInfo',$orders);        
        return $this->themeFetch('order_detail');
    }

 

	/**
	 * 确认收货或删除
	 */
	public function cancel()
	{
		$id = input('post.id');
		$type = input('post.type');
		if(empty($id)){
			$this->error('参数错误！');
		}		
        $info = Db::name('Orders')->where(['id'=>$id])->find();
        if($info){
            // 订单          
            if($info['status'] == 'shipped' || $info['status'] == 'completed'){
                if($type==1){
                    $data['status'] = "completed";
                }else{
                    $data['status'] = "delete";
                }
                $res = Db::name('Orders')->where(array('id'=>$id,'uid'=>UID))->update($data);
                if($res){
                    if($type==1){
                        return $this->success('确认收货成功！');
                    }else{
                        return $this->success('订单删除成功！');
                    }
                }else{
                    if($type==1){
                        $this->error('确认收货失败，请联系客服！');
                    }else{
                        $this->error('订单删除失败，请联系客服！');
                    }
                }
            }
            else{
                $this->error('订单交易中！');
            }

        }else{
            $this->error('订单不存在');
        }
		
		
	}
}
