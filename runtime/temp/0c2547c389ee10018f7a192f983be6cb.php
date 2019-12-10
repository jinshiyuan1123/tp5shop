<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:40:"./themes/default/index/user_friends.html";i:1575943968;}*/ ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
<title>我的战队</title>

<link rel=stylesheet type=text/css href="<?php echo config('theme_path'); ?>/index/new/css/user_mingxi.css" />
<link rel=stylesheet type=text/css href="<?php echo config('theme_path'); ?>/index/new/css/page.css" />
<script type="text/javascript" src="<?php echo config('theme_path'); ?>/index/new/js/user_mingxi.js"></script>
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
.tx{width: 30px;height: 30px;border-radius: 50%;float: left;margin-right: 5px;}
</style>
</head>
<body><div class="yingdao" align="center">
  <p><b>我的战队</b><a href="javascript:;" onclick="history.back()" title="返回" class="left"></a> <a href="<?php echo url('user/usercenter'); ?>"  title="会员中心" class="right"></a> </p></div>  
 
<!--b显示列表-->
<?php if(empty($lists) || ($lists instanceof \think\Collection && $lists->isEmpty())): ?>
<div class="mc radius">
	<ul class="mu-l2w" ><div style=" width:185px; height:115px; margin:0 auto;"><img src="<?php echo config('theme_path'); ?>/index/new/picture/img_nocontent.png"/></div></ul>
</div>
<?php else: ?>
<div class="mc radius"> 
	<ul class="mu-l2w">

<?php if(is_array($lists) || $lists instanceof \think\Collection): $k = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($k % 2 );++$k;?>
<li style="padding: 10px;margin-top:5px;border-top: none;overflow: hidden; line-height: 1.6em;border-bottom: 1px dashed #DED6C9;"> 
  <span style="display: block;overflow: hidden;clear: both;padding: .22em 0;line-height: 30px;">
  
    <?php echo $data['nickname']; ?>
  </span>
  <span class="pricecolor" style="display: block;margin-top:5px;color:#ff3366"><?php 
        if($data['mobile']){
        echo substr_replace($data['mobile'],'****',3,4);
        } ?><span style="float: right;">
            公排位置:
            <?php switch($data['jibie']): case "0": ?>D层<?php break; case "1": ?>C层<?php break; case "2": ?>B层<?php break; case "3": ?>A层<?php break; case "4": ?>队长<?php break; endswitch; ?>
            第<?php echo $data['bcsx']; ?>个位置
    </span></span></span> 
</li>
 <?php endforeach; endif; else: echo "" ;endif; ?>       
			</ul>
</div>

<?php endif; ?>

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