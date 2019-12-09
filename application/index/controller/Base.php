<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Loader;
use think\Request;
use common\library\Mini;

/**
 * 系统基础控制器：不需登录
 * @author  tangtnglove <dai_hang_love@126.com>
 */
class Base extends Mini
{
    var $users = '';
        /**
     * 初始化方法
     * @author tangtanglove
     */
    protected function _initialize()
    {
        $request = Request::instance();
     define('MODULE_NAME', $request->module());
     define('CONTROLLER_NAME', $request->controller());
     define('ACTION_NAME', $request->action());
       
        if (session('wap_user_auth')) {
            define('UID', session('wap_user_auth.uid'));
        } else {
            define('UID', null);
        }
	
        if(!(UID) && !in_array(ACTION_NAME,array('login','register','getpassword','checkcode','captcha','checkcaptcha','updateNum')) && !in_array(CONTROLLER_NAME,array('Wxpay'))){
            $this->redirect(url('base/login'));
        }
        #用户登陆id
        $this->users = session('wap_user_auth');
        config(select_key_value('config.base'));
        $this->assign('userinfo',$this->users);

        load_config();// 加载接口配置
    }

/**
     * 用户登录方法
     * @author  矢志bu渝 <745152620@qq.com>
     */
    public function login()
    {  
        if (Request::instance()->isPost()) {
            $key      = input('post.key');
            $password = input('post.password');

            // 判断账号手机号
                $where['mobile'] = $key;
                $userInfo = Db::name('Users')->where($where)->find();  
       
            if ($userInfo && $userInfo['password'] == minishop_md5($password,$userInfo['salt'])) {
                $session['uid']       = $userInfo['id'];
                $session['nickname']  = $userInfo['nickname'];
                $session['mobile']    = $userInfo['mobile'];
                $session['last_login']= $userInfo['last_login'];                                            
                // 记录用户登录信息
                session('wap_user_auth',$session);
                // 更新最近登录时间
                Db::name('Users')->where($where)->setField('last_login',time());
                return $this->success('登陆成功！',url('user/userCenter'));
            } else {
                return $this->error('用户名或密码错误！');
            }
        } else {
            return $this->themeFetch('login');
        }        
    }

   

    /**
     * 用户注册方法
     * @author  矢志bu渝 <745152620@qq.com>
     */
    public function register()
    {
            $reid = input('get.reid');
            $Users = Db::name('Users')->where('id',$reid)->find(); 
            if(!$Users){
                 return $this->error('无推荐人不可注册');
            }        
        if (Request::instance()->isPost()) {
            // 接收post数据
            $mobile            = input('post.mobile');//手机号
            $password          = input('post.password');//密码
            $repassword        = input('post.repassword');//密码
            $code              = input('post.code');
            
            //校验验证码
            //$res = $this->checkcode($code,$mobile);
            //if($res==true) {
            if(true) {
                // 实例化验证器
                $validate = Loader::validate('Member');                
                // 验证数据
                $data     = [
                    'mobile'  =>$mobile,
                    'password'=>$password,
                    'repassword'=>$repassword,
                ];
                // 验证
                if (!$validate->scene('register')->check($data)) {
                    return $this->error($validate->getError());                 
                }        
                $value['uuid']          = create_uuid();      
                $value['mobile']        = $mobile;
                $value['salt']          = create_salt();
                $value['password']      = minishop_md5($password,$value['salt']);
                $value['regdate']       = time();
                $value['status']        = '1';
                $value['reid']          = $reid;             
                //插入数据表

                $res = Db::name('Users')->insert($value);
                if($res) {
                    return $this->success('注册成功',url('base/login'));
                } else {
                    return $this->error('注册失败');
                } 
            }            
                   
        } else {

            $tjmobile = substr_replace($Users['mobile'],'****',3,4);

            $this->assign('tjmobile',$tjmobile);
            return $this->themeFetch('register');
        }     
        
    }
  
    /**
     * 手机验证码登录方法
     * @author  完美°ぜ界丶
     */
    public function smsLogin()
    {
        if (Request::instance()->isPost()) {
            // 接收post数据
            $mobile = input('post.mobile');
            $code   = input('post.code');
            $captcha = input('post.captcha');
            if(!($mobile)) {
                return $this->error('手机号不存在，请先注册');
            }
            //校验验证码
            $res = $this->checkcode($code,$mobile);
            if($res == true) {
                //获得用户信息
                $where['mobile'] = $mobile;
                $where['status'] = 1;
                
                $userInfo = Db::name('Users')->where($where)->find();
                if($userInfo) {
                    if ($userInfo['nickname'] == '') {
                        $session['nickname'] = $userInfo['mobile'];
                    } else {
                       $session['nickname']  = $userInfo['nickname']; 
                    }

                    #获取购物车商品数量  wjj
                    $num = Db::name('Cart')->where(array('uid'=>$userInfo['id']))->sum('goods_num');
                    $session['num'] = empty($num)?0:$num;
                    //记录用户登录信息
                    session('wap_user_auth',$session);
                    return $this->success('请尽快绑定邮箱，完善个人资料，！',url('index/index/index'));
                } else {
                    return $this->error('手机号不存在，请先注册');
                }
            } else {
                return $this->error('验证码错误');
            } 
        } else {
            return $this->themeFetch('login');                
        }

    }

    /**
     * 取回密码方法
     * @author  完美°ぜ界丶
     */
    public function getPassword()
    {
        if(Request::instance()->isPost()) {
            // 接收post数据
            $mobile            = input('post.mobile');//手机号
            $password          = input('post.password');//密码
            $repassword        = input('post.repassword');//密码
            $code              = input('post.code');
            
            //校验验证码
            $res = $this->checkcode($code,$mobile);
            if($res==true) {
                // 验证手机号是否存在
                $userInfo = Db::name('Users')->where('mobile',$mobile)->find();
                if(!($userInfo['mobile'])) {
                    return $this->error('手机号不存在');
                }
                // 验证两个密码
                if($password != $repassword){
                    return $this->error('两次输入密码不一样');
                }
                // 重置密码
                $newpassword           = minishop_md5($password,$userInfo['salt']);
                $result = Db::name('Users')->where('mobile',$mobile)->update(['password'=>$newpassword]);
                if($result) {
                    return $this->success('修改成功!',url('base/login'));
                } else {
                    return $this->error('修改失败');
                }
            } else {
                return $this->error('验证码错误');
            }         

        } else {
            return $this->themeFetch('get_password');
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
     * 系统验证码方法
     * @author  tangtnglove <dai_hang_love@126.com>
     */
    public function captcha()
    {
        $captcha = new \org\Captcha(config('captcha'));
        $captcha->entry();
    }
    // 验证码合法性
    public function checkcaptcha()
    {
        $verify = input('post.captcha');
        $captcha = new \org\Captcha();
        if($captcha->check($verify)) {
            return $this->success();
        } else {
            $data['message']="验证码错误！";
            return $this->error($data);
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
 
}
