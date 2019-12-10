<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:38:"./themes/default/index/user_order.html";i:1575942787;}*/ ?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>我的订单</title>
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
			.mui-table-view::before {
				background-color: #fff;
			}
			.mui-table-view::after {
				background-color: #f0f0f0;
			}
			.goods-cate a{ width:25%; display:block; float: left; height:40px; line-height:40px;background-color: #fff; color:#333;text-align: center;font-size: 14px;}
			.goods-cate .active{background-color: #EC1A5B;color:#fff;}input{cursor: pointer; -webkit-appearance: none;}
		</style>
		
		<!-- 头部结束 -->
		<div class="mui-content">
			<div class='goods-cate'>
				<a href="<?php echo url('order/orderLists',['status'=>'']); ?>" class='default'>全部</a>
				<a href="<?php echo url('order/orderLists',['status'=>'paid']); ?>" class="paid">待发货<?php echo get_user_order_num('paid'); ?></a>
				<a href="<?php echo url('order/orderLists',['status'=>'shipped']); ?>" class="shipped">待收货<?php echo get_user_order_num('shipped'); ?></a>
				<a href="<?php echo url('order/orderLists',['status'=>'completed']); ?>" class="completed">已完成<?php echo get_user_uncomment_order_num('completed'); ?></a>
				<div style='clear: both;'></div>
			</div>
			<div style='height: 15px;'></div>
			<?php if(empty($lists) || ($lists instanceof \think\Collection && $lists->isEmpty())): ?>
          <div  style="margin-top:50px;text-align:center;color:#999;font-size:18px"><img style=""  src="<?php echo config('theme_path'); ?>/index/new/picture/img_nocontent.png"></div>
          <?php else: if(is_array($lists) || $lists instanceof \think\Collection): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?>
			<ul class="mui-table-view">
				<li class="mui-table-view-cell mui-media">
			
				    <?php if(empty($list['cover_path']) || ($list['cover_path'] instanceof \think\Collection && $list['cover_path']->isEmpty())): ?>
					<img src="<?php echo config('theme_path'); ?>/index/images/goods1.png" height='60' style='float:left;margin-right:10px;'>
					<?php else: ?>
                        <img  src="<?php echo root_path(); ?><?php echo $list['cover_path']; ?>" height='60' style='float:left;margin-right:10px;'>
                      <?php endif; ?>
                      
					<div class="mui-media-body">
						<p class="mui-ellipsis goods-name"><a style='float:left;' href='<?php echo url('goods/detail',['id'=>$list['goods_id']]); ?>'><?php echo $list['name']; ?></a> <a class='edit'>
						<?php switch(get_order_status($list['order_id'])): case "nopaid": ?>未支付<?php break; case "paid": ?>已支付<?php break; case "shipped": ?>已发货<?php break; case "completed": ?>已完成<?php break; endswitch; ?>
                        </a></p>
						<p class="mui-ellipsis goods-standard">规格：<?php echo $list['standard']; ?></p>
						<p class="mui-ellipsis goods-price"><span class='price'><?php echo $list['price']; ?><?php echo config('web_score_danwei'); ?></span><span class='num'>X<?php echo $list['num']; ?></span></p>
					</div>
				</li>
			</ul>
			<div style='height: 30px; background-color: #fff;'>
				<div class='goods-checkbox' style='margin-right: 10px;'>
		
					<a href="<?php echo url('order/orderDetail',['order_id'=>$list['order_id']]); ?>"><span style='font-size: 12px; color:#ee4f4f;margin-left: 15px;margin-top:4px;float: left'>订单详情</span></a>
				</div>
				<span class="mui-pull-right" style='font-size: 12px; color:#999;margin-top:4px;'>
				    <?php switch(get_orders_status($list['order_id'])): case "shipped": ?><a class="delete" data="<?php echo $list['order_id']; ?>" type="1" style="cursor:pointer"><span class="mui-pull-right" style='margin-right: 15px;font-size: 12px;' >确认收货</span></a><?php break; case "completed": ?> 
                        <a class="delete" data="<?php echo $list['order_id']; ?>" type="2" style="cursor:pointer"><span class="mui-pull-right" style='margin-right: 15px;font-size: 12px;color:#999;' ><img src='<?php echo config('theme_path'); ?>/index/images/delete-off.png' style='height:12px;vertical-align: middle;' /> 删除</span></a><?php break; endswitch; ?>
				</span>
			</div>
			<div style='height: 15px;'></div>
			
		<?php endforeach; endif; else: echo "" ;endif; ?>
		<div class="page">
			<?php echo $page; ?>

		</div>
		<?php endif; ?>
		</div>
		
<script src="<?php echo config('theme_path'); ?>/index/js/mui.js"></script>
<script src="<?php echo config('theme_path'); ?>/index/js/jquery.min.js"></script>	
<script src="<?php echo config('theme_path'); ?>/index/js/layer_mobile/layer.js"></script>	
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
    <a href="<?php echo url('Index/index'); ?>" class="fix-b-a">
      <img src="<?php echo config('theme_path'); ?>/index/new/picture/today.png"><br>首页
    </a>
    <a href="<?php echo url('order/orderLists'); ?>" class="fix-b-a bottom-n-cur">
        <img src="<?php echo config('theme_path'); ?>/index/new/picture/fenlei2.png"><br>订单
    </a>
    <a href="<?php echo url('user/score_detail'); ?>" class="fix-b-a ">
        <img src="<?php echo config('theme_path'); ?>/index/new/picture/coupon.png"><br>明细
    </a>
    <a href="<?php echo url('user/userCenter'); ?>" class="fix-b-a ">
        <img src="<?php echo config('theme_path'); ?>/index/new/picture/pinp.png"><br>个人中心
    </a>
</div> 
	 <!-- 底部结束 -->
<script type="text/javascript">
			//删除或确认收货
  $('.delete').click(function(){
    id = $(this).attr('data');
    type = $(this).attr('type');
    layer.open({type: 2,shadeClose: false});
    $.ajax({
       type:'post',
       url:"<?php echo url('order/cancel'); ?>",
       data:{id:id,type:type},
       dataType:'json',
       success: function(data) {
     	  	layer.closeAll()
            if (data.code) {
                layer.open({content:data.msg,skin: 'msg',time: 2});
                setTimeout(function () {
                  location.href = data.url;
                }, 1000);
            } else {
                layer.open({content:data.msg,skin: 'msg',time: 2});
            }
          },
          error: function(request) {
			layer.closeAll()
            layer.open({content: "页面错误",skin: 'msg',time: 2});
        }
    });
  })
</script>
<script>
	$(function(){
		//高亮
		status = "<?php if(empty($_GET['status'])){echo('default');}else{echo($_GET['status']);}?>";
		if(status){
			$('.'+status).addClass('active');
		}else{
			$('.default').addClass('active');
		}
		//下拉
		$('.show-nav').click(function(){
			$('#h-nav').slideToggle();
		})
	})
</script>
<script type="text/javascript">
	var list = document.querySelector('.mui-table-view.mui-table-view-radio');
	list.addEventListener('selected',function(e){
		console.log("当前选中的为："+e.detail.el.innerText);
	});

</script>
	</body>

</html>