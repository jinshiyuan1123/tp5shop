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

class Login extends Validate
{
    protected $rule =   [
        'username'  => 'require',
        'password'  => 'require', 
        'mobile'    =>  ['regex'=>'/^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|17[0-9]{9}$/'],
 

    ];

    protected $message  =   [];

    // 加载语言包
    public function loadLang(){
        $login_not_null = Lang::get('用户名或密码不能为空');
        $mobile_format_error = Lang::get('手机号格式错误');
 
        $this->message = [
            'username.require' => $login_not_null,
            'password.require' => $login_not_null,
            'mobile.regex'     => $mobile_format_error,
 
        ];
    }

    protected $scene = [

        'login'         =>  ['username','password',],
        'sms_login'     =>  ['mobile'],
        'mobile_login'  =>  ['mobile','password'],
        
    ]; 
 
    

}