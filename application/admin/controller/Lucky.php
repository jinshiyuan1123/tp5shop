<?php
/**
 * 抽奖后台
 * Created by PhpStorm.
 * User: yule
 * Date: 2017/2/5
 * Time: 10:30
 */

namespace app\admin\controller;

use think\Controller;
use think\Db;

/**
 * 系统中心控制器
 * @author  完美°ぜ界丶
 */
class Lucky extends Common
{
 

    //设置属性
    public function prize_add(){
        exit;
 
            $list = Db::name('lucky_prize')->select();
            $this->assign('list',$list);
            return $this->fetch();
 
    }

    //保存奖品
    public function prize_addAjax(){
        $data['prize'] = input("prize");
        $data['odds'] = input("odds");
        $number = input("number");
        $data['number'] = $number;
        $data['remain_num'] = $number;
        $data['add_time'] = time();

        $pr_id = input("prize_id");
        if(!empty($pr_id)){ 
            Db::name('lucky_prize')->where('id',$pr_id)->update($data);
            return $this->success('修改成功');
        }else{
            $result = Db::name('lucky_prize')->add($data);
            if($result){
                return $this->success('编辑成功');
            }else{
                return $this->error('编辑失败');
            }
        }
    }
  
    //抽奖记录
    public function result_log(){
        exit;
      $q = input('q');
      $map=array();
      if (!empty($q)) {
        $map['u.mobile'] = ['like','%'.mb_convert_encoding($q, "UTF-8", "auto").'%'];
      }    
      //筛选用户状态
      $status   = input('status');
      if($status==1){
        $map['l.is_win'] = array('not in','0,4,5,6,7,8');
      }
      if($status==2){
        $map['l.is_win'] = array('in','0,4,5,6,7,8');
      }
          $list = Db::name('lucky_results')
          ->alias('l')
          ->join('users u','u.id= l.member_id','LEFT')
          ->where($map)
          ->order("l.add_time desc")
          ->field('l.*,u.nickname,u.mobile')
          ->distinct(true)
          ->paginate(20);
 
        $this->assign('list', $list);
        return $this->fetch();
    }


    /**
	 * 奖品发放确认
     * @return type
     */
    public function get_result_sure()
    {
        $rid = input("rid");
        if($rid){
            $rs = Db::name('lucky_results')->where('id',$rid)->find(); 
            if($rs){
                if($rs['is_win'] != 0){
                    if($rs['is_sure']!=0){
                        $msg = array('code'=>400,'msg'=>'奖品已发');
                    }else{
                        //更新
                        $data['is_sure'] = 1;
                        $data['bj_time'] = time();
                       Db::name('lucky_results')->where('id',$rid)->update($data); // 根据条件保存修改的数据
                        $msg = array('code'=>200,'msg'=>'操作成功，奖品已发');
                    }
                }else{
                    $msg = array('code'=>500,'msg'=>'用户未中奖');
                }
            }else{
                $msg = array('code'=>404,'msg'=>'记录不存在');
            }
        }
        exit(json_encode($msg));
 
    }
 

}