<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:41:"./themes/default/index/edit_nickname.html";i:1505377942;}*/ ?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title><?php echo config('web_site_title'); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">

		<!--标准mui.css-->
		<link rel="stylesheet" href="<?php echo config('theme_path'); ?>/index/css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo config('theme_path'); ?>/index/css/icons-extra.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo config('theme_path'); ?>/index/css/cart.css" />
		<link rel="stylesheet" href="<?php echo config('theme_path'); ?>/index/css/style.css">
		<script src="<?php echo config('theme_path'); ?>/index/js/mui.js"></script>
	    <script src="<?php echo config('theme_path'); ?>/index/js/jquery.min.js"></script>
	    <script src="<?php echo config('theme_path'); ?>/index/js/layer_mobile/layer.js"></script>
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
			.djxc{width: 100%;text-align: center;background-color: #ee4f4f;display:block;margin-top: 20px;}	
		</style>
 
		<!-- 头部结束 -->
		<div class="mui-content">
			<form class="mui-input-group">
				<div class="mui-input-row" style="margin-top: 20px;">
					<!--<label>用户名</label>-->
					<input type="text" id="nickname" value="<?php echo $userInfo['nickname']; ?>" placeholder="请输入昵称">
				</div>
				
				<!--<div style='color: #999;font-size: 12px;margin-left: 15px;'>请输入新的昵称</div>-->
			</form>
			<a onclick="submitInfo()" class="djxc" style="background:#ec1a5b; margin:30px auto; width:50%; color: #fff;font-size: 14px; height: 50px; line-height: 50px;">保存</a>
			<div style='height: 10px;'></div>
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
 
<script type="text/javascript" language="javascript">
// 提交数据
function submitInfo(){
    var nickname     =$("#nickname").val();
     layer.open({type: 2,shadeClose: false});
  $.ajax({
     type:'post',
     url:"<?php echo url('user/editNickname'); ?>",
     data:{"nickname":nickname,  
          },
     dataType:'json',
     success: function(data) {
     	layer.closeAll()
            if (data.code) {
            layer.open({content: data.msg,skin: 'msg',time: 2});
          setTimeout(function () {
          	
          location.href = data.url;
        }, 1000);
        } else {
        	layer.open({content: data.msg,skin: 'msg',time: 2});
        }
        },
        error: function(request) {
             layer.closeAll()
            layer.open({content: "页面错误",skin: 'msg',time: 2});
      }
  });
  
   }


</script>
	</body>

</html>