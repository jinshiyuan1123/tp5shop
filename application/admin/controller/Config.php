<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\Controller;
use think\Request;
use think\Db;

/**
 * 系统用户控制器
 * @author  ILSunshine
 */
class Config extends Common
{
    /**
     * 系统配置
     */
    public function edit()
    {
        if(Request::instance()->isPost()) {              
            $data         = input('post.');
            $collection   = "config.base" ;
            $uuid         = "default" ;
            $result       = update_key_value($collection,$data,$uuid); 

            if($result){
                return $this->success('保存成功');
            }else {
                return $this->error('请选择更新数据');
            }
        }else{
            $collection   = "config.base" ;
            $uuid         = "default" ;
            $list         = select_key_value($collection,$uuid);     
            $this->assign('list',$list);
            return $this->fetch();
        }
    }

    /**
     * 会员分红奖励发放
     */
    public function day_fenhong(){
        config(select_key_value('config.base'));
    	$web_fenhong_num=config('web_fenhong_num');//会员奖励最多发放次数
        $web_qqfh_money=config('web_qqfh_money');//用于股权分红的总金额
        $web_scyj_money=config('web_scyj_money');//用于总业绩分红的总金额

        Db::name("key_value")->where('name = "web_qqfh_money"')->update(['value'=>0]);//全球分红清零
        Db::name("key_value")->where('name = "web_scyj_money"')->update(['value'=>0]);//商城业绩清零

        //查询符合钻石区分红条件人数
        $zuanshi_count = DB::name('users')->where('zt_num >= 5 and zt_num < 10 and fenhong1 < '.$web_fenhong_num)->count();
        if($zuanshi_count){

            $zuanshi_list = DB::name('users')->where('zt_num >= 5 and zt_num < 10 and fenhong1 < '.$web_fenhong_num)->select();

            $zuanshi_zong_fafang = $web_qqfh_money * config('web_fanli_1') / 100;//计算出钻石区实际发放的金额;
            $zuanshi_user_fafang = $zuanshi_zong_fafang / $zuanshi_count;//计算出每个会员应发的金额
            $zuanshi_user_fafang =  round($zuanshi_user_fafang,2);
            foreach($zuanshi_list as $key => $value){
                Db::startTrans();
	    		$gee=Db::name('Users')->where('id',$value['id'])->update(['score' => ['exp','score+'.$zuanshi_user_fafang],'fenhong1' => ['exp','fenhong1+1']]);
	            $zuanshi_data['uid']=$value['id'];
	            $zuanshi_data['dfuid']=0;
	            $zuanshi_data['score']=$zuanshi_user_fafang;
	            $zuanshi_data['type']=1;
	            $zuanshi_data['info']='全球分红奖励发放';
	            $zuanshi_data['addtime']=time();
	            $users_log=DB::name('user_score_log')->insert($zuanshi_data);
	            if($gee && $users_log){
	                 Db::commit(); // 提交事务
	             }else{
	                // 回滚事务
	                Db::rollback();
	             }
                
            }
        }


          //查询符合金钻区分红条件人数      
          $jinzuan_count = DB::name('users')->where('zt_num >= 10 and zt_num < 20 and fenhong2 < '.$web_fenhong_num)->count();
          if($jinzuan_count){

            $jinzuan_list = DB::name('users')->where('zt_num >= 10 and zt_num < 20 and fenhong2 < '.$web_fenhong_num)->select();

              $jinzuan_zong_fafang = $web_qqfh_money * config('web_fanli_2') / 100;//计算出钻石区实际发放的金额;
              $jinzuan_user_fafang = $jinzuan_zong_fafang / $jinzuan_count;//计算出每个会员应发的金额
              $jinzuan_user_fafang =  round($jinzuan_user_fafang,2);
              foreach($jinzuan_list as $key => $value){
                  Db::startTrans();
                  $gee=Db::name('Users')->where('id',$value['id'])->update(['score' => ['exp','score+'.$jinzuan_user_fafang],'fenhong2' => ['exp','fenhong2+1']]);
                  $jinzuan_data['uid']=$value['id'];
                  $jinzuan_data['dfuid']=0;
                  $jinzuan_data['score']=$jinzuan_user_fafang;
                  $jinzuan_data['type']=1;
                  $jinzuan_data['info']='全球分红奖励发放';
                  $jinzuan_data['addtime']=time();
                  $users_log=DB::name('user_score_log')->insert($jinzuan_data);
                  if($gee && $users_log){
                       Db::commit(); // 提交事务
                   }else{
                      // 回滚事务
                      Db::rollback();
                   }
                  
              }
          }
       
        
               //查询符合银冠区分红条件人数  
          $yinguan_count = DB::name('users')->where('zt_num >= 20 and zt_num < 30 and fenhong3 < '.$web_fenhong_num)->count();
          if($yinguan_count){

            $yinguan_list = DB::name('users')->where('zt_num >= 20 and zt_num < 30 and fenhong3 < '.$web_fenhong_num)->select();

              $yinguan_zong_fafang = $web_qqfh_money * config('web_fanli_3') / 100;//计算出钻石区实际发放的金额;
              $yinguan_user_fafang = $yinguan_zong_fafang / $yinguan_count;//计算出每个会员应发的金额
              $yinguan_user_fafang =  round($yinguan_user_fafang,2);
              foreach($yinguan_list as $key => $value){
                  Db::startTrans();
                  $gee=Db::name('Users')->where('id',$value['id'])->update(['score' => ['exp','score+'.$yinguan_user_fafang],'fenhong3' => ['exp','fenhong3+1']]);
                  $yinguan_data['uid']=$value['id'];
                  $yinguan_data['dfuid']=0;
                  $yinguan_data['score']=$yinguan_user_fafang;
                  $yinguan_data['type']=1;
                  $yinguan_data['info']='全球分红奖励发放';
                  $yinguan_data['addtime']=time();
                  $users_log=DB::name('user_score_log')->insert($yinguan_data);
                  if($gee && $users_log){
                       Db::commit(); // 提交事务
                   }else{
                      // 回滚事务
                      Db::rollback();
                   }
                  
              }
          }

            //查询符合金冠区分红条件人数
          $jinguan_count = DB::name('users')->where('zt_num >= 30 and zt_num < 50 and fenhong4 < '.$web_fenhong_num)->count();
          if($jinguan_count){

            $jinguan_list = DB::name('users')->where('zt_num >= 30 and zt_num < 50 and fenhong4 < '.$web_fenhong_num)->select();

              $jinguan_zong_fafang = $web_qqfh_money * config('web_fanli_4') / 100;//计算出钻石区实际发放的金额;
              $jinguan_user_fafang = $jinguan_zong_fafang / $jinguan_count;//计算出每个会员应发的金额
              $jinguan_user_fafang =  round($jinguan_user_fafang,2);
              foreach($jinguan_list as $key => $value){
                  Db::startTrans();
                  $gee=Db::name('Users')->where('id',$value['id'])->update(['score' => ['exp','score+'.$jinguan_user_fafang],'fenhong4' => ['exp','fenhong4+1']]);
                  $jinguan_data['uid']=$value['id'];
                  $jinguan_data['dfuid']=0;
                  $jinguan_data['score']=$jinguan_user_fafang;
                  $jinguan_data['type']=1;
                  $jinguan_data['info']='全球分红奖励发放';
                  $jinguan_data['addtime']=time();
                  $users_log=DB::name('user_score_log')->insert($jinguan_data);
                  if($gee && $users_log){
                       Db::commit(); // 提交事务
                   }else{
                      // 回滚事务
                      Db::rollback();
                   }
                  
              }
          }

            //查询符合皇冠区分红条件人数
          $huangguan_count = DB::name('users')->where('zt_num >= 50 and zt_num < 80 and fenhong5 < '.$web_fenhong_num)->count();
          if($huangguan_count){

            $huangguan_list = DB::name('users')->where('zt_num >= 50 and zt_num < 80 and fenhong5 < '.$web_fenhong_num)->select();

              $huangguan_zong_fafang = $web_qqfh_money * config('web_fanli_5') / 100;//计算出钻石区实际发放的金额;
              $huangguan_user_fafang = $huangguan_zong_fafang / $huangguan_count;//计算出每个会员应发的金额
              $huangguan_user_fafang =  round($huangguan_user_fafang,2);
              foreach($huangguan_list as $key => $value){
                  Db::startTrans();
                  $gee=Db::name('Users')->where('id',$value['id'])->update(['score' => ['exp','score+'.$huangguan_user_fafang],'fenhong5' => ['exp','fenhong5+1']]);
                  $huangguan_data['uid']=$value['id'];
                  $huangguan_data['dfuid']=0;
                  $huangguan_data['score']=$huangguan_user_fafang;
                  $huangguan_data['type']=1;
                  $huangguan_data['info']='全球分红奖励发放';
                  $huangguan_data['addtime']=time();
                  $users_log=DB::name('user_score_log')->insert($huangguan_data);
                  if($gee && $users_log){
                       Db::commit(); // 提交事务
                   }else{
                      // 回滚事务
                      Db::rollback();
                   }
                  
              }
          }


          //查询符合发放总营业额分红条件人数
          $zong_yy_count = DB::name('users')->where('zt_num >= 80')->count();
          if($zong_yy_count){

            $zong_yy_list = DB::name('users')->where('zt_num >= 80')->select();

              $zong_yy_zong_fafang = $web_scyj_money * config('web_fanli_6') / 100;//计算出钻石区实际发放的金额;
              $zong_yy_user_fafang = $zong_yy_zong_fafang / $zong_yy_count;//计算出每个会员应发的金额
              $zong_yy_user_fafang =  round($zong_yy_user_fafang,2);
              foreach($zong_yy_list as $key => $value){
                  Db::startTrans();
                  $gee=Db::name('Users')->where('id',$value['id'])->update(['score' => ['exp','score+'.$zong_yy_user_fafang]]);
                  $zong_yy_data['uid']=$value['id'];
                  $zong_yy_data['dfuid']=0;
                  $zong_yy_data['score']=$zong_yy_user_fafang;
                  $zong_yy_data['type']=1;
                  $zong_yy_data['info']='商城业绩分红奖励发放';
                  $zong_yy_data['addtime']=time();
                  $users_log=DB::name('user_score_log')->insert($zong_yy_data);
                  if($gee && $users_log){
                       Db::commit(); // 提交事务
                   }else{
                      // 回滚事务
                      Db::rollback();
                   }
                  
              }
          }

    }
 
}
   

