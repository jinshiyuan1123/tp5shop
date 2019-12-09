<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:38:"./themes/default/index/cart_index.html";i:1524657116;}*/ ?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>购物车</title>
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
		</style>
		<!-- 头部结束 -->
		<div class="mui-content">
		<?php if(empty($lists) || ($lists instanceof \think\Collection && $lists->isEmpty())): ?>
          <div  style="margin-top:50px;text-align:center;color:#999;font-size:18px"><img style="width: 70%;" src="<?php echo config('theme_path'); ?>/index/images/no_cart.png"></div>
          <?php else: ?>
			<form id='order' method="post">
			<ul class="mui-table-view">
                <?php if(is_array($lists) || $lists instanceof \think\Collection): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?>
				<li class="mui-table-view-cell mui-media">
					<div class='goods-checkbox'>
						<?php if(empty($selectGoods) || ($selectGoods instanceof \think\Collection && $selectGoods->isEmpty())): ?>
							<img id='select' class='<?php echo $data['id']; ?>' src='<?php echo config('theme_path'); ?>/index/images/select_off.png' style='height:12px; margin-top:22px;' class="mui-pull-left">
						<?php endif; if(is_array($selectGoods) || $selectGoods instanceof \think\Collection): if( count($selectGoods)==0 ) : echo "" ;else: foreach($selectGoods as $key=>$vo): if($vo == $data['id']): ?>
								<img id='select' class='<?php echo $data['id']; ?>' src='<?php echo config('theme_path'); ?>/index/images/select_on.png' style='height:12px; margin-top:22px;' class="mui-pull-left">
								<?php else: ?>
							<img id='select' class='<?php echo $data['id']; ?>' src='<?php echo config('theme_path'); ?>/index/images/select_off.png' style='height:12px; margin-top:22px;' class="mui-pull-left">
							<?php endif; endforeach; endif; else: echo "" ;endif; ?>
					</div>
					<img src="<?php echo root_path(); ?><?php echo $data['cover_path']; ?>" style='float:left;margin:0 10px;height:60px;width:100px;'>
					<div class="mui-media-body">
						<!-- <p class="mui-ellipsis goods-name"><a style='float:left;' href='javascript:void(0)'><?php echo $data['name']; ?></a> <a class='edit'>编辑</a></p> -->
						<p class="mui-ellipsis goods-standard">规格：<?php echo $data['standard']; ?></p>
						<p class="mui-ellipsis goods-price">
							<span class='price'><?php echo $data['price']; ?><?php echo config('web_score_danwei'); ?></span>
							<span class="goods-delete" id=<?php echo $data['id']; ?> style='display: none;'>
								<img src='<?php echo config('theme_path'); ?>/index/images/delete.png' width='17'/>
							</span>
							<span class="goods-tools" style='display: none;'>
								<span class="jian"></span>
								<span class="text">
									<?php echo $data['cart_num']; ?>
								</span>
								<input name="cart[]" class="cart-info" id="goods_id_<?php echo $data['id']; ?>" type="hidden" value="
								<?php if(is_array($selectGoods) || $selectGoods instanceof \think\Collection): if( count($selectGoods)==0 ) : echo "" ;else: foreach($selectGoods as $key=>$vo): if($vo == $data['id']): ?>yes<?php endif; endforeach; endif; else: echo "" ;endif; ?>,<?php echo $data['id']; ?>,<?php echo $data['price']; ?>,<?php echo $data['cart_num']; ?>" />
								<span class="jia"></span>
							</span>
							<span class='num'>X<?php echo $data['cart_num']; ?></span>
						</p>
					</div>
				</li>
				<div class='goods-border'></div>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</ul>

			<div style='height: 10px;'></div>
		<?php endif; ?>
		</div>
		<!-- 底部 -->
		<?php if(empty($lists) || ($lists instanceof \think\Collection && $lists->isEmpty())): ?>
		<nav class="mui-bar mui-bar-tab">
		    <div class="mui-row">
		        <div class="mui-media mui-col-xs-12">
		            <button class='go-goods' style="width:100%;text-align:center;height:50px;font-size: 16px;background:red;color:#fff;border:0">
						去挑选商品
					</button>
				</div>
		    </div>
		</nav>
		<?php else: ?>
		<div style='height: 50px;'></div>
		<nav class="mui-bar mui-bar-tab">
		    <div class="mui-row">
		        <div class="mui-media mui-col-xs-6">
		            <a href="javascript:void(0)" class='sum-money-box'>
						<div class='buy-all' style='color:#000'>
							<img src='<?php echo config('theme_path'); ?>/index/images/all-off.png' height=17 style='float:left; margin-top: 18px;margin-left: 10px; margin-right: 10px;'>
							全选
						</div>
						<div class='sum-money'>
							共<?php echo $cartMoney; ?><?php echo config('web_score_danwei'); ?>
						</div>
					</a>
				</div>
		        <!-- <div class="mui-media mui-col-xs-3">
		            <a href="javascript:void(0)" class='collection-box'>
						移到收藏夹
					</a>
				</div> -->
		        <div class="mui-media mui-col-xs-6">
		            <button type="button" class='go-buy-box'>
						下一步
					</button>
				</div>
		    </div>
		</nav>
		<?php endif; ?>
		</form>
		<!-- 底部结束 -->
		<script src="<?php echo config('theme_path'); ?>/index/js/mui.js"></script>
		<script src="<?php echo config('theme_path'); ?>/index/js/jquery.min.js"></script>
		<script src="<?php echo config('theme_path'); ?>/index/js/layer_mobile/layer.js"></script>	
		<script type="text/javascript">
			$('document').ready(function(){
				$('.go-goods').click(function(){
					location.href = "<?php echo url('index/index'); ?>";
				})
				$('.go-buy-box').click(function(){
					layer.open({type: 2,shadeClose: false});
					$.ajax({
						cache: true,
						type: "POST",
						url: '<?php echo url('sessionorder'); ?>',
						data: $('form').serialize(),
						async: false,
						success: function(data) {
							if (data.code) {
								layer.closeAll()
								location.href = data.url;
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
				})
				$('.goods-checkbox').click(function(){
					select = $(this).find('#select').attr('src');
					if(select == '<?php echo config('theme_path'); ?>/index/images/select_on.png') {
						$(this).find('#select').attr('src','<?php echo config('theme_path'); ?>/index/images/select_off.png');
						goodsid = $(this).find('#select').attr('class');
						cartInfo = $("#goods_id_"+goodsid).val().split(',');
						$("#goods_id_"+goodsid).val('no'+','+cartInfo[1]+','+cartInfo[2]+','+cartInfo[3]);
						$('.buy-all').find('img').attr('src','<?php echo config('theme_path'); ?>/index/images/all-off.png');
					} else {
						$(this).find('#select').attr('src','<?php echo config('theme_path'); ?>/index/images/select_on.png');
						goodsid = $(this).find('#select').attr('class');
						cartInfo = $("#goods_id_"+goodsid).val().split(',');
						$("#goods_id_"+goodsid).val('yes'+','+cartInfo[1]+','+cartInfo[2]+','+cartInfo[3]);
					}
					sumMoney();
				});

				$('.edit').click(function(){
					text = $(this).text();
					if(text == '编辑') {
						$(this).text('完成');
						$(this).parent().next().next().find('.goods-delete').css('display','block');
						$(this).parent().next().next().find('.goods-tools').css('display','block');
						$(this).parent().next().next().find('.num').css('display','none');
					} else {
						$(this).text('编辑');
						$(this).parent().next().next().find('.goods-delete').css('display','none');
						$(this).parent().next().next().find('.goods-tools').css('display','none');
						$(this).parent().next().next().find('.num').css('display','block');
					}
				});

				$('.jian').click(function(){
					num = Number($(this).parent().find('.text').text())-1;
					if(num<=0) {
						num = 1;
						}
					$(this).parent().find('.text').text(num);
					$(this).parent().parent().find('.num').text('X'+num);
					// 修改参数
					cartInfo = $(this).parent().parent().find('.cart-info').val().split(',');
					$(this).parent().parent().find('.cart-info').val(cartInfo[0]+','+cartInfo[1]+','+cartInfo[2]+','+num);
					sumMoney();
				});
				$('.jia').click(function(){
					num = Number($(this).parent().find('.text').text())+1;
					if(num<=0) {
						num = 1;
						}
					$(this).parent().find('.text').text(num);
					$(this).parent().parent().find('.num').text('X'+num);
					// 修改参数
					cartInfo = $(this).parent().parent().find('.cart-info').val().split(',');
					$(this).parent().parent().find('.cart-info').val(cartInfo[0]+','+cartInfo[1]+','+cartInfo[2]+','+num);
					sumMoney();
				});

				// 全选
				$(".buy-all").click(function () {
					select = $(this).find('img').attr('src');
					if(select == '<?php echo config('theme_path'); ?>/index/images/all-on.png') {
						$(this).find('img').attr('src','<?php echo config('theme_path'); ?>/index/images/all-off.png');
						$('div #select').attr('src','<?php echo config('theme_path'); ?>/index/images/select_off.png');
						$(".cart-info").each(function(){
							cartInfo = $(this).val().split(',');
							$(this).val('no'+','+cartInfo[1]+','+cartInfo[2]+','+cartInfo[3]);
						});
					} else {
						$(this).find('img').attr('src','<?php echo config('theme_path'); ?>/index/images/all-on.png');
						$('div #select').attr('src','<?php echo config('theme_path'); ?>/index/images/select_on.png');
						$(".cart-info").each(function(){
							cartInfo = $(this).val().split(',');
							$(this).val('yes'+','+cartInfo[1]+','+cartInfo[2]+','+cartInfo[3]);
						});
					}
					// 重新计算金额
					sumMoney();
				});

				// js计算money
				function sumMoney() {
					var cartMoney = 0;
					$(".cart-info").each(function(){
						arrlist = $(this).val().split(',');
						if(arrlist[0].replace(/(^\s*)|(\s*$)/g, "") == 'yes') {
							cartMoney = cartMoney+arrlist[2]*arrlist[3];
						}
					});
					$(".sum-money").html('￥'+cartMoney+'元');
				}

				// 执行删除
				$('.goods-delete').click(function(){
					goods_id = $(this).prop('id');
					layer.open({type: 2,shadeClose: false});
					$.ajax({
						cache: true,
						type: "POST",
						url: '<?php echo url('delete'); ?>',
						data: {id:goods_id},
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
					return false;
				});

				$('.collection-box').click(function(){
					layer.open({type: 2,shadeClose: false});
					$.ajax({
						cache: true,
						type: "POST",
						url : '<?php echo url('collection'); ?>',
						data: $('#order').serialize(),
						async: false,
						success: function(data) {
							if (data.code) {
								layer.closeAll()
								layer.open({content:data.msg,skin: 'msg',time: 2});
								// setTimeout(function () {
								// 	location.href = data.url;
								// }, 1000);
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
				})
 


			})
		</script>
	</body>
</html>