<?php
// +----------------------------------------------------------------------
// | Minishop [ Easy to handle for Micro businesses ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.qasl.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 完美°ぜ界丶 
// +----------------------------------------------------------------------
namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Db;
use think\Loader;

class Alidayu extends Controller {
    public function index()
    {   
        load_config();// 加载接口配置
        // 短信配置信息
        $ab               = $this->randstring();//获取随机数字        
        $mobile           = input('post.mobile');//接收手机号码
        // 验证
        // 实例化验证器
        $validate = Loader::validate('Login');
        // 验证数据
        $data = ['mobile'=>$mobile];
        // 加载语言包
        $validate->loadLang();
        // 验证
        if(!$validate->scene('sms_login')->check($data)) {
            return $this->error($validate->getError());
        }
        $data['yzm_time'] = time(); 
        $data['code']     = $ab;
        $data['num']      = 0;
        $data['mobile']   = $mobile;
        $data['captcha']  = '';
        $res              = Db::name('Code')->where('mobile',$mobile)->find();
        if($res) {
            $interval_time    = $data['yzm_time']-$res['yzm_time'];
            if($interval_time<config('sms_interval')) {
                $data['message']='发送太频繁请稍后重试';

                return $this->error($data['message']);
            } else {
                $data['num'] = 0;
                Db::name('Code')->where('mobile',$mobile)->update($data);
            }
        } else {
            Db::name('Code')->where('mobile',$mobile)->insert($data);
        }

        $ch = curl_init();
        // 必要参数
        $apikey = config('sms_appkey');
        //$apikey = "09c3d0c1bcba39f1a40243af87555bdf"; //修改为您的apikey(https://www.yunpian.com)登录官网后获取

        $text="【".config('sms_signname')."】您的验证码是".$ab."。如非本人操作，请忽略本短信";
        // 发送短信
        $data=array('text'=>$text,'apikey'=>$apikey,'mobile'=>$mobile);
        curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $json_data = curl_exec($ch);

        // start 短信宝接口
        $statusStr = array(
        "0" => "短信发送成功",
        "-1" => "参数不全",
        "-2" => "服务器空间不支持,请确认支持curl或者fsocket，联系您的空间商解决或者更换空间！",
        "30" => "密码错误",
        "40" => "账号不存在",
        "41" => "余额不足",
        "42" => "帐户已过期",
        "43" => "IP地址限制",
        "50" => "内容含有敏感词"
        );
        $smsapi = "http://api.smsbao.com/";
        $user = "jinshiyuan1123"; //短信平台帐号
        $pass = md5("w134789"); //短信平台密码
        $content="【".config('sms_signname')."】您的验证码是".$ab."。如非本人操作，请忽略本短信";//要发送的短信内容
        $phone =  $mobile;//要发送短信的手机号码
        $sendurl = $smsapi."sms?u=".$user."&p=".$pass."&m=".$phone."&c=".urlencode($content);
        $result =file_get_contents($sendurl) ;
        // echo $statusStr[$result];
        // end
        // $result = 0;
        //解析返回结果（json格式字符串）
        $array = json_decode($json_data,true);
 
        if($result == 0){
            $data['message']="发送成功";
            return $this->success($data['message']);
        }else{
            $data['message']="发送失败";
            return $this->error($data['message']);
        }
        
    }



 /**
     * 获取随机位数数字
     * @param  integer $len 长度
     * @return string       
     */
    protected static function randString($len = 6)
    {
        $chars = str_repeat('0123456789', $len);
        $chars = str_shuffle($chars);
        $str   = substr($chars, 0, $len);
        return $str;
    }

   
}