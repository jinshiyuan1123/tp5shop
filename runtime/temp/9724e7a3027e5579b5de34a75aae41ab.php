<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:40:"./themes/default/index/user_fenhong.html";i:1527373518;}*/ ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
<title>全球分红</title>

<link rel=stylesheet type=text/css href="<?php echo config('theme_path'); ?>/index/new/css/user_mingxi.css" />
<link rel=stylesheet type=text/css href="<?php echo config('theme_path'); ?>/index/new/css/page.css" />
<script type="text/javascript" src="<?php echo config('theme_path'); ?>/index/new/js/user_mingxi.js"></script>
<link rel="stylesheet" href="<?php echo config('theme_path'); ?>/index/new/css/common.css" />
<link rel="stylesheet" type="text/css" href="<?php echo config('theme_path'); ?>/index/new/css/index.css?v=1.2.1"/>
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
.f_list{text-align:center;background:#fff; margin:0px; line-height:30px; padding:30px 0 30px 0; font-size:14px; color:#666; border-bottom:1px solid #eee; font-family:'微软雅黑';float:left;width:100%;}
 .wxts{font-size: 14px;margin:10px;line-height: 24px; float:left;}
.f_list ul{width:100%;} 
.f_list ul li{width:100%;} 
.f_list ul li span{width:25%; float:left; text-align:center;}
.muiview{width:98%; margin:0 auto; color:#2d2928;}
.muiview th{text-align:center; line-height:30px; color:#ff3366;}
.muiview td{text-align:center; line-height:30px; color:#464664;}
</style>
</head>
<body>
<div class="yingdao" align="center">
  <p><b>全球分红</b><a href="javascript:;" onclick="history.back()" title="返回" class="left"></a></p>
</div>  
<div class="mui-content">
	<div style='height: 15px;'></div>
<!--b显示列表-->
<table class="muiview" border="1" bordercolor="#464664" style="border-collapse:collapse;">
<tr>
	<th>全球直推</th><th>分红池</th><th>达标人数</th><th>预估收益</th>
</tr>
<tr><td>直推5人</td><td><?php echo $zuanshi_zong_fafang; ?></td><td><?php echo $zuanshi_count; ?></td><td><?php echo $zuanshi_user_fafang; ?></td></tr>
<tr><td>直推10人</td><td><?php echo $jinzuan_zong_fafang; ?></td><td><?php echo $jinzuan_count; ?></td><td><?php echo $jinzuan_user_fafang; ?></td></tr>
<tr><td>直推20人</td><td><?php echo $yinguan_zong_fafang; ?></td><td><?php echo $yinguan_count; ?></td><td><?php echo $yinguan_user_fafang; ?></td></tr>
<tr><td>直推30人</td><td><?php echo $jinguan_zong_fafang; ?></td><td><?php echo $jinguan_count; ?></td><td><?php echo $jinguan_user_fafang; ?></td></tr>
<tr><td>直推50人</td><td><?php echo $huangguan_zong_fafang; ?></td><td><?php echo $huangguan_count; ?></td><td><?php echo $huangguan_user_fafang; ?></td></tr>
<tr><td>直推80人</td><td><?php echo $zong_yy_zong_fafang; ?></td><td><?php echo $zong_yy_count; ?></td><td><?php echo $zong_yy_user_fafang; ?></td></tr>

</table>
<div style='height:20px;'></div>


</div>
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
</body>
</html>