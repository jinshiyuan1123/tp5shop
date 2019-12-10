<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:43:"./themes/default/index/user_withdrawal.html";i:1575943968;}*/ ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
<title>提现</title>

<link rel=stylesheet type=text/css href="<?php echo config('theme_path'); ?>/index/new/css/user_tixian.css" />
<script type="text/javascript" src="<?php echo config('theme_path'); ?>/index/new/js/user_tixian.js"></script>
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
 .wxts{font-size: 14px;margin:10px;line-height: 24px}
</style>
</head>
<body><script>
function cbCheckForm(input,$form){
    var money     =$("#money").val();
    var dlmm      =$("#dlmm").val();
    $('#tijiao').val('提交中...');
    if($('#tijiao').attr('ftj')==1){
      alert('不可重复提交');
      return false;
    }
    $('#tijiao').attr('ftj',1);
  $.ajax({
     type:'post',
     url:"<?php echo url('user/user_withdrawal'); ?>",
     data:{"money":money,"dlmm":dlmm},
     dataType:'json',
     success: function(data) {
            if (data.code) {
                setTimeout(function () {
          location.href = data.url;
        }, 1000);
            } else {
              alert(data.msg);
              $('#tijiao').val('提交');
              $('#tijiao').attr('ftj',0);
            }
        }
  });
  

}
</script>
<div class="yingdao" align="center">
  <p><b>提现</b><a href="javascript:;" onclick="history.back()" title="返回" class="left"></a><a href="<?php echo url('user/usercenter'); ?>" title="会员中心" class="right"></a> </p></div>  
   <div class="admin_xfl">
                    <ul>
            <li > <a href="<?php echo url('user/user_withdrawal'); ?>" class="on">余额提现</a> </li>
            <!-- <li > <a href="<?php echo url('user/money_detail'); ?>" >资金明细</a> </li> -->
                    </ul>
                </div>
   <div class="p15" style="margin-top:-35px">
  <div class="register">
   <form onSubmit="return checkForm($(this),cbCheckForm)" action="">
       <table border="0" width="100%" cellpadding="0" cellspacing="0" >
                           
             <tr height="20">
                            <td  align="left"></td></tr>
                          <tr height="40">
                            <td width="230" align="left" class="ddinput">可提余额：<font color="#FF0000"><B>
                            <?php echo $userinfo['score']; ?></b></font> 元</td></tr>
    
              <tr height="40">
                            <td  height="35" align="left" class="ddinput">提现要求    <span style="font-size:16px">（最高提现：<font color="#FF0000"><B><?php echo $userinfo['score']; ?></b></font> 余额）</span></td></tr>
               
              <tr height="40">
                            <td  height="35" align="left">填写提现金额</td></tr>
     <tr>
                            <td align="left"><input id="money" type="text" class="ddinput"  name="jifenbao" placeholder="最高提现<?php echo $userinfo['score']; ?>余额" value="" dd-type="num" dd-required /></td>
                          </tr>
 <tr height="40">
                            <td  height="35" align="left">会员登陆密码</td></tr>
    <tr height="40">
                            <td align="left"><input id="dlmm"  class="ddinput" value="" placeholder="输入登录密码" dd-required type="password"></td>
                          </tr>
              <tr height="40">
                            <td height="90" colspan="3" align="left">
<input type="submit" value="提 交" id="tijiao" class="register_dl"/></td>
                          </tr>
                   </table>
   </form>
         <div class="wxts">
注意：<br>
1.余额可以直接提现；<br>
2.提现至少需直推<?php echo $tx_zt_num; ?>人；<br>
<div style="height: 10px;"></div>
 
    </div>
</div>   </div>    
 <style type="text/css">
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