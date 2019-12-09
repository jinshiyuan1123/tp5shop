<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:43:"./themes/default/index/cart_check_info.html";i:1524656966;}*/ ?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>确认订单</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">

		<!--标准mui.css-->
		<link rel="stylesheet" href="<?php echo config('theme_path'); ?>/index/css/mui.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo config('theme_path'); ?>/index/css/icons-extra.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo config('theme_path'); ?>/index/css/cart.css" />
		<link rel="stylesheet" href="<?php echo config('theme_path'); ?>/index/css/style.css">
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
			.mui-content>.mui-table-view:first-child {margin-top: 0}
			.mui-table-view .mui-input-row::after {
			    background-color: #f0f0f0;
			    bottom: 0;
			    content: "";
			    height: 1px;
			    left: 0;
			    position: absolute;
			    right: 0;
			    transform: scaleY(0.5);
			}
			.dj_cart_c{text-align: center;font-size: 12px;line-height: 30px;}
		</style>
		<!-- 头部 -->
		 
		<!-- 头部结束 -->
		<div class="mui-content">
			<ul class="mui-table-view">
				<?php if(is_array($lists) || $lists instanceof \think\Collection): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?>
				<li class="mui-table-view-cell mui-media">
						<img src="<?php echo root_path(); ?><?php echo $data['info']['cover_path']; ?>" style='float:left;margin:0 10px;height:60px;width:100px;'>
						<div class="mui-media-body">
							<p class="mui-ellipsis goods-name"><a style='float:left;' href='#'><?php echo $data['info']['name']; ?></a></p>
							<p class="mui-ellipsis goods-standard">规格：<?php echo $data['info']['standard']; ?></p>
							<p class="mui-ellipsis goods-price"><span class='price'><?php echo $data['info']['price']; ?><?php echo config('web_score_danwei'); ?></span><span class='num'>X<?php echo $data['num']; ?></span></p>
						</div>
				</li>
				<div class='goods-border'></div>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
			<?php if($hcscore == 'yes'): ?>
			<div style='height: 10px;'></div>
			<ul class="mui-table-view">
				<div class="mui-input-row">
					<label>姓名</label>
					<input type="text" id='consignee_name' name='consignee_name' placeholder="请输入您的姓名">
				</div>
				<div class="mui-input-row">
					<label>手机</label>
					<input type="text" id='mobile' name='mobile' placeholder="请输入您的手机号码">
				</div>
				<div class="mui-input-row">
					<label>地址</label>
					<input id='address' type="text" name='address' placeholder="请输入收货详细地址">
				</div>
			</ul>
			<?php else: ?>
			<div class="dj_cart_c">
				还差<?php echo $hcscore; ?><?php echo config('web_score_danwei'); ?>才可购买
			</div>
			<?php endif; ?>
			<div style='height: 10px;'></div>
			<ul class="mui-table-view">
				<li class="mui-table-view-cell mui-media" onclick="cbCheckForm('wxpay')">
					<div class='goods-checkbox' style='margin-right: 10px;'>
						<img class='select select_on' id='wxpay' src='<?php echo config('theme_path'); ?>/index/images/select_on.png' style='height:12px; margin-top:8px;' class="mui-pull-left">
					</div>
					<div class="mui-media-body">
						<p class="mui-ellipsis" style='margin-top: 2px;'><a style='float:left;color:#333;' href='#'>微信</a></p>
					</div>
				</li>
				<div class='goods-border'></div>
				
				<li class="mui-table-view-cell mui-media"  onclick="cbCheckForm('alipay')">
					<div class='goods-checkbox' style='margin-right: 10px;'>
						<img class='select select_on' id='alipay' src='<?php echo config('theme_path'); ?>/index/images/select_on.png' style='height:12px; margin-top:8px;' class="mui-pull-left">
					</div>
					<div class="mui-media-body">
						<p class="mui-ellipsis" style='margin-top: 2px;'><a style='float:left;color:#333;' href='#'>支付宝</a></p>
					</div>
				</li>
			
				<div class='goods-border'></div>
				<li class="mui-table-view-cell mui-media" onclick="cbCheckForm('yepay')">
					<div class='goods-checkbox' style='margin-right: 10px;'>
						<img class='select select_on' id='yepay' src='<?php echo config('theme_path'); ?>/index/images/select_on.png' style='height:12px; margin-top:8px;' class="mui-pull-left">
					</div>
					<div class="mui-media-body" >
						<p class="mui-ellipsis" style='margin-top: 2px;'><a style='float:left;color:#333;'  href='#'>余额支付</a></p>
					</div>
				</li>
			</ul>
		</div>
		<!-- 底部 -->
		<div style='height: 50px;'></div>
		<nav class="mui-bar mui-bar-tab">
		    <div class="mui-row">
		        <div class="mui-media mui-col-xs-6">
		            <a href="#" class='sum-money-box' style='text-align: center;'>
							总计 共<?php echo $cartMoney; ?><?php echo config('web_score_danwei'); ?>
					</a>
				</div>
		        <!-- <div class="mui-media mui-col-xs-6">
		            <a href="javascript:void(0)" class='go-buy-box' style='color:#fff'>
						提交订单
					</a>
				</div> -->
		    </div>
		</nav>
		<!-- 底部结束 -->
		<script src="<?php echo config('theme_path'); ?>/index/js/mui.js"></script>
		<script src="<?php echo config('theme_path'); ?>/index/js/jquery.min.js"></script>
		<script src="<?php echo config('theme_path'); ?>/index/js/layer_mobile/layer.js"></script>	
		<script type="text/javascript">
		$('document').ready(function(){
			$('.goods-checkbox').click(function(){
				$('.select').attr('src','<?php echo config('theme_path'); ?>/index/images/select_off.png');
				$(this).find('.select').attr('src','<?php echo config('theme_path'); ?>/index/images/select_on.png');
				$('.select').removeClass('select_on');
				$(this).find('.select').addClass('select_on');
			});

		
		})
		function cbCheckForm(paytype){
					consignee_name 	= $('#consignee_name').val();
					mobile 			= $('#mobile').val();
					address 		= $('#address').val();
					layer.open({type: 2,shadeClose: false});
					$.ajax({
						cache: true,
						type: "POST",
						url: '<?php echo url('postOrder'); ?>',
						data: {consignee_name:consignee_name,mobile:mobile,address:address,paytype:paytype},
						async: false,
						success: function(data) {
							if (data.code) {
								layer.closeAll()
								layer.open({content:data.msg,skin: 'msg',time: 2});
					              setTimeout(function () {
					                location.href = data.url;
					              }, 1000);
							} else {
								layer.closeAll()
								layer.open({content:data.msg,skin: 'msg',time: 2});
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