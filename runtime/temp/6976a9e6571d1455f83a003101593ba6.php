<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:36:"./themes/default/index/register.html";i:1575943968;}*/ ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
<title>会员注册</title>

<link rel=stylesheet type=text/css href="<?php echo config('theme_path'); ?>/index/new/css/user_register.css" />
<script type="text/javascript" src="<?php echo config('theme_path'); ?>/index/new/js/user_register.js"></script>
<style type="text/css">
.jl_tj{ width:99%; height:38px;line-height:38px; text-align:center; display:block; background:#fff; border:1px #E7E7E7 solid; color:#000; cursor:pointer; font-size:1.4em;border-radius:3px; }
.jl_tj:hover{ opacity:0.8; }
.jl_tj2{ width:100%; height:38px;line-height:38px; text-align:center; display:block; background:#EC1A5B;  color:#fff; cursor:pointer; font-size:1.4em;border-radius:3px; }
.jl_tj2:hover{ opacity:0.8; }
.register_dl{ width:100%; height:45px; background:#EC1A5B;border:0; color:#FFFFFF; font-weight:500;font-family:Microsoft YaHei;  cursor:pointer; font-size:18px;border-radius:2px; }
.register_dl:hover{ opacity:0.8; }
.tijiao{ width:80px; height:37px; background:#EC1A5B;border:0; color:#FFFFFF; cursor:pointer; font-size:16px; }
.tijiao:hover{ opacity:0.8; }
.register_tc{ background:#fff; border:1px #E7E7E7 solid; margin:0 10px 0 10px;text-align:center;margin-top:10px;margin-bottom:10px;padding:12px;border-radius:3px; }
.register_tc a{font-size:16px; color:#EC1A5B;}
.register_tc:hover{ opacity:0.8; }
.nr img{ width:300px;}
input{cursor: pointer; -webkit-appearance: none;}
</style>
</head>
<body><script>
function cbCheckForm(input,$form){
    var mobile    =$("#mobile").val();
    var password  =$("#password").val();
    var repassword=$("#repassword").val();
    var code      =$("#sms_code").val();
    $('#tijiao').val('提交中...');
  $.ajax({
     type:'post',
     url:"<?php echo url('base/register',array('reid'=>input('get.reid'))); ?>",
     data:{"password":password,
           "mobile":mobile,   "repassword":repassword,
           "code":code,},
     dataType:'json',
     success: function(data) {
                if (data.code) {
                  ddAlert(data.msg,data.url);
        } else {
          alert(data.msg);
          $('#tijiao').val('注册');
        }
    }
  });

}


//获取手机验证码
function sendSms(){
  var mobile   = $("#mobile").val();
  var pic_code = $("#pic_code").val();
    if(verifymobile(mobile) == false){
      alert('请填写正确的手机号码')
      return false
    }
    $.ajax({
      type:"post",
      url:"<?php echo url('alidayu/index'); ?>",
      data:{"mobile":mobile},
      dataType:"json",
      success: function(res){
             if(res.code == 0 ){
                      alert(res.msg)
             } else{
                        
                          var wait = 60;
                           $(".sms-button").val((--wait) + "秒后重新发送");
                             var time_line = setInterval(function(){
                             if(wait == 0)
                             {
                            
                             $(".sms-button").val("获取手机验证码");
                             return clearInterval(time_line);
                           }
                           else
                           {
                             $(".sms-button").val((--wait) + "秒后重新发送"); 
                           }    
                                 },1000);
                  alert(res.msg)        
                 }
           
            }
     });
  
}
//手机号验证
function verifymobile(mobile){
  var phone = /^13[0-9]{1}[0-9]{8}$|15[0-9]{1}[0-9]{8}$|18[0-9]{1}[0-9]{8}$|17[0-9]{9}$/;
    if(!phone.test(mobile)){
      return false
    }
}

</script>
<div class="yingdao" align="center">
  <p><b>免费注册</b><a href="javascript:;" onclick="history.back()" title="返回" class="left"></a> <a href="<?php echo url('user/usercenter'); ?>" title="会员中心" class="right"></a> </p></div>  
  <div class="p15">
 <div class="register">
  <form onSubmit="return checkForm($(this),cbCheckForm)">
     <table border="0" align="left" cellpadding="0" cellspacing="0" bordercolorlight="#9acd32" width="100%">
    
    <tr height="40">
      <td><input type="text" id="username" class="ddinput" value="<?php echo $tjmobile; ?>(推荐人)" disabled/></td>
    </tr>
    <tr height="40">
      <td><input id="mobile" class="ddinput" placeholder="请输入你的手机号" value="" dd-required type="text" /></td>
    </tr>
    <tr height="40">
      <td><input id="password" class="ddinput" placeholder="请输入密码" value="" dd-required type="password"></td>
    </tr>
    <tr height="40">
      <td><input id="repassword" class="ddinput" dd-required placeholder="重复上面的密码" value="" type="password"></td>
    </tr>
                    <tr height="40">
     <!--<td><input id="sms_code" value="" class="ddinput" placeholder="验证码" dd-required dd-type="num" dd-minl="6" dd-maxl="6" style='width:60%;'/><span style=" height:51px;
    width:calc(40% - 12px);
    display: block;
    float: right;"><input type="button" class="ddinput sms-button" onclick="sendSms()" style="padding-left:10px !important;font-size:10px!important;height:51px;background-color:#EC1A5B;color: #fff" value="发送验证码" /></span></td>
    </tr>   --> 
   <tr height="40">
      <td height="80" colspan="2"> 
          <input type="submit" value="立即注册" id="tijiao"  class="register_dl"></td>
      <td></td>
    </tr>
<tr align="center">
      <td height="80" colspan="2"> 
          <a style="width:100%; display:block; line-height:50px;" href="<?php echo url('base/login'); ?>" class="register_dl">登录</a></td>
      <td></td>
    </tr>	
    </table>    
    </form>
</div>
  
  <div class="h30"></div>
   
     </div>  
  </div>
   
</body></html>