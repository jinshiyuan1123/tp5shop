<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:55:"D:\phpStudy\WWW/application/admin\view\config\edit.html";i:1527374143;s:55:"D:\phpStudy\WWW/application/admin\view\common\head.html";i:1525738497;s:57:"D:\phpStudy\WWW/application/admin\view\common\header.html";i:1501063294;s:57:"D:\phpStudy\WWW/application/admin\view\common\navbar.html";i:1477622211;s:57:"D:\phpStudy\WWW/application/admin\view\common\footer.html";i:1501054036;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>睿胜科技工作室</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Msgbox -->
  <link rel="stylesheet" href="STATIC_PATH/msgbox/css/style.css">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="STATIC_PATH/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="STATIC_PATH/dist/css/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="STATIC_PATH/dist/css/ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="STATIC_PATH/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="STATIC_PATH/dist/css/skins/_all-skins.min.css">
  
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="STATIC_PATH/dist/js/html5shiv.min.js"></script>
  <script src="STATIC_PATH/dist/js/respond.min.js"></script>
  <![endif]-->
</head>
<body class="skin-blue sidebar-mini wysihtml5-supported fixed">
<div class="wrapper">

   <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo url('index/index'); ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>L</b>S</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>后台管理</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
         <!--  <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
           
          </li> -->
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
             
              <li class="footer"><a href="#">View all</a></li>
            </ul> -->
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul> -->
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
             
              <span class="hidden-xs"><?php echo Session('admin_user_auth.username'); ?></span>
            </a>
            <ul class="dropdown-menu">
 
              <li class="user-footer">
                <div class="pull-right">
                  <a href="<?php echo url('user/edit'); ?>" class="btn btn-default btn-flat">个人资料</a>
                  
                </div>
                </li>
                <li>
                 <div class="box-footer">
                  
                   <a href="<?php echo url('common/logout'); ?>" class="btn btn-default btn-flat">退出</a>
                </div>
                
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
         <!--  <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> -->
        </ul>
      </div>
    </nav>
  </header>
  
  <!-- Left side column. contains the logo and sidebar -->
 
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel" style="height:40px;">
        <div class="pull-left info">
          <p><?php echo Session('admin_user_auth.username'); ?> <a href="#"><i class="fa fa-circle text-success"></i> </a></p>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">导航</li>
        <?php if(is_array($menuTree) || $menuTree instanceof \think\Collection): $i = 0; $__LIST__ = $menuTree;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <li class="<?php echo get_menu_navbar_active($vo['id']); ?> treeview">
          <a href="<?php echo $vo['url']; ?>">
            <i class="<?php echo $vo['icon']; ?>"></i> <span><?php echo $vo['name']; ?></span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <?php if(!(empty($vo['_child']) || ($vo['_child'] instanceof \think\Collection && $vo['_child']->isEmpty()))): ?>
          <ul class="treeview-menu">
            <?php if(is_array($vo['_child']) || $vo['_child'] instanceof \think\Collection): $i = 0; $__LIST__ = $vo['_child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($i % 2 );++$i;?>
                <li class="<?php echo get_menu_navbar_active($sub['id']); ?>"><a href="<?php echo url($sub['url']); ?>"><i class="<?php echo $sub['icon']; ?>"></i><?php echo $sub['name']; ?></a></li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
          </ul>
          <?php endif; ?>
        </li>
        <?php endforeach; endif; else: echo "" ;endif; ?>
      </ul>
    </section>
    <!-- /.sidebar -->
</aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        设置
        <small>基本设置</small>
      </h1>
      <ol class="breadcrumb">
       <li><a href="<?php echo url('admin/index/index'); ?>"><i class="fa fa-dashboard"></i> 主页</a></li>
        <li><a href="<?php echo url('admin/config/edit'); ?>">设置</a></li>
        <li class="active">基本设置</li>
      </ol>
    </section>

    <!-- Main content -->
      <!-- form start -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
           <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">基本设置</h3>
              <!-- <a type="button" href="<?php echo url('add'); ?>" class="btn btn-primary pull-right">新 增</a> -->
            </div>
            <div class="tab-content">
              <!-- Font Awesome Icons -->
              <form  method="post" action="" id='form1'>
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">网站标题 </label>
                  <input type="text" class="form-control" id="title" name="web_site_title" value="<?php echo $list['web_site_title']; ?>" placeholder="网站标题前台显示标题" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">网站公告</label>
                  <input type="text" class="form-control" id="gonggao" value="<?php echo $list['web_gonggao']; ?>" name="web_gonggao" placeholder="设置公告" />
                </div>
                <label for="exampleInputEmail1">网站首页图片 </label>
                <div class="box-tools">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"> 
                  </button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body no-padding">
                <div class="box-body">
                  <div id="uploader-demo">
                      <!--用来存放item-->
                      <input type="hidden" name="web_logo_cover_path" value="<?php echo $list['web_logo_cover_path']; ?>" class="cover_path">
                      <div id="cover_path" class="uploader-list">
                        <div class="file-item thumbnail upload-state-done">
                          <?php if(!(empty($list['web_logo_cover_path']) || ($list['web_logo_cover_path'] instanceof \think\Collection && $list['web_logo_cover_path']->isEmpty()))): ?>
                          <img src="ROOT_PATH<?php echo $list['web_logo_cover_path']; ?>" width="120" height="120">
                          <?php endif; ?>
                        </div>
                      </div>
                  </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                  <div class="insertCover">添加图片</div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">网站首页图片跳转地址</label>
                  <input type="text" class="form-control" id="sy_tzurl" value="<?php echo $list['web_sy_tzurl']; ?>" name="web_sy_tzurl" placeholder="网站首页图片跳转地址" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">当下分红池</label>
                  <input type="text" class="form-control" id="qqfh_money" value="<?php echo $list['web_qqfh_money']; ?>" name="web_qqfh_money" placeholder="设置当下分红池" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">会员复投价格（元）</label>
                  <input type="text" class="form-control" id="user_jhmoney" value="<?php echo $list['web_user_jhmoney']; ?>" name="web_user_jhmoney" placeholder="设置激活会员价格" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">会员直推奖励（元）</label>
                  <input type="text" class="form-control" id="user_ztmoney" value="<?php echo $list['web_user_ztmoney']; ?>" name="web_user_ztmoney" placeholder="设置会员直推奖励金额" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">C层升B层奖励（元）</label>
                  <input type="text" class="form-control" id="user_scmoney1" value="<?php echo $list['web_user_scmoney1']; ?>" name="web_user_scmoney1" placeholder="C层升B层奖励金额" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">B层升A层奖励（元）</label>
                  <input type="text" class="form-control" id="user_scmoney2" value="<?php echo $list['web_user_scmoney2']; ?>" name="web_user_scmoney2" placeholder="B层升A层奖励金额" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">A层升队长奖励（元）</label>
                  <input type="text" class="form-control" id="user_scmoney3" value="<?php echo $list['web_user_scmoney3']; ?>" name="web_user_scmoney3" placeholder="A层升队长奖励金额" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">队长出局奖励（元）</label>
                  <input type="text" class="form-control" id="user_scmoney4" value="<?php echo $list['web_user_scmoney4']; ?>" name="web_user_scmoney4" placeholder="队长出局奖励金额" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">注册或复投时进入全球分红的比例(百分比形式)</label>
                  <input type="text" class="form-control" id="qqfh_bili" value="<?php echo $list['web_qqfh_bili']; ?>" name="web_qqfh_bili" placeholder="注册或复投时进入全球分红的比例" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">直推5人,钻石区分红比例(百分比形式)</label>
                  <input type="text" class="form-control" id="fanli_1" value="<?php echo $list['web_fanli_1']; ?>" name="web_fanli_1" placeholder="直推5人,钻石区分红比例" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">直推10人,钻石区分红比例(百分比形式)</label>
                  <input type="text" class="form-control" id="fanli_2" value="<?php echo $list['web_fanli_2']; ?>" name="web_fanli_2" placeholder="直推10人,钻石区分红比例" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">直推20人,钻石区分红比例(百分比形式)</label>
                  <input type="text" class="form-control" id="fanli_3" value="<?php echo $list['web_fanli_3']; ?>" name="web_fanli_3" placeholder="直推20人,钻石区分红比例" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">直推30人,钻石区分红比例(百分比形式)</label>
                  <input type="text" class="form-control" id="fanli_4" value="<?php echo $list['web_fanli_4']; ?>" name="web_fanli_4" placeholder="直推30人,钻石区分红比例" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">直推50人,钻石区分红比例(百分比形式)</label>
                  <input type="text" class="form-control" id="fanli_5" value="<?php echo $list['web_fanli_5']; ?>" name="web_fanli_5" placeholder="直推50人,钻石区分红比例" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">直推80人,公司总营业额分红比例(百分比形式)</label>
                  <input type="text" class="form-control" id="fanli_6" value="<?php echo $list['web_fanli_6']; ?>" name="web_fanli_6" placeholder="直推80人,公司总营业额分红比例" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">每个级别限制分红次数(次)</label>
                  <input type="text" class="form-control" id="fenhong_num" value="<?php echo $list['web_fenhong_num']; ?>" name="web_fenhong_num" placeholder="每个级别限制分红次数" />
                </div>





                
                <!-- <div class="form-group">
                  <label for="exampleInputPassword1">激活赠底分</label>
                  <input type="text" class="form-control" id="jihuo_df" value="<?php echo $list['web_jihuo_df']; ?>" name="web_jihuo_df" placeholder="设置1为开启0为关闭" />
                </div> -->
                <div class="form-group">
                  <label for="exampleInputPassword1">提现最小（元）</label>
                  <input type="text" class="form-control" id="tixian_zx" value="<?php echo $list['web_tixian_zx']; ?>" name="web_tixian_zx" placeholder="设置提现最小金额" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">提现手续费（百分比）</label>
                  <input type="text" class="form-control" id="tixian_sf" value="<?php echo $list['web_tixian_sf']; ?>" name="web_tixian_sf" placeholder="设置提现手续费" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">提现需直推几人（人）</label>
                  <input type="text" class="form-control" id="tixian_zt" value="<?php echo $list['web_tixian_zt']; ?>" name="web_tixian_zt" placeholder="设置提现需直推几人" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">积分单位</label>
                  <input type="text" class="form-control" id="score_danwei" value="<?php echo $list['web_score_danwei']; ?>" name="web_score_danwei" placeholder="设置积分单位 如：分" />
                </div>  

                <div class="form-group">
                  <label for="exampleInputPassword1">积分名称</label>
                  <input type="text" class="form-control" id="score_name" value="<?php echo $list['web_score_name']; ?>" name="web_score_name" placeholder="设置积分名称 如：信用分" />
                </div>              
                <!-- <div class="form-group">
                  <label for="exampleInputPassword1">保底积分（分）</label>
                  <input type="text" class="form-control" id="user_bdscore" value="<?php echo $list['web_user_bdscore']; ?>" name="web_user_bdscore" placeholder="设置涨了保底积分" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">积分每天复利（%）</label>
                  <input type="text" class="form-control" id="score_fulilu" value="<?php echo $list['web_score_fulilv']; ?>" name="web_score_fulilv" placeholder="设置每天复利率" />
                </div>            
                <div class="form-group">
                  <label for="exampleInputPassword1">不可转出时间（分钟）</label>
                  <input type="text" class="form-control" id="score_bkzc" value="<?php echo $list['web_score_bkzc']; ?>" name="web_score_bkzc" placeholder="设置交易的积分多久之内不能进行交易" />
                </div>  
                <div class="form-group">
                  <label for="exampleInputPassword1">一次最多转入（分）</label>
                  <input type="text" class="form-control" id="score_bkzc" value="<?php echo $list['web_score_zdzr']; ?>" name="web_score_zdzr" placeholder="设置积分交易一次最多转入交易额度 0为不限制额度" />
                </div>
        
                <div class="form-group">
                  <label for="exampleInputPassword1">激活会员上七级返利（元）</label>
                  <input type="text" class="form-control" id="fanli_7" value="<?php echo $list['web_fanli_7']; ?>" name="web_fanli_7" placeholder="设置激活会员上一级返利" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">激活会员上八级返利（元）</label>
                  <input type="text" class="form-control" id="fanli_8" value="<?php echo $list['web_fanli_8']; ?>" name="web_fanli_8" placeholder="设置激活会员上一级返利" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">激活会员上九级返利（元）</label>
                  <input type="text" class="form-control" id="fanli_9" value="<?php echo $list['web_fanli_9']; ?>" name="web_fanli_9" placeholder="设置激活会员上一级返利" />
                </div> -->
                <!-- <div class="form-group">
                  <label for="exampleInputPassword1">每人每天转盘次数</label>
                  <input type="text" class="form-control" id="lucky_cs" value="<?php echo $list['web_lucky_cs']; ?>" name="web_lucky_cs" placeholder="设置每天转盘次数 0为不限制" />
                </div> -->
                <!-- <div class="form-group">
                  <label for="exampleInputPassword1">每次转盘需要多少积分（分）</label>
                  <input type="text" class="form-control" id="lucky_score" value="<?php echo $list['web_lucky_score']; ?>" name="web_lucky_score" placeholder="设置每次转盘需要多少积分" />
                </div> -->
              <!-- <div class="form-group">
              <label for="exampleInputPassword1">转盘奖项设置</label>
                  <script type="text/plain" id="editor" name="web_lucky_jxsz" style="height:200px;"><?php echo $list['web_lucky_jxsz']; ?></script>
              </div>
              <div class="form-group">
              <label for="exampleInputPassword1">转盘活动说明</label>
                  <script type="text/plain" id="editor1" name="web_lucky_hdsm" style="height:200px;"><?php echo $list['web_lucky_hdsm']; ?></script>
              </div> -->
              <div class="pull-right">
                <button class="btn btn-success" onclick="javascript:history.back(-1);return false;">返 回</button>&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="button" onclick="submitInfo()" class="btn btn-primary">确 定</button>
              </div>
            </form>
                
              </div>
              <!-- /#fa-icons -->

            </div>
            <!-- /.tab-content -->
          </div>
          </div>
          <!-- /.nav-tabs-custom -->
          </section>
           </div>
 
  <!-- /.content-wrapper -->
   
<script src="STATIC_PATH/plugins/jQuery/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="STATIC_PATH/msgbox/js/msgbox.js"></script>



  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<script src="STATIC_PATH/plugins/jQuery/jquery-1.9.1.min.js"></script>
<script src="STATIC_PATH/plugins/jQueryUI/jquery-ui.min.js"></script>
<script type="text/javascript">
  var uploadPictuer     = '<?php echo url('Upload/uploadPicture'); ?>';
  var uploadFlash       = 'STATIC_PATH/plugins/webuploader/dist/Uploader.swf';
  var ueditorUploadPath = '<?php echo url('ueditor/index'); ?>';
</script>
<!-- Page Script -->
<script type="text/javascript" charset="utf-8" src="STATIC_PATH/plugins/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="STATIC_PATH/plugins/ueditor/ueditor.all.min.js"> </script>
<link rel="stylesheet" type="text/css" href="STATIC_PATH/plugins/webuploader/css/webuploader.css" />
<script type="text/javascript" src="STATIC_PATH/plugins/webuploader/dist/webuploader.js"></script>
<script type="text/javascript" src="STATIC_PATH/plugins/webuploader/dist/onefile.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
  function submitInfo(){
 
    $.ajax({
      type: "POST",
      cache: true,
      url: "<?php echo url('admin/config/edit'); ?>",
      data: $('#form1').serialize(),
      dataType: "json",
      async: false,
      success: function(data) {
        if (data.code) {
          msgok(data.msg);
          location.reload();                  
        } else {
          msgerr(data.msg);
        }
      },
      error: function(request) {
        msgerr("页面错误");
      }
    });
  }
</script>
 
<!-- Bootstrap 3.3.6 -->
<script src="STATIC_PATH/bootstrap/js/bootstrap.min.js"></script>
<!-- Slimscroll -->
<script src="STATIC_PATH/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- AdminLTE App -->
<script src="STATIC_PATH/dist/js/app.min.js"></script>
<script type="text/javascript">

    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    var ue = UE.getEditor('editor');
    function setContent(isAppendTo) {
        var arr = [];
        arr.push("使用editor.setContent('欢迎使用ueditor')方法可以设置编辑器的内容");
        UE.getEditor('editor').setContent('欢迎使用ueditor', isAppendTo);
        msginfo(arr.join("\n"));
    }
    var ue = UE.getEditor('editor1');
    function setContent(isAppendTo) {
        var arr = [];
        arr.push("使用editor.setContent('欢迎使用ueditor')方法可以设置编辑器的内容");
        UE.getEditor('editor').setContent('欢迎使用ueditor', isAppendTo);
        msginfo(arr.join("\n"));
    }
</script>
</body>
</html>






