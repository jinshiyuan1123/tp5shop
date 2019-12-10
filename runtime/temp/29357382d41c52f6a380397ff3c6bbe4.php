<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:39:"./themes/default/index/user_center.html";i:1575942787;}*/ ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
<title>个人中心</title>

<link rel=stylesheet type=text/css href="<?php echo config('theme_path'); ?>/index/new/css/user_index.css" />
<link rel="stylesheet" type="text/css" href="<?php echo config('theme_path'); ?>/index/css/liMarquee.css">
<script type="text/javascript" src="<?php echo config('theme_path'); ?>/index/new/js/user_index.js"></script>
<script src="<?php echo config('theme_path'); ?>/index/js/jquery.liMarquee.js"></script> 
</head>
<body>  
 <style type="text/css">
.tuichu{background:#EC1A5B;width:95%; float:left;  padding:15px 0 ; margin-left:5px; margin:5px 0 10px 10px;font-size:16px; text-align:center; color:#fff;border-radius:4px;}
.tuichu a{text-align:center; color:#fff; font-weight:600}
.xziti{font-size: 12px;color: #fe7600;}
.cefeff4{color: #ccc}
.name{text-align: left;}
.name a{color: #fff;}
.bdziti{width: 100%;height: 50px;background-color:rgba(255,255,255,0.2);margin-top:10px;text-align: left;padding-left: 10px;}
.bdziti b{font-size: 40px;color: #fff;line-height: 50px;}
.zzan{float: right;border: 1px solid #fff;border-radius: 3px;padding:0 5px;font-size: 14px;line-height: 24px;margin-top: 3px;margin-right: 10px;color: #fff}
</style>
 <div class="user_top" align="center">
 <img class="user_tb" src="<?php echo config('theme_path'); ?>/index/new/picture/noavatar_middle.jpg"></a>
 <div class="name"><?php echo $userInfo['nickname']; ?><br>推荐人：<?php echo $tuijianren; ?></div>
 <div class="name clear" style="height: 35px;margin-left:10px;margin-top:10px;  "><a href="<?php echo url('user/user_withdrawal'); ?>">累计提现：<?php echo $ytixian; ?>元</a></div>
 <div style="color: #fff;line-height: 24px;text-align: left;font-size: 16px;padding-left: 10px;">
   <?php if($is_gongpai == '1'): ?>
       公排位置:
       <?php switch($gp_user['jibie']): case "0": ?>D层<?php break; case "1": ?>C层<?php break; case "2": ?>B层<?php break; case "3": ?>A层<?php break; case "4": ?>队长<?php break; endswitch; ?>
       第<?php echo $gp_user['bcsx']; ?>个位置
   <?php endif; ?>
  </div>
 <!-- <div style="color: #fff;line-height: 24px;text-align: left;font-size: 22px;padding-left: 10px;"><?php echo $tyjfmc; ?><a href="<?php echo url('user/turnadd'); ?>" class="zzan">转赠</a> <?php if($userInfo['is_jh'] == 0): ?> <a href="javascript:" id="jihuo" class="zzan" style="margin-right: 10px">激活</a><?php endif; ?></div> -->
 <div class="bdziti">
 	<b id="ed_div" style="font-family:'Arial'">
<?php echo number_format($userInfo['score'],2,".", "");if($userInfo['status']==2){echo '(封停)';} ?></b>
 </div>
 </div>
 <div class="dgg"> &thinsp; &thinsp; &thinsp; &thinsp;<?php echo config('web_gonggao'); ?></div>
	<div class="vipduo_user clear">
			<div class="vipduo_tu">

    <a href="<?php echo url('index/index'); ?>"><img src="<?php echo config('theme_path'); ?>/index/new/picture/sc.png"><span>商城</span><span class="xziti cefeff4">在线商城</span></a>
	<a href="<?php echo url('user/user_withdrawal'); ?>"><img src="<?php echo config('theme_path'); ?>/index/new/picture/fx.png"><span>申请提现</span><span class="xziti cefeff4">点击进行申请</span></a>
	<a href="<?php echo url('user/score_detail'); ?>"><img src="<?php echo config('theme_path'); ?>/index/new/picture/u-detailed.png"><span><?php echo $tyjfmc; ?>明细</span><span class="xziti cefeff4">查询<?php echo $tyjfmc; ?></span></a>
	<a href="<?php echo url('user/userProfile'); ?>"><img src="<?php echo config('theme_path'); ?>/index/new/picture/u-authfield.png"><span>完善资料</span><span class="xziti cefeff4">修改资料</span></a>
	<a href="<?php echo url('user/user_fenhong'); ?>"><img src="<?php echo config('theme_path'); ?>/index/new/picture/cz1.png"><span>全球分红</span>
	<span class="xziti cefeff4">预估分红</span></a>
	<a href="<?php echo url('user/editmobile'); ?>"><img src="<?php echo config('theme_path'); ?>/index/new/picture/u-bind.png"><span>绑定手机</span>
	<span class="xziti"><?php echo $userInfo['mobile']; ?></span></a>
	<a href="<?php echo url('user/user_friends'); ?>"><img src="<?php echo config('theme_path'); ?>/index/new/picture/qt.png"><span>我的战队</span>
    <span class="xziti"><?php echo $hys; ?>个</span></a> 
  	<a href="<?php echo url('user/user_friends1'); ?>"><img src="<?php echo config('theme_path'); ?>/index/new/picture/qt.png"><span>我的团队</span>
      <span class="xziti"><?php echo $zt_count; ?>个</span></a> 
	<a href="<?php echo url('user/user_link'); ?>"><img src="<?php echo config('theme_path'); ?>/index/new/picture/zhuan.png"><span>邀请好友</span>
	<span class="xziti cefeff4">推广链接</span></a>
	<a href="<?php echo url('order/orderLists'); ?>"><img src="<?php echo config('theme_path'); ?>/index/new/picture/u-tradelist.png"><span>我的订单</span>
	<span class="xziti cefeff4">购物订单</span></a>
	<!-- <a href="<?php echo url('collection/collection'); ?>"><img src="<?php echo config('theme_path'); ?>/index/new/picture/u-msg.png"><span>我的收藏</span>
	<span class="xziti cefeff4">商品收藏</span></a> -->
	<a href="<?php echo url('user/editpassword'); ?>"><img src="<?php echo config('theme_path'); ?>/index/new/picture/u-invite.png"><span>修改密码</span>
	<span class="xziti cefeff4">立即修改</span></a>
	<a href="http://wpa.qq.com/msgrd?v=3&uin=1136231693"><img src="<?php echo config('theme_path'); ?>/index/new/picture/tc.png"><span>帮助</span>
  <span class="xziti cefeff4">在线咨询</span></a>
  
</div></div>     
	</div>
	<!-- 可视区域5 -->
	<a href="<?php echo url('common/logout'); ?>"><div style="width: 80%;height:40px;background: #EC1A5B;color: #fff;font-size:16px;margin: 0 auto;margin-top: 1rem;margin-bottom: 1rem;text-align: center;line-height: 3rem;border-radius: 0.5rem;">退出登录</div></a>
	<div style="text-align: center;color: #999;font-size: 0.8rem;margin-bottom: 5rem;"></div>
</div>	
<!--
    <?php if(empty($scoreorder) || ($scoreorder instanceof \think\Collection && $scoreorder->isEmpty())): else: ?>
    <div class="yjhhy">
    <ul>
      <?php if(is_array($scoreorder) || $scoreorder instanceof \think\Collection): $k = 0; $__LIST__ = $scoreorder;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($k % 2 );++$k;?>
      <li><?php echo $data['nickname']; ?> 激活成功 <span><?php echo date('m-d H:i:s',$data['paytime']);  ?></span></li>
      <?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
    </div>
	 <?php endif; ?>
-->
<div id="jihuotc" style="position: fixed;top:0;left: 0;background: rgba(0,0,0,0.5);width: 100%;height: 100%;display: none;">
<div style="position: fixed;top:50%;left: 50%;margin-left: -105px;margin-top:-121px;width: 210px;height: 242px;"><img src="<?php echo config('theme_path'); ?>/index/new/picture/kefu.png"></div>

<script type="text/javascript">
$(function(){
        $('.dgg').liMarquee({
             hoverstop: false
        });
       $('.yjhhy ul').liMarquee({
            direction: 'up',
            scrollamount:30
        });
       $('#jihuo').click(function(){
          $('#jihuotc').show();
       })
       $('#jihuotc').click(function(){
          $(this).hide();
       })

})




</script>


   <!-- 底部结束 -->


  
</body></html>