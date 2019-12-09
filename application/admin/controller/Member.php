<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 完美°ぜ界丶 
// +----------------------------------------------------------------------
namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Input;
use think\Loader;
use think\Request;

/**
 * 系统用户控制器
 * @author  完美°ぜ界丶 
 */
class Member extends Common
{        
  public function index()
  {  
      //搜索词
      $q = input('q');
      if (!empty($q)) {
        $map['mobile'] = ['like','%'.mb_convert_encoding($q, "UTF-8", "auto").'%'];
      }    
      //筛选用户状态
      $status   = input('status');
      $ksjf = input('ksjf');
      $jzjf = input('jzjf');
      if (!empty($status)) {
        $map['status'] = $status;
      } 
      if (!empty($ksjf) && !empty($jzjf)) {
        $map['score'] = ['BETWEEN',[$ksjf,$jzjf]];
      }  
      //条件为空赋值
      if (empty($map)) {
        $map = 1;
      }
      //会员列表  
      $userList = Db::name('Users')
      ->where($map)
      ->order("id desc")
      ->distinct(true)
      ->paginate(10);
 
      $this->assign('userList',$userList);
      return $this->fetch('index');
  }

  public function gongpai_xinxi()
  {  
      //搜索词
      $q = input('q');
      if (!empty($q)) {
        $map['u.mobile'] = ['like','%'.mb_convert_encoding($q, "UTF-8", "auto").'%'];
      }    
      //筛选用户状态
      $status   = input('status');
      $ksjf = input('ksjf');
      $jzjf = input('jzjf');
      if (!empty($status)) {
        $map['u.status'] = $status;
      } 
      if (!empty($ksjf) && !empty($jzjf)) {
        $map['u.score'] = ['BETWEEN',[$ksjf,$jzjf]];
      }  
      //条件为空赋值
      if (empty($map)) {
        $map['g.is_chuju'] = 1;
      }
      //会员列表  
      $userList = Db::name('Users')
      ->alias('u')
      ->join('gongpai g','u.id= g.uid','LEFT')
      ->where($map)
      ->order("u.id desc")
      ->field('u.*,g.jibie,g.bcsx,g.money')
      ->distinct(true)
      ->paginate(10);
 
      $this->assign('userList',$userList);
      return $this->fetch('gongpai_xinxi');
  }

  public function jihuo($uid)
  {     
    exit;
        if(empty($uid)){
          return $this->error('系统错误');
        }
        Db::startTrans();
        $user_id = Db::name('Users')->where(['id'=>$uid])->find();
        if($user_id['is_jh']==1){
          return $this->error('已经激活');
        }
        $user_isjh = Db::name('Users')->where(['id'=>$uid])->update(['is_jh' => 1]);
        $bdscore=config('web_user_bdscore');//保底积分
        if(config('web_jihuo_df')==1){
          $up_score=up_score($uid,0,config('web_user_bdscore'),'激活赠送',time());//减少自己积分
          $up_time=Db::name('Users')->where(['id'=>$uid])->update(['settlement_time' => strtotime("+1 day"),'jhtime' => time()]);
        }else{
          if($user_id['score']>=$bdscore){
            $up_score=true;
            $up_time=Db::name('Users')->where(['id'=>$uid])->update(['settlement_time' => strtotime("+1 day"),'jhtime' => time()]);
          }else{
             $up_score=true;
             $up_time=Db::name('Users')->where(['id'=>$uid])->update(['jhtime' => time()]);
          }
        }

        jihuofanli($uid);//所有上9级返利

        if($user_isjh && $up_score && $up_time){
          Db::commit();
          return $this->success('激活成功',url('admin/member/index'));
        }else{
          Db::rollback();
          return $this->error('激活失败');
        }
  }

  public function user_friends($id)
  {
    exit;
          $usersInfo = Db::name('Users')->where('id',$id)->find();              
          $this->assign('usersInfo',$usersInfo);
        $page=input('get.page');
      if(empty($page)){  
            $page = 1;
        }else{ 
            $page=input('get.page');
        }
        $size=1;//每页显示的记录数

        $user_friends=friends_x9($id);
        $newarr = array_slice($user_friends, ($page-1)*$size, $size);

        $class = '\\think\\paginator\\driver\\Bootstrap'; 
        $config['path']=url('member/user_friends',array('id'=>$id));
        $list=\think\paginator\driver\Bootstrap::make($newarr, $size, $page, count($user_friends), false, $config);
 
        $this->assign('lists',$list);
      return $this->fetch('user_friends');
  }
  /**
   ** @author 完美°ぜ界丶
   *  编辑会员
   */
    public function edit($id)
    {
       if (Request::instance()->isPost()) {
            $data          = input('post.');           
            // 实例化验证器
            $validate = Loader::validate('Member');                
            // 验证数据
            // 验证
            if (!$validate->scene('edit')->check($data)) {
                return $this->error($validate->getError());
             } 
            $getStatus     = Db::name('Users')->where('id',$data['id'])->update($data);
            if($getStatus !== false){
                return $this->success('编辑成功',url('admin/member/index'));
            } else {
                  return $this->error('编辑失败');
              }
      } else {
        // 查询单条数据
              if (empty($id)) {
              return $this->error('请选择有效数据');
          }   
          $map['id']     = $id;          
          $usersInfo      = Db::name('Users')->where($map)->find();              
          $this->assign('usersInfo',$usersInfo);
          return $this->fetch('edit');
      }
    }

  /**
   *设置会员状态
   * 1:正常
   * 2:禁用
   * -1:删除
   * @author 完美°ぜ界丶
   */
  public function setStatus()
  {
    // config(select_key_value('config.base'));
    $status    = input('post.status');
    $userids   = input('post.ids/a');
    if (!in_array($status,['1','2'])) {
      return $this->error('请选择操作类型');
    }
    // $m_fll=config('web_score_fulilv')/(60*60*24);//每秒复利率%

      foreach ($userids as $key => $value) {
          if($status=='2'){
              Db::name('Users')->where('id',$value)->update(['status'=>2]);
         }else{  
                Db::name('Users')->where('id',$value)->update(['status'=>1]);   
         }
      }
      return $this->success('修改成功！');
    

  }

  /*编辑会员密码*/
  public function editPass($id) 
  {
    $id=$id;
    if (Request::instance()->isPost()) {
      $data     =  input('post.');
      
      //实例化验证器
      $validate =  Loader::validate('Member');
      //验证数据
      if (!$validate->scene('editPass')->check($data)) {
          return $this->error($validate->getError());
      } 

      $salt = Db::name('Users')->where('id',$id)->field('salt')->find();

      $password = minishop_md5($data['repassword'],$salt['salt']);
    
      $getStatus     = Db::name('Users')->where('id',$data['id'])->update(['password'=>$password]);
      
      if($getStatus !== false){
         return $this->success('编辑成功',url('admin/member/index'));
      } else {
         return $this->error('编辑失败');
      }
    } 
  }
  /*编辑积分*/
  public function score($id) 
  { 
       if (Request::instance()->isPost()) {
            $data          = input('post.');
            $data['score'] = floatval($data['score']);
            if(empty($data['score'])){
              return $this->error('不能为空或0');
            }

            Db::startTrans();
            $userinfo = Db::name("Users")->where('id',$data['id'])->find();
            if($data['score']<0 && ($userinfo['score']+$data['score']) < 0){
              return $this->error('太低了');
            }       
            $users=up_score($data['id'],0,$data['score'],'管理员调整',time());//更新积分        
            if($users){
                 Db::commit(); // 提交事务
                  return $this->success('编辑成功',url('admin/member/score',array('id'=>$data['id'])));
             }else{
                // 回滚事务
                Db::rollback();
                return $this->error('编辑失败');
             }
 
      }else{
          $map['id']     = $id;  
          $usersInfo      = Db::name('Users')->where($map)->find();              
          $this->assign('usersInfo',$usersInfo);
           return $this->fetch('score');
      }

  }

  public function withdrawal(){
      //搜索词
      $q = input('q');
      if (!empty($q)) {
        $map['u.mobile'] = ['like','%'.mb_convert_encoding($q, "UTF-8", "auto").'%'];
      }    
      //筛选用户状态
      $status   = input('status');
      if (!empty($status)) {
        $map['w.status'] = $status;
      }  
      //条件为空赋值
      if (empty($map)) {
        $map = 1;
      }
      //会员列表  
      $userList = Db::name('user_withdrawal')
      ->alias('w')
      ->join('users u','u.id= w.uid','LEFT')
      ->where($map)
      ->order("w.addtime desc")
      ->field('w.*,u.zsname,u.mobile,u.weixinhao,u.zhifubao')
      ->distinct(true)
      ->paginate(10);
      $this->assign('userList',$userList);

      return $this->fetch('withdrawal');
   
  }
  /**
   *设置提现状态
   * 1:已提现
   * 2:取消
   * @author 完美°ぜ界丶
   */
  public function withdrawal_setStatus()
  {
    $status    = input('post.status');
    $userids   = input('post.ids/a');
    if (!in_array($status,['1','2'])) {
      return $this->error('请勾选需要操作的提现');
    }
    
      foreach ($userids as $key => $value) {

        $user_withdrawal  = Db::name('user_withdrawal')->where('id',$value)->find();
        if($user_withdrawal['status']==0){
          if($status==2){
            Db::startTrans();
            $userwith  = Db::name('user_withdrawal')->where('id',$value)->update(['status'=>$status]);
            $users_amount = DB::name('Users')->where(['id'=>$user_withdrawal['uid']])->update(['score' => ['exp','score+'.$user_withdrawal['amount']]]);//提现失败返回余额

            $data2['uid']    = $user_withdrawal['uid'];
            $data2['dfuid']   = 0;
            $data2['score'] = abs($user_withdrawal['amount']);
            $data2['type']   = 0;
            $data2['info']   = '申请提现';
            $data2['addtime']=$user_withdrawal['addtime'];
            $ordersStatusResult2 = Db::name('user_score_log')->insert($data2); 

            $data['uid']    = $user_withdrawal['uid'];
            $data['dfuid']   = 0;
            $data['score'] = abs($user_withdrawal['amount']);
            $data['type']   = 1;
            $data['info']   = '提现失败返回';
            $data['addtime']=time();
            $ordersStatusResult = Db::name('user_score_log')->insert($data);

            if($userwith && $users_amount && $ordersStatusResult && $ordersStatusResult2){
                     Db::commit(); // 提交事务
                 }else{
                    // 回滚事务
                    Db::rollback();
             }
         }else{
            Db::startTrans();
            $userwith=Db::name('user_withdrawal')->where('id',$value)->update(['status'=>$status]);
            $data['uid']    = $user_withdrawal['uid'];
            $data['dfuid']   = 0;
            $data['score'] = abs($user_withdrawal['amount']);
            $data['type']   = 0;
            $data['info']   = '提现成功';
            $data['addtime']=time();
            $log=Db::name('user_score_log')->insert($data);
            if($log && $userwith){
                     Db::commit(); // 提交事务
                 }else{
                    // 回滚事务
                    Db::rollback();
             }
         }
        }
      }
      return $this->success('修改成功！');


    

  }
   //资金明细
   public function turnadd(){
    //搜索词
    $q = input('q');
    if (!empty($q)) {
      $map['u.id|u.mobile'] = mb_convert_encoding($q, "UTF-8", "auto");
    }else{
    $map = 1; 
  }


    //$map['l.dfuid'] = ['gt',0];
    //$map['l.info']='转出 (OK)';
        //会员列表  
    $score_log = Db::name('user_score_log')
        ->alias('l')
        ->join('users u','u.id= l.uid','LEFT')
        ->join('users s','s.id= l.dfuid','LEFT')
        ->where($map)
        ->order("l.addtime desc")
        ->field('l.*,u.mobile,s.mobile as smobile')
        ->distinct(true)
        ->paginate(10);
  $this->assign('userList',$score_log);
   return $this->fetch('turnadd');
}

}