<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: tangtanglove <dai_hang_love@126.com> <http://www.ixiaoquan.com>
// +----------------------------------------------------------------------

namespace app\index\validate;

use think\Validate;
use think\Lang;
use think\Db;
use think\Input;

class Member extends Validate
{
    protected $rule =   [
        'mobile'         => ['regex'=>'/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|17[0-9]{9}$/'],
        'mobile'         => 'checkHasValue:mobile',
        'password'       => 'require',        
       
        'newpassword'    => 'require',
        'repassword'     => 'require|confirm:password',
        'repeatpassword' => 'require|confirm:newpassword',
    ];

    protected $message  =   [
        'mobile.require'                  => '输入手机号', 
        'mobile.regex'                    => '手机号不正确',
        'mobile.checkHasValue:mobile'     => '手机号已存在',

        'password.require'                => '请输入密码', 
        'newpassword.require'             => '请输入新密码',
        'repassword.require'              => '请输入确认密码', 
        'repassword.confirm'              => '两次输入的密码不一致',

        'repeatpassword.require'          => '请输入确认密码', 
        'repeatpassword.confirm'          => '两次输入的密码不一致',
               
    ];

    protected $scene = [

        'edit'      =>  ['nickname','mobile'],
        'add'       =>  ['nickname','mobile','password','captcha'],
        'register'  =>  ['mobile','password','repassword','nickname'],
        'password'  =>  ['password','newpassword','repeatpassword'],
        'editpass'  =>  ['password','repassword'],
        'getpass'   =>  ['password','repassword',],
    ];    

    // 验证码合法性
    protected function checkCaptcha($value)
    {
        $captcha = new \org\Captcha();
        if($captcha->check($value)) {
            return true;
        } else {
            return '验证码错误！';
        }
    }

    protected function checkHasValue($value,$rule)
    {      
        $id = input('id');
        
        switch ($rule) {
            case 'mobile'  :
                if (empty($id)) {
                    $hasValue = Db::name('Users')->where('mobile',$value)->find();
                    if (empty($hasValue)) {
                        return true;
                    } else {                        
                        return "手机号已存在！";                        
                    }
                } else {
                    //更改资料判断手机号是否与其他人的手机号相同
                    $checkValue = Db::name('Users')
                        ->where('id','neq',$id)
                        ->where('mobile',$value)
                        ->find();
                    if (empty($checkValue)) {
                        return true;
                    } else {
                        return "手机号已存在";
                    }
                }
            break;            

            default:
                # code...
            break;
        }
    }
}