<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: vaey
// +----------------------------------------------------------------------

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;

/**
 * 商品
 * @author  tangtanglove <dai_hang_love@126.com>
 */
class Goods extends Base
{

 
	//商品详情页面
    public function detail(){
        $id = input('get.id');
        if(empty($id)||!is_numeric($id)){
            return $this->error('参数错误');
        }
 
        $data = Db::name('Goods')->where(['id'=>$id])->find();
        if($data['categoryIds'] == 2){
           $user_gongpai = Db::name('gongpai')->where(['uid'=>UID])->find();
           if(!empty($user_gongpai)){
            return $this->error('公排产品每人只允许购买一次');
           }
        }
        // dump($data);die();
        $data = wap_detail_adapter($data);
        //总评论数
        $map['status'] =1;
        $map['goods_id'] = $id;
        // $total_comment = Db::name('GoodsComment')->where($map)->count();
        //获取评论列表
 
        $this->assign('data',$data);
 
 

        return $this->themeFetch('goods_detail');
    }

    //收藏
    public function collection(){
        $id     = input('post.id');
        $uid = session('wap_user_auth.uid');
        $info = Db::name('GoodsCollection')->where(['goods_id'=>$id,'uid'=>$uid])->find();
        if($info){
            if(Db::name('GoodsCollection')->where(['id'=>$info['id']])->delete()){
                return $this->success('取消收藏成功','',['img'=>'collectionone.png']);
               
            }else{
                return $this->error('取消收藏失败');
            }
        }else{
            if(Db::name('GoodsCollection')->insert(['uid'=>$uid,'goods_id'=>$id,'createtime'=>time()])){
                return $this->success('收藏成功','',['img'=>'collection_big.png']);
                
            }else{
                return $this->success('收藏失败');
            }
        }
        
    }
	
}
