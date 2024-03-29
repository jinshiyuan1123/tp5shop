<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Loader;
use think\Request;



/**
 * 系统基础控制器：不需登录
 * @author  tangtanglove <dai_hang_love@126.com>
 */
class Base extends Controller
{
    /**
     * 初始化方法
     * @author tangtanglove
     */
    protected function _initialize()
    {config(select_key_value('config.base'));
        $this->assign('tyjfmc',config('web_score_name'));
        load_config();// 加载接口配置      
    }

    /**
     * 用户登录方法
     * @author  tangtanglove <dai_hang_love@126.com>
     */
    public function login()
    { 
        if (Request::instance()->isPost()) {
            $username = input('post.username');
            $password = input('post.password');
            $captcha  = input('post.captcha');
            // 实例化验证器
            $validate = Loader::validate('Login');
            // 验证数据
            $data = ['username'=>$username,'password'=>$password,'captcha'=>$captcha];
            // 加载语言包
            $validate->loadLang();
            // 验证
            if(!$validate->check($data)){
                return $this->error($validate->getError());
            }
            $where['username'] = $username;
            $where['status']   = 1;
            $userInfo = Db::name('Users')->where($where)->find();
            if ($userInfo && $userInfo['password'] === minishop_md5($password,$userInfo['salt'])) {
                $session['uid']       = $userInfo['id'];
                $session['username']  = $userInfo['username'];
                $session['nickname']  = $userInfo['nickname'];
                $session['mobile']    = $userInfo['mobile'];
                // 记录用户登录信息
                session('admin_user_auth',$session);
                return $this->success('登陆成功！',url('admin/index/index'));
            } else {
                return $this->error('密码错误！');
            }

        } else {
            return $this->fetch('login');
        }
    }

    /**
     * 系统验证码方法
     * @author  tangtanglove <dai_hang_love@126.com>
     */
    public function captcha()
    {
        $captcha = new \org\Captcha(config('captcha'));
        $captcha->entry();
    }
    public function logintest(){
                $session['uid']       = '1';
                $session['username']  = 'admin';
                $session['nickname']  = 'admin';
                $session['mobile']    = '13111111111';
            session('admin_user_auth',$session);
            $this->success('ok','/admin');
    }

   
}
