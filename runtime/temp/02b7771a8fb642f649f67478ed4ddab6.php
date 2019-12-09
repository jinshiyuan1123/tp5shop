<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:40:"./themes/default/index/order_detail.html";i:1501310640;}*/ ?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>订单详情</title>
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
			.mui-content>.mui-table-view:first-child {margin-top: 0}	
		</style>

		<div class="mui-content">
			<ul class="mui-table-view">
				<li class="mui-table-view-cell mui-media">
					<div class="mui-media-body">
						<p class="mui-ellipsis address-name" style='margin-bottom: 5px;'><a style='float:left;' href='#'>订单编号</a> <a class='mobile'><?php echo $ordersInfo['order_no']; ?></a></p>
						<p class="mui-ellipsis address-detail"><a style='float:left;color:#999' href='#'>状态</a> <a style='float:right;color:#999'><?php switch($ordersInfo['status']): case "nopaid": ?>未支付<?php break; case "paid": ?>已支付,待发货<?php break; case "shipped": ?>已发货<?php break; case "completed": ?>已完成<?php break; endswitch; ?>
                          </a> </p>
					</div>
				</li>
				<div class='goods-border'></div>
				<li class="mui-table-view-cell mui-media">
					<div class="mui-media-body">
						<p class="mui-ellipsis address-name" style='margin-bottom: 5px;'><a style='float:left;' href='#'>收货人信息</a></p>
						<p class="mui-ellipsis address-detail"><a style='float:left;color:#999' href='#'>收货人姓名</a> <a style='float:right;color:#999'><?php echo $ordersInfo['consignee_name']; ?></a> </p>
						<p class="mui-ellipsis address-detail"><a style='float:left;color:#999' href='#'>联系电话</a> <a style='float:right;color:#999'><?php echo $ordersInfo['mobile']; ?></a> </p>
						<p class="mui-ellipsis address-detail"><a style='float:left;color:#999' href='#'>送货地址</a> <a style='float:right;color:#999'><?php echo $ordersInfo['address']; ?></a> </p>
					</div>
				</li>
				<div class='goods-border'></div>
				<li class="mui-table-view-cell mui-media">
					<div class="mui-media-body">
						<p class="mui-ellipsis address-name" style='margin-bottom: 5px;'><a style='float:left;' href='#'>配送信息</a></p>
						<p class="mui-ellipsis address-detail"><a style='float:left;color:#999'>快递</a> <a style='float:right;color:#999'><?php if(empty($ordersInfo['express_type']) || ($ordersInfo['express_type'] instanceof \think\Collection && $ordersInfo['express_type']->isEmpty())): ?>
                            暂无
                            <?php else: ?>
                            <?php echo $ordersInfo['express_type']; endif; ?></a> </p>
                        <p class="mui-ellipsis address-detail"><a style='float:left;color:#999'>快递单号</a> <a style='float:right;color:#999'><?php if(empty($ordersInfo['express_no']) || ($ordersInfo['express_no'] instanceof \think\Collection && $ordersInfo['express_no']->isEmpty())): ?>
                            暂无
                            <?php else: ?>
                            <?php echo $ordersInfo['express_no']; endif; ?></a> </p>
						<p class="mui-ellipsis address-detail"><a style='float:left;color:#999'>发货日期</a> <a style='float:right;color:#999'><?php echo get_delivery_time($ordersInfo['id']); ?></a> </p>
					</div>
				</li>
			</ul>
			<div style='height: 10px;'></div>
			<ul class="mui-table-view">
			<?php if(is_array(get_orders_goods($ordersInfo['id'])) || get_orders_goods($ordersInfo['id']) instanceof \think\Collection): $i = 0; $__LIST__ = get_orders_goods($ordersInfo['id']);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$orderlist): $mod = ($i % 2 );++$i;?>
				<li class="mui-table-view-cell mui-media">
				       
          				<?php if(empty($orderlist['cover_path']) || ($orderlist['cover_path'] instanceof \think\Collection && $orderlist['cover_path']->isEmpty())): ?>
						<img src="<?php echo config('theme_path'); ?>/index/images/irc_defaut.png" height='60' style='float:left;margin:0 10px;'>
						<?php else: ?>
						<img src="<?php echo root_path(); ?><?php echo $orderlist['cover_path']; ?>" height='60' style='float:left;margin:0 10px;'>
						<?php endif; ?>
						
						<div class="mui-media-body">
							<p class="mui-ellipsis goods-name"><a style='float:left;' href="<?php echo url('goods/detail',['id'=>$orderlist['goods_id']]); ?>"><?php echo $orderlist['name']; ?></a></p>
							<p class="mui-ellipsis goods-standard">规格：<?php echo $orderlist['standard']; ?></p>
							<p class="mui-ellipsis goods-price"><span class='price'><?php echo $orderlist['price']; ?><?php echo config('web_score_danwei'); ?></span><span class='num'>X<?php echo $orderlist['num']; ?></span></p>
						</div>
				</li>
				<div class='goods-border'></div>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>
			<div style='height: 10px;'></div>
		</div>
		<!-- 底部 -->
		<div style='height: 50px;'></div>
		<nav class="mui-bar mui-bar-tab">
		    <div class="mui-row">
		        <div class="mui-media mui-col-xs-6">
		            <a  class='sum-money-box' style='text-align: center;color:#FFF'>
							总计 共<?php echo $ordersInfo['amount']; ?>元
					</a>
				</div>
		        <div class="mui-media mui-col-xs-6">
 
					<a href="<?php echo url('order/orderLists'); ?>" style='text-align: center;color:#FFF' class='go-buy-box'>
						返回我的订单
					</a>
    	            
				</div>
		    </div>
		</nav>

	</body>

</html>