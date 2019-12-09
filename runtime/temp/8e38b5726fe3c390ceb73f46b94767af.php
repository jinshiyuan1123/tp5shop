<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:40:"./themes/default/index/goods_detail.html";i:1524647114;}*/ ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
<title><?php echo $data['name']; ?></title>

<link rel=stylesheet type=text/css href="<?php echo config('theme_path'); ?>/index/new/css/goods_view.css" />
<link rel="stylesheet" href="<?php echo config('theme_path'); ?>/index/css/car.css">
<script type="text/javascript" src="<?php echo config('theme_path'); ?>/index/new/js/goods_view.js"></script>
<script src="<?php echo config('theme_path'); ?>/index/js/jquery.min.js"></script>
<script src="<?php echo config('theme_path'); ?>/index/js/jquery.cookie.js"></script>
<script type="text/javascript">
		    var car_path = '<?php echo config('theme_path'); ?>/index/images/';
</script>
<script src="<?php echo config('theme_path'); ?>/index/js/car.js"></script>

<style type="text/css"> 
.fixtop {
	width: 100%;
	height: 44px;
	background:#EC1A5B; overflow:hidden
}
.jl_tj{ width:99%; height:38px;line-height:38px; text-align:center; display:block; background:#fff; border:1px #E7E7E7 solid; color:#000; cursor:pointer; font-size:1.4em;border-radius:3px; }
.jl_tj:hover{ opacity:0.8; }
.jl_tj2{ width:100%; height:38px;line-height:38px; text-align:center; display:block; background:#EC1A5B;  color:#fff; cursor:pointer; font-size:1.4em;border-radius:3px; }
.jl_tj2:hover{ opacity:0.8; }
.register_dl{ margin:0 15px; width:92%; height:45px; background:#FFFFFF; border:1px #EC1A5B solid; color:#EC1A5B; font-weight:500;font-family:Microsoft YaHei;  cursor:pointer; font-size:18px;border-radius:2px; }
.register_dl:hover{ opacity:0.8; }
.tijiao{ width:80px; height:37px; background:#EC1A5B;border:0; color:#FFFFFF; cursor:pointer; font-size:16px; }
.tijiao:hover{ opacity:0.8; }
.register_tc{ background:#fff; border:1px #E7E7E7 solid; margin:0 10px 0 10px;text-align:center;margin-top:10px;margin-bottom:10px;padding:12px;border-radius:3px; }
.register_tc a{font-size:16px; color:#EC1A5B;}
.register_tc:hover{ opacity:0.8; }
.nr img{ width:300px;}
</style>
</style>
</head>
 <div class="main" style="height: auto; overflow: visible;">
<div class="app">
<div id="head" class="head">
       <div class="fixtop">
        <span id="classify" class="classify"><a href="javascript:;" onclick="history.back()" title="返回上一页" class="sign_btna btn btn-left btn-fanhui"></a></span>
        <span id="t-index">  
		 <li class="search"><?php echo $data['name']; ?></li></span>
		    </div>
    </div>	
	

<style>
.goodsname {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    padding: 0px;
    font-size: 16px;
    height: 40px;
    color: #444;
    font-weight: bold;
    line-height: 20px;
    margin-top: 10px;
    overflow: hidden;
    background: #fff;
    width: 98%;
    max-height: 650px;
}
.biaoqian1{
	color:#ffffff;border:1px solid #c20000;padding: 0 5px;margin-right:5px;padding-top:0px;border-radius:3px;background:#c20000;font-size:12px;
}
.goodsprice {
    height: 35px;
    line-height: 35px;
    width: 100%;
    max-width: 750px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    padding: 0px;
    background: #fff;
    display: -webkit-box;
    -webkit-box-align: center;
}
.goodsprice .trueprice {
    display: block;
    font-size: 18px;
    color: #f45454;
    margin-right: 5px;
    font-weight: 500;
    font-family: arial;
}
.goodsprice .baseprice {
    display: -webkit-box;
    height: 20px;
    border: 1px solid rgb(245, 77, 35);
    border-radius: 5px;
    -webkit-box-align: center;
}
.detailfanzi {
    background: #f54d23;
    color: #fff;
    display: block;
    height: 20px;
    line-height: 20px;
    text-align: center;
    padding: 0 3px;
    font-size: 14px;
	    font-style: normal;
}
.detailfanmoney {
    color: #f54d23;
    display: block;
    height: 20px;
    line-height: 20px;
    text-align: center;
    -webkit-box-flex: 1;
    font-size: 14px;
    padding: 0 3px;
	    font-style: normal;
}

.better_change{margin:3%; border: 1px dashed #ffd4de;}
.better_change h3{font-weight:normal; color: #f8285c; text-align: center;border-bottom: 1px dashed #ffd4de; background: #fff6f8;opacity:.8; padding: 5px 0;font-size:12px;}
.better_change .better_show{
	padding: 10px 0;
    margin: 0 auto;
    height: 50px;}
.better_change .better_show li{ float: left;width:20%;text-align:center;}
.better_info i{display:block; width:28px; height:28px; margin: 0 auto; background: url("<?php echo config('theme_path'); ?>/index/new/images/better_change.png") no-repeat;background-size:220px auto;}
.better_info .xp{ background-position: 0 0;}
.better_info .xs{ background-position: -33px 0;}
.better_info .cx{ background-position: -73px 0;}
.better_info .tj{ background-position: -111px 0;}
.better_info .by{ background-position: -148px 0;}
.better_info span{display: block; margin-top: 10%; font-size: 12px;color: #999;}



.nbmenu{
    position: fixed;
    width: 100%;
	max-width:640px;
    height: 50px;
    line-height: 50px;
    display: -webkit-box;
    z-index: 10000;
    background:#FAFAFA;
    color:#ffffff;
    font-size:12px;
	margin: auto;
    left: 0;
    right: 0;
    bottom: 0;
	font-family: "Helvetica Neue", Helvetica, STHeiTi, sans-serif;
}
.nbnav{
position: absolute;
z-index:10001;
width:20%;float:left;
}

.nbnav2{
position: absolute;
z-index:10001;
width:30%;float:left;
}

.nb-btn1{bottom:0;left:0;color:#666;text-align:center}
.nb-btn2{bottom:0;left:18%;color:#666;text-align:center}
.nb-btn3{bottom:0;left:40%;background: #FB874E;text-align:center}
.nb-btn3 a{color:#ffffff;}
.nb-btn4{bottom:0;left:70%;background: #f54d23;text-align:center;}
.nb-btn4 a{color:#ffffff;}
 
</style>
<div class="goodsBody" style="overflow:hidden; background:#FFFFFF">
<dl class="goods" style="padding-top: 20px;">
    <dt><cneter>
			<?php if(empty($data['photo_path_1']) || ($data['photo_path_1'] instanceof \think\Collection && $data['photo_path_1']->isEmpty())): ?>
	        	<img style="width:100%;text-align: center;padding: 0px; "  src="<?php echo config('theme_path'); ?>/index/images/nopic.jpg" style="width:100%;display:block"  height='100%'>
	        <?php else: ?>
	        	<img style="width:100%;text-align: center;padding: 0px; "  src="<?php echo root_path(); ?><?php echo $data['photo_path_1']; ?>" style="width:100%;display:block" alt="">
	        <?php endif; ?>
    </cneter></dt>
	<dd style="padding:5px 10px 10px">
      <p class="goodsname"><?php echo $data['name']; ?></p>
	    <div class="goodsprice">
		 <span class="baseprice"><em class="detailfanzi"><?php echo $data['standard']; ?></em><em class="detailfanmoney"><?php echo $data['price']; ?><?php echo config('web_score_danwei'); ?></em></span> 
		 
		</div>
  <p class="line"></p>
	    <div class="lingquan2" style="width: 100%;">
<!--<span style="width: 205px;font-size: 12px;">总销量 <em><?php echo $data['sell_num']; ?></em></span><b></b>
  <div style="float: right;width: 20px;height: 31px;">
		 <img src="<?php echo config('theme_path'); ?>/index/images/<?php echo wap_collection_ico($data['id']); ?>" class="collection" data="<?php echo $data['id']; ?>" style="cursor: pointer;">
		 </div>
-->		 
   </div>

	  </dd>
			<div class="good_but">
				<!-- <div class="but_add "  id="buy-now" dataname="<?php echo $data['name']; ?>" dataprice="<?php echo $data['price']; ?>" dataid="<?php echo $data['id']; ?>">立即购买</div> -->
				<!-- <div style="width:20px"></div> -->
				<!-- <div class="but_add  addcar" style="background-color: #f54d23" dataname="<?php echo $data['name']; ?>" dataprice="<?php echo $data['price']; ?>" dataid="<?php echo $data['id']; ?>" >加入购物车</div> -->
			</div>
	 <div class="better_change"><h3>精挑细选</h3><ul class="better_show clear"><li><div class="better_info"><i class="xp"></i><span>新品特价</span></div></li><li><div class="better_info"><i class="xs"></i><span>限时特卖</span></div></li><li><div class="better_info"><i class="cx"></i><span>诚信品牌</span></div></li><li><div class="better_info"><i class="tj"></i><span>人气推荐</span></div></li><li class="last"><div class="better_info"><i class="by"></i><span>全国包邮</span></div></li></ul><div class="bady-part"><a href="javascript:;"><div  style="margin-top:-10px;margin-bottom:-10px;width:100%;float:left;"><div class="am-panel-hd am-padding-left-0 am-padding-right-0"style="padding-top: 20px;"><h4 class="am-panel-title" style="padding: 10px;background: #ec2d7d;font-size: 16px; color:#fff;"><span id="tabtxt" >商品图文详情</span><span style="float:right"></span></h4></div></div></a><div class="tab1"></div></div></div><div class="normal item-recommend clear"><h3><span></span></h3><ul class="goods-list clear" id="goods_block"></div> 
	  
	  
	  
	  
      	  <div  id="content1" style="padding:10px;text-align: center;">
      	  <div style="padding: 1px">
	 <?php echo $data['content']; ?></div></div>
	 
<div style="height: 40px;"></div>

<style type="text/css">
	
</style>
		<!-- <div class="car-header">
			<div><span class="car-title">购物车</span><span class="car-clear">[清空]</span></div>
			<div style="clear:both"></div>
			<div>
				<table  style="width:100%">
					<tr>
						<td width="55%" style="text-align:left;padding-left:4px">名称</td>
						<td width="15%" style="color:red">单价</td>
						<td width="30%">数量</td>
					</tr>
				</table>
			</div>
		</div> -->
<!--新底部菜单 开始-->

<div class="nbmenu car">
    <div class="nbnav nb-btn1">
        <a href="<?php echo url('Index/index'); ?>">
            <img src="<?php echo config('theme_path'); ?>/index/new/picture/bottombtn0102.png" style="width:20px;position:relative; left:0px;top:5px">首页</a>
    </div>
  
   <!-- <div class="nbnav2 nb-btn3 car-info" style="width: 50%;left: 20%;"><a style="color: #ffffff;font-size: 14px;font-weight:normal;letter-spacing: 0px;" href="javascript:;"  ><img id="car-logo" src="<?php echo config('theme_path'); ?>/index/new/picture/bottombtn0602.png" style="width:30px;position:relative; left:0px;top:10px"> <span class="mui-badge mui-badge-danger" style="display:none">1</span>&nbsp;&nbsp;共<span id="money">0.00</span><?php echo config('web_score_danwei'); ?></a>
    </div> -->
    <!-- <div class="nbnav2 nb-btn4 car-go"><a href="javascript:" class="goodsget" style="color: #ffffff;font-size: 14px;font-weight:normal;letter-spacing: 0px;">去结算</a>
	</div> -->
	<div class="nbnav2 nb-btn4 "  id="buy-now" dataname="<?php echo $data['name']; ?>" dataprice="<?php echo $data['price']; ?>" dataid="<?php echo $data['id']; ?>">立即购买</div>
	
   	
</div>
 
	<script>
		$(function(){

			//检测是否有列表数据
			hasList();

			$('.mui-icon-search').click(function(){
				$(this).css('display','none');
				$('.mui-title').css('display','none');
				$('.mui-search').css('display','block');
			});

			//显示隐藏购物车
			$('.car-info').click(function(){
			 	$('.car-header').slideToggle();
			})
			$('.addcar').on('click',addProductDetail);
			// 点击减号
			$('.minus-item').on('click',function(){
		  		//设置购物车显示
		  		id = $(this).next('span').next('span').attr('dataid');
		  		sub(id);
			})
			//清空购物车
			$('.car-clear').click(function(){
				clear();
			})
			//去结算
			$('.car-go').click(function(){
				location.href ="<?php echo url('cart/index'); ?>";
			})
			//立即购买
			$('#buy-now').click(function(){
				url = "<?php echo url('cart/index'); ?>";
				buyNow(url,$(this));
			})
			$('.show-nav').click(function(){
				$('#h-nav').slideToggle();
			})

			 //收藏
		    $('.collection').click(function(){
		        id = $(this).attr('data');
		        uid = "<?php echo session('wap_user_auth.uid'); ?>";
		        path = "<?php echo config('theme_path'); ?>/index/images/";
		        collection = $(this);
		        num = collection.parent().text();
		        if(uid){
		            $.ajax({
		              cache: true,
		              type: "POST",
		              url : '<?php echo url('collection'); ?>',
		              data: {id:id},
		              async: false,
		                success: function(data) {
		                  if (data.code) {
		                  	alert(data.msg);
		                      collection.attr('src',path+data.data.img);
		                  } else {
		                      alert(data.msg);
		                  }

		                },
		                error: function(request) {
		                	alert('页面错误');
		                }
		            });
		        }else{
		        	alert('请先登录');
		        }
		        
		    })

		})
	</script>
 
</body></html>