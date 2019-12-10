<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:79:"D:\phpStudy2018\PHPTutorial\WWW\tp5shop\themes/default/index/dispatch_jump.html";i:1575943967;}*/ ?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>跳转提示</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
 		
		 
		<script src="/themes/default/index/js/jquery.min.js"></script>
		<script src="/themes/default/index/js/layer_mobile/layer.js"></script>	
 
	</head>

	<body>
		<style>
			 body{max-width: 720px;margin:0 auto;height: 100%;background:#efeff4;}
</style>
 <script type="text/javascript">
 
 $(function(){

 	layer.open({content:'<?php echo(strip_tags($msg));?>',skin: 'msg',time: 2});
 	setTimeout(function () {
              	layer.closeAll()
                location.href = '<?php echo($url);?>';
     }, 2000);
 })
 </script>
	</body>

</html>