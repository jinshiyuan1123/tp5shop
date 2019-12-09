<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:39:"./themes/default/index/edit_mobile.html";i:1504864484;}*/ ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
<title>修改密码</title>

<link rel=stylesheet type=text/css href="<?php echo config('theme_path'); ?>/index/new/css/user_pwd.css" />
<script type="text/javascript" src="<?php echo config('theme_path'); ?>/index/new/js/user_pwd.js"></script>
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
.nr img{ width:300px;}input{cursor: pointer; -webkit-appearance: none;}
</style>
</head>
<body><script>
function cbCheckForm(input,$form){
    var mobile     =$("#mobile").val();
    var code      =$("#sms_code").val();
  $.ajax({
     type:'post',
     url:"<?php echo url('user/editMobile'); ?>",
     data:{"mobile":mobile,"code":code
          },
     dataType:'json',
     success: function(data) {
        if (data.code) {
             ddAlert(data.msg,data.url);
        } else {
           alert(data.msg);
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
  <p><b>修改密码</b><a href="javascript:;" onclick="history.back()" title="返回" class="left"></a> <a href="<?php echo url('user/usercenter'); ?>" title="会员中心" class="right"></a> </p></div>  
       <div class="admin_xfl">
                    <ul>
            <li><a href="<?php echo url('user/userProfile'); ?>"  >账号设置</a></li>
            <li><a href="<?php echo url('user/editmobile'); ?>" class="on">手机绑定</a></li>
            <li><a href="<?php echo url('user/editpassword'); ?>" >修改密码</a> </li>
                    </ul>
           </div> 
 <div class="p15" style="margin-top:-10px"><div class="register">
      <form onSubmit="return checkForm($(this),cbCheckForm)" action="">
    <table border="0" width="100%" cellpadding="0" cellspacing="0" >
        <tr height="40">
      <td><input id="mobile" placeholder="<?php echo $userInfo['mobile']; ?>(已绑定)" class="ddinput" dd-required type="text" /></td>
    </tr>
    <tr height="40">
      <td><input id="sms_code" value="" class="ddinput" placeholder="验证码" dd-required dd-type="num" dd-minl="6" dd-maxl="6" style='width:60%;'/><span style=" height:51px;
    width:calc(40% - 12px);
    display: block;
    float: right;"><input type="button" class="ddinput sms-button" onclick="sendSms()" style="padding-left:10px !important;font-size:10px!important;height:51px;background-color:#EC1A5B;color: #fff" value="发送验证码" /></td>
    </tr>

    <tr height="40">
      <td height="90" colspan="2">  
          <input type="submit" value="提交保存" id="sub"  class="register_dl"></td>
      <td></td>
    </tr>
    </table>
      </form>  
   </div> 
</div>
﻿ <style type="text/css">
 	/*底部样式*/ /************尾部固定导航*************/.fix-bottom {box-sizing: border-box;
	position:fixed;
	left:0;
	bottom:0;
	width:100%;
	border-top:#eee solid 1px;
	background:#f9f9f9;
	padding:6px 0;
	z-index:90;
	height: 48px;
}
.fix-bottom .fix-b-a {
	display:block;
	float:left;
	width:25%;
	text-align:center;
	height:40px;
	color:#666;
	font-size:11px;    line-height: 1em;
}
.fix-bottom .fix-b-a img {
	width:20px;
	height:20px;
	margin-bottom:2px
}
.fix-bottom .bottom-n-cur {
	color:#ee4f4f;
}
 </style>
 <div class="fix-bottom">
	<a href="<?php echo url('Index/index'); ?>" class="fix-b-a bottom-n-cur">
		<img src="<?php echo config('theme_path'); ?>/index/new/picture/today2.png"><br>首页
	  </a>
	  <a href="<?php echo url('order/orderLists'); ?>" class="fix-b-a ">
		  <img src="<?php echo config('theme_path'); ?>/index/new/picture/fenlei.png"><br>订单
	  </a>

	  <a href="<?php echo url('user/score_detail'); ?>" class="fix-b-a ">
		  <img src="<?php echo config('theme_path'); ?>/index/new/picture/coupon.png"><br>明细
	  </a>
	  <a href="<?php echo url('user/userCenter'); ?>" class="fix-b-a ">
		  <img src="<?php echo config('theme_path'); ?>/index/new/picture/pinp.png"><br>个人中心
	  </a>
</div> 

</body></html>