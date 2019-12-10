<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:40:"./themes/default/index/get_password.html";i:1575943968;}*/ ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
<title>找回密码</title>

<link rel=stylesheet type=text/css href="<?php echo config('theme_path'); ?>/index/new/css/user_mima.css" />
<script type="text/javascript" src="<?php echo config('theme_path'); ?>/index/new/js/user_mima.js"></script>
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
<body>
<div class="yingdao" align="center">
  <p><b>找回密码</b><a href="javascript:;" onclick="history.back()" title="返回" class="left"></a> <a href="<?php echo url('user/usercenter'); ?>" title="会员中心" class="right"></a> </p></div>  
  
 <div class="wap-index">
 <div class="p15">
 <div class="register">
  <table style="width:100%; margin:auto" border="0" cellpadding="0" cellspacing="0">
    <form id="form1" name="form1" method="post" action="">
  <tr height="40">
      <td>请填写您注册时的手机</td>
    </tr>
     <tr height="40">
      <td><input type="text" id="mobile" name="mobile" maxlength="50" placeholder="请输入注册时的手机号码" class="ddinput"/></td>
    </tr>
     <tr height="40">
      <td><input type="text" id="sms_code" class="ddinput" style="width:60%;" placeholder="请输入手机验证码" /><input type="button" class="ddinput sms-button" onclick="sendSms()" style="padding-left:10px !important;font-size:12px!important;width:calc(40% - 12px);float: right;    background: #EC1A5B;color: #fff" value="发送验证码" /></td>
    </tr>
     <tr height="40">
      <td><input type="password" id="password" name="password" maxlength="50" placeholder="新密码" class="ddinput"/></td>
    </tr>
     <tr height="40">
      <td><input type="password" id="repassword" name="repassword" maxlength="50" placeholder="请再次输入密码" class="ddinput"/></td>
    </tr>
    <tr height="40">
      <td height="80" colspan="2"> <input name="sub" id="submit" type="button" value="找回密码"  class="register_dl"></td>
      <td></td>
    </tr>
  </form>
  </table>
</div></div></div>


<script type="text/javascript">

//获取手机验证码
function sendSms(){
  var mobile   = $("#mobile").val();
    if(verifymobile(mobile) == false){
      alert('请填写正确的手机号码');
      return false
    }
    $.ajax({
      type:"post",
      url:"<?php echo url('alidayu/index'); ?>",
      data:{"mobile":mobile},
      dataType:"json",
      success: function(res){
             if(res.code == 0 )
                   {
                     alert(res.msg);
                   
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
             alert(res.msg);
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

<script type="text/javascript" language="javascript">
// 提交数据
$(function(){
  $("#submit").click(function(){
    var mobile    =$("#mobile").val();
    var password  =$("#password").val();
    var repassword=$("#repassword").val();
    var code      =$("#sms_code").val();
  $.ajax({
     type:'post',
     url:"<?php echo url('base/getPassword'); ?>",
     data:{"password":password,
           "mobile":mobile,   "repassword":repassword,
           "code":code,},
     dataType:'json',
     success: function(data) {
                if (data.code) {
                  alert(data.msg);
          setTimeout(function () {
          location.href = data.url;
        }, 1000);
        } else {
            alert(data.msg);
        }
        },
        error: function(request) {
            alert('页面错误');
      }
  });
  
   })
})

</script>
</body></html>