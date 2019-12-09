<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:38:"./themes/default/index/return_url.html";i:1524735236;}*/ ?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>Hello MUI</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">

		<!--标准mui.css-->
		<link rel="stylesheet" href="<?php echo config('theme_path'); ?>/index/css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo config('theme_path'); ?>/index/css/icons-extra.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo config('theme_path'); ?>/index/css/cart.css" />
	</head>

	<body>

		<style>
			.mui-control-content {
				background-color: white;
				min-height: 215px;
			}
			.mui-control-content .mui-loading {
				margin-top: 50px;
			}
			.mui-table-view::before {
				background-color: #fff;
			}
			.mui-table-view::after {
				background-color: #f0f0f0;
			}
		</style>
		<!-- 头部 -->
		<header class="mui-bar mui-bar-nav" style="background: #FF2D4B;">
			<a class="mui-icon mui-icon-left-nav mui-pull-left" onclick="history.go(-1)" style="color: #fff;"></a>
			<a class="mui-icon mui-icon-extra mui-icon-extra-class mui-pull-right" style="color: #fff;"></a>
			<h1 class="mui-title" style="color:#fff">支付结果</h1>
		</header>
		<!-- 头部结束 -->
		<div class="mui-content">
			<ul class="mui-table-view">
				<li class="mui-table-view-cell mui-media">
					<div class="mui-media-body">
						<p class="mui-ellipsis address-name"><a style='float:left;' href='#'>订单号</a> <a class='mobile'><?php echo $ordersInfo['order_no']; ?></a></p>
						<p class="mui-ellipsis address-detail" style='margin-top: 6px;'><?php echo $content; ?></p>
					</div>
				</li>
			</ul>
			<div style='height: 30px; background-color: #fff;'>
				<!-- <div class='goods-checkbox' style='margin-right: 10px;'>
					<a href='<?php echo url('Order/orderDetail',['order_no'=>$ordersInfo['order_no']]); ?>'><span style='font-size: 12px; color:#fe0024;margin-left: 15px;margin-top:4px;float: left'>订单详情</span></a>
				</div> -->
				<span class="mui-pull-right" style='font-size: 12px; color:#999;margin-top:4px;'>
					<a href='<?php echo url('Order/orderLists'); ?>'><span class="mui-pull-right" style='margin-right: 15px;font-size: 12px;' >我的订单</span></a>
				</span>
			</div>
			
			<div style='height: 15px;'></div>
		</div>
		<!-- 底部 -->
		<div style='height: 50px;'></div>
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
		<!-- 底部结束 -->
<script src="<?php echo config('theme_path'); ?>/index/js/jquery.min.js"></script>
	</body>

</html>