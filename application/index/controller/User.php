<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 矢志bu渝 <745152620@qq.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Loader;
use think\Request;
use common\library\Mini;
use think\File;
use think\Route;

/**
 * 前台用户控制器
 * @author  矢志bu渝
 */
class User extends Common
{
    protected function _initialize()
    {
       parent::_initialize();

        $userInfo   = Db::name('Users')->where('id',UID)->find();
        if(empty($userInfo['nickname']) && !in_array(ACTION_NAME,array('editnickname'))){
            $this->redirect(url('user/editnickname'));
        }
        $request = Request::instance();
        // 获取当前域名
        $domain = $request->domain().'/';
        $this->assign('domain',$domain);
       
    }
 
    /**
     * 个人中心
     * @author  ILsunshine
     */
    public function userCenter(){
        $userInfo   = Db::name('Users')->where('id',UID)->find();
        $gp_user = Db::name('gongpai')->where(['uid' => UID,'is_chuju' => 1])->find();

        if($gp_user){
            $user_friends = Db::name('gongpai')->where('panhao ='.$gp_user['panhao'].' and jibie <'.$gp_user['jibie'].' and lunshu ='.$gp_user['lunshu'])->count();
            $this->assign('is_gongpai',1);
            $this->assign('gp_user',$gp_user);
        }else{
            $user_friends = 0;
            $this->assign('is_gongpai',0);
        }
        $tuijianrenl   = Db::name('Users')->where('id',$userInfo['reid'])->find();
        $tuijianren=substr_replace($tuijianrenl['mobile'],'****',3,4);
        $ytixian   = Db::name('user_withdrawal')->where('uid',UID)->where('status',1)->sum('amount');
        $this->assign('ytixian',$ytixian);
        $this->assign('tuijianren',$tuijianren);
        $userInfo['mobile']=substr_replace($userInfo['mobile'],'****',3,4);
        $this->assign('userInfo',$userInfo);

        $this->assign('hys',$user_friends);

        $zt_count   = Db::name('Users')->where(['reid'=>UID,'status'=>1])->count();
        $this->assign('zt_count',$zt_count);
        $scoreorder=Db::name('user_scoreorder')->where('status',1)->order('paytime desc')->limit(0,20)->select();
        foreach ($scoreorder as $key => &$value) {
            $userinfo=Db::name('users')->where('id',$value['uid'])->find();
            $value['nickname']=$userinfo['nickname'];
        }
 

        $this->assign('scoreorder',$scoreorder);
        return $this->themeFetch('user_center');
    }
    
    /**
     * 修改密码
     * @author  
     */
    public function editPassword() {
        
        if (Request::instance()->isPost()) {
            //获取参数          
            $password               =   input('post.password');
            $newpassword            =   input('post.newpassword');
            $repassword             =   input('post.repassword');
            $userInfo = Db::name('Users')->where('id',UID)->find();            
            //验证密码            
            if (minishop_md5($password,$userInfo['salt']) != $userInfo['password']) {                
                return $this->error('密码不正确');
            } 
            if(minishop_md5($newpassword,$userInfo['salt']) == $userInfo['password']){
                return $this->error('新密码不能与原密码相同');            
            }            
            // 实例化验证器
            $validate = Loader::validate('User');
            // 验证数据
            $data = [
                'password'          => $password,
                'newpassword'       => $newpassword,
                'repassword'        => $repassword,
            ];
            // 验证
            if (!$validate->scene('password')->check($data)) {
                return $this->error($validate->getError());
            }            
            $newpassword=minishop_md5($newpassword,$userInfo['salt']);                  
            $res = Db::name('Users')->where('id',UID)->update(['password'=>$newpassword]);  
            if ($res) {
                return $this->success('修改密码成功！',url('user/userCenter'));
            } else {
                return $this->error('修改失败！');
            }
        } else {
            return $this->themeFetch('edit_pass');
        }
    }
    /**
     * 修改手机号
     * @author  xuelang
     */
    public function editMobile() {
        
        if (Request::instance()->isPost()) {         
            $mobile    =   input('post.mobile'); 
            if(!preg_match("/^1[34578]{1}\d{9}$/",$mobile)){
                return $this->error('手机号格式不正确');
            }
            $code    = input('post.code');
            
            //校验验证码
            $res = $this->checkcode($code,$mobile);  
            if($res==true){
                // 验证手机号是否存在
                $hasMobile = Db::name('Users')->where('mobile',$mobile)->find();
                if($hasMobile) {
                    return $this->error('手机号已存在');
                }    
                $res = Db::name('Users')->where('id',UID)->update(['mobile'=>$mobile]);  
                if($res) {
                    return $this->success('修改手机号成功！');
                } else {
                    return $this->error('修改失败！');
                }

            }                  

        } else {
            $userInfo = Db::name('Users')->where('id',UID)->find();
            $userInfo['mobile'] = substr_replace($userInfo['mobile'],'****',3,4);
            $this->assign('userInfo',$userInfo);
            return $this->themeFetch('edit_mobile');
        }
    }
    /**
     * 验证码校验方法
     * @author  完美°ぜ界丶
     */
    public function checkcode($code,$mobile)
    {   
        $mobile = $mobile;
        $code   = $code;     
        $now_time =  time();//输入验证码的时间
        $yz       =  Db::name('Code')->where('mobile',$mobile)->field('yzm_time,code,num')->find();
        $time     =  $now_time-$yz['yzm_time'];
        //检验是否输入
        if(!($code)) {
            return $this->error('请输入验证码');
        } else if($this->updateNum()== 0) {
            return $this->error('输入次数超过限制，请重新获取');
        } else if($time>config('sms_expiry')) {
            //检验是否过期
            return $this->error('验证码已过期');
        } else if($code!==$yz['code']) {
            return $this->error('验证码错误');
        } else {
            Db::name('Code')->where('mobile',$mobile)->update(['code'=>$code,'yzm_time'=>$now_time]);
            return true;
        }
    }
     /**
     * 更新验证码输入次数
     * @author 完美°ぜ界丶
     */
     protected function updateNum()
     {
        //接收输入
        $mobile = input('post.mobile');
        $res = Db::name('Code')->where('mobile',$mobile)->find();
        $res['num'] = $res['num']+1;
        if($res['num']>config('sms_num')){ 
            return 0; 
        } else {
            Db::name('Code')->where('mobile',$mobile)->update(['num'=>$res['num']]);
            return 1;
        }

     }
    /**
     * 修改昵称
     * @author  xuelang
     */
    public function editNickname() {
        
        if (Request::instance()->isPost()) {
         
            $nickname    =   input('post.nickname');
            if(empty($nickname)){
                return $this->error('昵称不能为空！');
            }                        
            $res = Db::name('Users')->where('id',UID)->update(['nickname'=>$nickname]);  
            if($res) {
                return $this->success('修改昵称成功！',url('user/userCenter'));
            } else {
                return $this->error('修改失败！');
            }
        } else {
            $userInfo = Db::name('Users')->where('id',UID)->find();
            $this->assign('userInfo',$userInfo);
            return $this->themeFetch('edit_nickname');
        }
    }

   
    public function upload()
    {
         
        return upload();
    }

    /**
     * 个人资料
     * @author  xuelang
     */
    public function userProfile() {

         
        if (Request::instance()->isPost()) {
            $file = request()->file('image_url');
            // 移动到框架应用根目录/public/uploads/ 目录下
               if($file){
                   $pic_url = 'uploads' . DS . 'picture'.'\\';
                   $info = $file->move(ROOT_PATH . $pic_url);
                   if($info){

                       // 成功上传后 获取上传信息
                       // 输出 jpg
                       // echo $info->getExtension();
                       // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                       $pic =$pic_url.$info->getSaveName();
                       // 输出 42a79759f284b767dfcb2a0197904287.jpg
                       // echo $info->getFilename(); 
                   }else{
                       // 上传失败获取错误信息
                       echo $file->getError();
                   }
               }
          
            $name = input('post.name');
            $zhifubao = input('post.zhifubao');
            $weixinhao = input('post.weixinhao'); 
            $address = input('post.address');                   
            $res = Db::name('Users')->where('id',UID)->update(['zsname'=>$name,'zhifubao'=>$zhifubao,'weixinhao'=>$weixinhao,'address'=>$address,'pic'=>$pic]);  
            if($res) {
                return $this->success('修改资料成功！',url('user/userCenter'));
            } else {
                return $this->error('修改失败！');
            }
        } else {  
            $userInfo = Db::name("Users")->where('id',UID)->find();
            $this->assign('userInfo',$userInfo);
            return $this->themeFetch('user_profile');
        }
    }
    /**
     * 转赠
     * @author  xuelang
     */
    public function turnadd() { 
        $web_score_zdzr=config('web_score_zdzr');//一次转入限制
        $web_score_bkzc=config('web_score_bkzc');//不可转出时间
        $web_user_bdscore=config('web_user_bdscore');//保底积分
        $this->assign('web_score_bkzc',$web_score_bkzc);
        $userInfo = Db::name("Users")->where('id',UID)->find();
        $kzjf=score_ky(UID);
        if (Request::instance()->isPost()){
            $mobile = input('post.mobile');
            $zzfs = input('post.zzfs');
            $dlmm = input('post.dlmm');
            $users = Db::name("Users")->where('mobile',$mobile)->find();
            if($userInfo['status']==2){
                 return $this->error('您的账户已封停');
            }
            if($users['id']==UID){
                return $this->error('自己不能转自己');
            }
            if(empty($users)){
                return $this->error('该用户不存在');
            }
            if(empty($mobile) && empty($zzfs) && empty($dlmm)){
                return $this->error('信息不能为空');
            }
            if(empty($users['zsname']) && empty($users['zhifubao']) && empty($users['weixinhao'])){
                return $this->error('对方未完善资料');
            }
	        if($users['status']==2){
                 return $this->error('该用户已封停');
            }
            if($web_score_zdzr>0 && $web_score_zdzr<$zzfs){
                return $this->error('一次最多交易'.$web_score_zdzr);
            }
            if($zzfs>$kzjf){
                return $this->error('最多可转'.$kzjf);
            }
            if (minishop_md5($dlmm,$userInfo['salt']) != $userInfo['password']) {                
                return $this->error('密码不正确');
            }
            $userinfo_df = Db::name("Users")->where('mobile',$mobile)->find();

            Db::startTrans();
            //转赠结算

            $jiesuan_zj=jiesuanscore(UID,strtotime("+1 day"));//结算自己积分
            $users_zj=up_score(UID,$userinfo_df['id'],-$zzfs,'转出 (OK)',time());//减少自己积分
            
            if($userinfo_df['score']>=$web_user_bdscore && $userinfo_df['settlement_time']>time() && $userinfo_df['is_jh']==1){
                jiesuanscore($userinfo_df['id'],strtotime("+1 day"));//结算对方积分
            }            
            $users_df=up_score($userinfo_df['id'],UID,$zzfs,'转入 (OK)',time());//减少自己积分
 

            if(($userinfo_df['score']+$zzfs)>=$web_user_bdscore && $userinfo_df['is_jh']==1 && $userinfo_df['settlement_time']<time()){
                Db::name('Users')->where(['id'=>$userinfo_df['id']])->update(['settlement_time' => strtotime("+1 day")]);
            }

            if($jiesuan_zj && $users_zj && $users_df){
                 Db::commit(); // 提交事务
                  return $this->success('转赠成功！',url('user/userCenter'));
             }else{
                // 回滚事务
                Db::rollback();
                return $this->error('转赠失败！');
             }
 
        } else {  

            $score_c = $kzjf;
            if($web_score_zdzr>0 && $web_score_zdzr<$kzjf){
                $score_c = $web_score_zdzr;
            }
            $this->assign('kzjf',$kzjf);
            $this->assign('score_c',$score_c);
            $this->assign('userInfo',$userInfo);
            return $this->themeFetch('turn_add');
        }
       
    }
    /**
     * 积分详情
     * @author  xuelang
     */
    public function score_detail(){
        $list = Db::name('user_score_log')
                ->alias('a')
                ->join('users b','b.id= a.dfuid','LEFT')
                ->where('a.uid',UID)
                ->field('a.*,b.nickname,b.mobile')
                ->order('a.addtime desc')->paginate(20);
 
        // 获取分页显示
        $page = $list->render();         
        $this->assign('page',$page);
        $this->assign('lists',$list);
        return $this->themeFetch('score_detail');
    }
    /**
     * 资金详情
     * @author  xuelang
     */
    public function money_detail() { 

        $list = Db::name('user_money_log')->where('uid',UID)->where('type','NEQ',2)->order('addtime desc')->paginate(20);
 
        // 获取分页显示
        $page = $list->render();         
        $this->assign('page',$page);
        $this->assign('lists',$list);
        return $this->themeFetch('money_detail');
    } 

    /**
     * 推广链接
     * @author  xuelang
     */
    public function user_link() { 
        $user_gongpai = Db::name('gongpai')->where(['uid'=>UID])->find();
        if(empty($user_gongpai)){
            return $this->error('购买公排产品后才能邀请好友!');
        }
        return $this->themeFetch('user_link');
    } 
  	public function user_qrcode() {
        $uid=UID;
      	$user_gongpai = Db::name('gongpai')->where(['uid'=>UID])->find();
        if(empty($user_gongpai)){
            return $this->error('购买公排产品后才能邀请好友!');
        }
        $this->tuiguangqrcode();
        $this->assign('uid',$uid);
        return $this->themeFetch('user_qrcode');
    }
    public function tuiguangqrcode(){
        $uid=UID;
        $userinfo = Db::name("Users")->where('id',$uid)->find();

        $user_gongpai = Db::name('gongpai')->where(['uid'=>UID])->find();
        if(empty($user_gongpai)){
            return $this->error('购买公排产品后才能邀请好友!');
        }
        ob_clean();
        $url='http://'.$_SERVER['HTTP_HOST'].url('base/register',array('reid'=>$uid));
        $base_name = './uploads/qrcode/tuiguang.png';
        @unlink ('./uploads/qrcode/qrcode'.$uid.'.png');
        $path=qrcode($url,'./uploads/qrcode/qrcode'.$uid.'.png');
        header('Content-Type: image/png');
        // Load 
        $thumb = imagecreatefrompng($base_name);
        $e_p = imagecreatefrompng($path);
        $width=imagesx($e_p);
        $height=imagesy($e_p);
        imagecopyresampled($thumb, $e_p, 171, 563, 0, 0, 379, 379, $width, $height);

        $black = imagecolorallocate($thumb, 255,255,255);
        imagettftext($thumb, 22, 0, 215, 1010, $black, './themes/default/index/fonts/msyh.ttf', '推荐人：'.substr_replace($userinfo['mobile'],'****',3,4)); //输出一个灰色的字符串作为阴影
        // Output
        imagejpeg($thumb,'./uploads/qrcode/tg'.$uid.'.jpg');
        imagedestroy($thumb);           
    }
    /**
     * 绑定微信
     * @author  xuelang
     */
    public function user_wxbd() {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') == false ) {
             return $this->error('请在微信中打开');
        }  
        import('org.util.pay.WxPayPubHelper.WxPayPubHelper');   
        $jsApi    = new \JsApi_pub();   
        $openid   = "";
        // 通过code获得openid
        if (!isset($_GET['code'])) {
            // 触发微信返回code码
            $enterUrl = config('enter_url').'/index/user/user_wxbd.html';
            $url="https:open.weixin.qq.com/connect/oauth2/authorize?appid=".config('wechat_appid')."&redirect_uri=".$enterUrl."&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
            Header("Location:$url");
            exit();
        } else {       
            // 获取code码，以获取openid
            $code    = $_GET['code'];       
            $api = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".config('wechat_appid')."&secret=".config('wechat_appsecret')."&code=$code&grant_type=authorization_code";

            $data = json_decode(file_get_contents($api),true);
            $openid = $data['openid'];//获取到的openid
            $access_token = $data['access_token'];
        }
        //获取到openid
        if($openid){
                $url = 'https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'&lang=zh_CN';
                $result = curl_file_get_contents($url);
                $dataa['nickname']       = $result['nickname'];
                $dataa['wechat_openid']  = $openid;
                $dataa['timg']       = $result['headimgurl'];
                $id = Db::name('Users')->where('id',UID)->update($dataa);

                if($id){
                    return $this->success('绑定成功',url('user/userCenter'));
                }else{
                    return $this->error('微信绑定失败！',url('user/userCenter'));
                }
        }else{
            return $this->error('绑定失败！');
        }
    }

    //全球业绩分红
    public function user_fenhong(){
        config(select_key_value('config.base'));
    	$web_fenhong_num=config('web_fenhong_num');//会员奖励最多发放次数
        $web_qqfh_money=config('web_qqfh_money');//用于股权分红的总金额
        $web_scyj_money=config('web_scyj_money');//用于总业绩分红的总金额

        //查询符合钻石区分红条件人数
        $zuanshi_count = DB::name('users')->where('zt_num >= 5 and zt_num < 10 and fenhong1 < '.$web_fenhong_num)->count();
        if($zuanshi_count){
            $zuanshi_zong_fafang = round($web_qqfh_money * config('web_fanli_1') / 100,2);//计算出钻石区实际发放的金额;
            $zuanshi_user_fafang = $zuanshi_zong_fafang / $zuanshi_count;//计算出每个会员应发的金额
            $zuanshi_user_fafang =  round($zuanshi_user_fafang,2);
        }else{
            $zuanshi_zong_fafang = round($web_qqfh_money * config('web_fanli_1') / 100,2);//计算出钻石区实际发放的金额;            
            $zuanshi_user_fafang = 0;
            
        }


          //查询符合金钻区分红条件人数      
          $jinzuan_count = DB::name('users')->where('zt_num >= 10 and zt_num < 20 and fenhong2 < '.$web_fenhong_num)->count();
          if($jinzuan_count){
              $jinzuan_zong_fafang = round($web_qqfh_money * config('web_fanli_2') / 100,2);//计算出钻石区实际发放的金额;
              $jinzuan_user_fafang = $jinzuan_zong_fafang / $jinzuan_count;//计算出每个会员应发的金额
              $jinzuan_user_fafang =  round($jinzuan_user_fafang,2); 
          }else{
            $jinzuan_zong_fafang = round($web_qqfh_money * config('web_fanli_2') / 100,2);//计算出钻石区实际发放的金额;            
            $jinzuan_user_fafang = 0;
            
            }
       
        
               //查询符合银冠区分红条件人数  
          $yinguan_count = DB::name('users')->where('zt_num >= 20 and zt_num < 30 and fenhong3 < '.$web_fenhong_num)->count();
          if($yinguan_count){
              $yinguan_zong_fafang = round($web_qqfh_money * config('web_fanli_3') / 100,2);//计算出钻石区实际发放的金额;
              $yinguan_user_fafang = $yinguan_zong_fafang / $yinguan_count;//计算出每个会员应发的金额
              $yinguan_user_fafang =  round($yinguan_user_fafang,2);
          }else{
            $yinguan_zong_fafang = round($web_qqfh_money * config('web_fanli_3') / 100,2);//计算出钻石区实际发放的金额;            
            $yinguan_user_fafang = 0;
            
            }

            //查询符合金冠区分红条件人数
          $jinguan_count = DB::name('users')->where('zt_num >= 30 and zt_num < 50 and fenhong4 < '.$web_fenhong_num)->count();
          if($jinguan_count){
              $jinguan_zong_fafang = round($web_qqfh_money * config('web_fanli_4') / 100,2);//计算出钻石区实际发放的金额;
              $jinguan_user_fafang = $jinguan_zong_fafang / $jinguan_count;//计算出每个会员应发的金额
              $jinguan_user_fafang =  round($jinguan_user_fafang,2);
       
          }else{
            $jinguan_zong_fafang = round($web_qqfh_money * config('web_fanli_4') / 100,2);//计算出钻石区实际发放的金额;
            $jinguan_user_fafang = 0;//计算出每个会员应发的金额
          }

            //查询符合皇冠区分红条件人数
          $huangguan_count = DB::name('users')->where('zt_num >= 50 and zt_num < 80 and fenhong5 < '.$web_fenhong_num)->count();
          if($huangguan_count){
              $huangguan_zong_fafang = round($web_qqfh_money * config('web_fanli_5') / 100,2);//计算出钻石区实际发放的金额;
              $huangguan_user_fafang = $huangguan_zong_fafang / $huangguan_count;//计算出每个会员应发的金额
              $huangguan_user_fafang =  round($huangguan_user_fafang,2);
          
          }else{
            $huangguan_zong_fafang = round($web_qqfh_money * config('web_fanli_5') / 100,2);//计算出钻石区实际发放的金额;
            $huangguan_user_fafang = 0;//计算出每个会员应发的金额
          }


          //查询符合发放总营业额分红条件人数
          $zong_yy_count = DB::name('users')->where('zt_num >= 80')->count();
          if($zong_yy_count){
              $zong_yy_zong_fafang = round($web_scyj_money * config('web_fanli_6') / 100,2);//计算出钻石区实际发放的金额;
              $zong_yy_user_fafang = $zong_yy_zong_fafang / $zong_yy_count;//计算出每个会员应发的金额
              $zong_yy_user_fafang =  round($zong_yy_user_fafang,2);
          
          }else{
             $zong_yy_zong_fafang = round($web_scyj_money * config('web_fanli_6') / 100,2);//计算出钻石区实际发放的金额;
             $zong_yy_user_fafang = 0;//计算出每个会员应发的金额
          }

  


        $this->assign('zuanshi_zong_fafang',$zuanshi_zong_fafang);
        $this->assign('zuanshi_count',$zuanshi_count);
        $this->assign('zuanshi_user_fafang',$zuanshi_user_fafang);

        $this->assign('jinzuan_zong_fafang',$jinzuan_zong_fafang);
        $this->assign('jinzuan_count',$jinzuan_count);
        $this->assign('jinzuan_user_fafang',$jinzuan_user_fafang);

        $this->assign('yinguan_zong_fafang',$yinguan_zong_fafang);
        $this->assign('yinguan_count',$yinguan_count);
        $this->assign('yinguan_user_fafang',$yinguan_user_fafang);

        $this->assign('jinguan_zong_fafang',$jinguan_zong_fafang);
        $this->assign('jinguan_count',$jinguan_count);
        $this->assign('jinguan_user_fafang',$jinguan_user_fafang);

        $this->assign('huangguan_zong_fafang',$huangguan_zong_fafang);
        $this->assign('huangguan_count',$huangguan_count);
        $this->assign('huangguan_user_fafang',$huangguan_user_fafang);

        $this->assign('zong_yy_zong_fafang',$zong_yy_zong_fafang);
        $this->assign('zong_yy_count',$zong_yy_count);
        $this->assign('zong_yy_user_fafang',$zong_yy_user_fafang);
        
        // $list = Db::name('user_score_log')->where('uid',UID)->where('type','eq',1002)->order('id desc')->paginate(100);
 
        // // 获取分页显示
        // $page = $list->render();         
        // $this->assign('page',$page);
        // $this->assign('lists',$list);
        
        
        return $this->themeFetch('user_fenhong');
    }
    
    //我的好友
    public function user_friends(){ 
    	$page=input('get.page');
        if(empty($page)){  
            $page = 1;
        }else{ 
            $page=input('get.page');
        }
        $size=20;//每页显示的记录数

       $user_info = Db::name('gongpai')->where(['uid'=>UID,'is_chuju'=>1])->find();
        $user_friends = array();
       if($user_info){
           $user_friends = Db::name('gongpai')
           ->alias('g')
           ->join('users u','u.id= g.uid','LEFT')
           ->where('g.panhao ='.$user_info['panhao'].' and g.jibie < '.$user_info['jibie'].' and g.lunshu='.$user_info['lunshu'])
            ->field('g.*,u.nickname,u.mobile')
           ->order('g.id asc')
           ->paginate(32);
       }

        $this->assign('lists',$user_friends); 
       

        return $this->themeFetch('user_friends');
    }


        //我的团队
        public function user_friends1(){ 
            $page=input('get.page');
            if(empty($page)){  
                $page = 1;
            }else{ 
                $page=input('get.page');
            }
            $size=20;//每页显示的记录数
    
           $user_list = Db::name('users')->where(['reid'=>UID,'status'=>1])->select();
           //筛选下级人数
           foreach($user_list as $k=>$v){
                $user_list[$k]['num'] = Db::name('users')->where(['reid'=>$v['id'],'status'=>1])->count();
                 
           }
           $newarr = array_slice($user_list, ($page-1)*$size, $size);
           $config['path']=url('user/user_friends1');
           $list1=\think\paginator\driver\Bootstrap::make($newarr, $size, $page, count($user_list), false, $config);
           $page=$list1->render();
           
            $this->assign('lists',$list1); 
            $this->assign('page',$page);
    
            return $this->themeFetch('user_friends1');
        } 
     //我的团队2
        public function user_friends2(){ 
            $id = input('get.id');
            if(empty($id)){
                 return $this->error('没有下级会员');
            }
            $page=input('get.page');
            if(empty($page)){  
                $page = 1;
            }else{ 
                $page=input('get.page');
            }
            $size=20;//每页显示的记录数
    
           $user_list = Db::name('users')->where(['reid'=>$id,'status'=>1])->select();
            
           $newarr = array_slice($user_list, ($page-1)*$size, $size);
           $config['path']=url('user/user_friends2');
           $list1=\think\paginator\driver\Bootstrap::make($newarr, $size, $page, count($user_list), false, $config);
           $page=$list1->render();
    
            $this->assign('lists',$list1); 
            $this->assign('page',$page);
    
            return $this->themeFetch('user_friends2');
        } 
    /**
     * 提现
     * @author  xuelang
     */
    public function user_withdrawal() {

        if (Request::instance()->isPost()) {
            $money = input('post.money');
            $dlmm = input('post.dlmm');
            if(!is_numeric($money)){
                return $this->error('提现金额错误');
            }
            $money = floatval($money);
            $users = Db::name("Users")->where('id',UID)->find();
            if(empty($money)){
                return $this->error('提现金额不能为空');
            }
            if($money<config('web_tixian_zx')){
                return $this->error('提现金额不小于'.config('web_tixian_zx').'元');
            }
            if($users['zt_num']<config('web_tixian_zt')){
                return $this->error('提现最低需直推'.config('web_tixian_zt').'人');
            }
          /*  if(empty($users['wechat_openid'])){
                return $this->error('请先点击头像绑定微信');
            }*/ 
            if($users['status']!=1){
                return $this->error('您的账号异常,请联系管理员!');
            }
            if(empty($users['zsname']) && empty($users['zhifubao']) && empty($users['weixinhao'])){
                return $this->error('您的个人资料未完善');
            }
            // $uwcount=Db::name('user_withdrawal')->where('uid',UID)->where('addtime','gt',time()-60*60*24)->count();
            // if($uwcount>10){
            //     return $this->error('24小时最多提现10次');
            // }
            if($money>$users['score']){
                return $this->error('最多提现'.$users['score']);
            }
            if (minishop_md5($dlmm,$users['salt']) != $users['password']) {                
                return $this->error('密码不正确');
            } 
            Db::startTrans();
            
            $users_zj=DB::name('Users')->where(['id'=>UID])->update(['score' => ['exp','score-'.$money]]);//减少自己余额
           
            $data['true_amount']=$money-($money*(config('web_tixian_sf')/100));    
            $data['uid']=UID;
            $data['amount']=$money;
            $data['addtime']=time(); 
            $data['status']=0;
            $users_log=DB::name('user_withdrawal')->insert($data);

            if($users_zj && $users_log){
                 Db::commit(); // 提交事务
                  return $this->success('申请成功！',url('user/userCenter'));
             }else{
                // 回滚事务
                Db::rollback();
                return $this->error('申请失败！');
             }
        }else{
            $userinfo = Db::name("Users")->where('id',UID)->find();
            $ytixian   = Db::name('user_withdrawal')->where('uid',UID)->where('status',1)->sum('amount');

            $this->assign('ytixian',$ytixian);
            $this->assign('userinfo',$userinfo);
            $this->assign('tx_zt_num',config('web_tixian_zt'));//提现所需直推人数
            return $this->themeFetch('user_withdrawal'); 
        } 

    }

}


