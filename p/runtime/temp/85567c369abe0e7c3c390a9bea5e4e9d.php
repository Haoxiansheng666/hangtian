<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:71:"D:\phpstudy_pro\WWW\p\public/../application/admin\view\admin\index.html";i:1545882494;s:60:"D:\phpstudy_pro\WWW\p\application\admin\view\common\top.html";i:1541637510;s:63:"D:\phpstudy_pro\WWW\p\application\admin\view\common\header.html";i:1541637510;s:64:"D:\phpstudy_pro\WWW\p\application\admin\view\common\sidebar.html";i:1541637510;s:63:"D:\phpstudy_pro\WWW\p\application\admin\view\common\bottom.html";i:1541637510;}*/ ?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta charset="utf-8" />
<title><?php if(isset($info['name'])): ?><?php echo $info['name']; ?> - <?php endif; ?> <?php echo $pagename; ?> -  <?php echo config('WEB_SITE_NAME'); ?>管理后台</title>
<meta name="description" content=" <?php echo config('WEB_SITE_DESCRIPTION'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
<link rel="stylesheet" href="/static/ace/css/bootstrap.css" />
<link rel="stylesheet" href="/static/ace/css/font-awesome.css" />
<link rel="stylesheet" href="/static/ace/css/ace-fonts.css" />
<link rel="stylesheet" href="/static/ace/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />
<script src="/static/ace/js/ace-extra.js"></script>
<script type="text/javascript">window.jQuery || document.write("<script src='/static/ace/js/jquery.js'>"+"<"+"/script>");</script>
<script type="text/javascript">if('ontouchstart' in document.documentElement) document.write("<script src='/static/ace/js/jquery.mobile.custom.js'>"+"<"+"/script>");</script>
<style type="text/css">
input[type="date"], input[type="time"], input[type="datetime-local"], input[type="month"] {
  line-height: inherit;
}
.help-inline{
  line-height: 32px;
}
select{
	height: 34px;
}
.main-container .table tr td {
	vertical-align: middle;
}
.main-container .table tr td a{
	margin-right:10px;
}
#preview{
  height: 120px;
  width: auto;
}
</style>
<style type="text/css">
    .main-container .table tr td {
        vertical-align: middle;
    }
    .main-container .table tr td a{
        margin-right:10px;
    }
</style>
</head>
<body class="no-skin">
    <div id="navbar" class="navbar navbar-default">
  <div class="navbar-container" id="navbar-container">
  <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar"> <span class="sr-only">Toggle sidebar</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
    <div class="navbar-header pull-left"> <a href="<?php echo url('Index/index'); ?>" class="navbar-brand"> <small><?php echo \think\Config::get('WEB_SITE_NAME'); ?>网站管理后台 </small> </a> </div>
    <div class="navbar-buttons navbar-header pull-right" role="navigation">
      <ul class="nav ace-nav">
        <li class="light-blue"> <a data-toggle="dropdown" href="#" class="dropdown-toggle"> <img class="nav-user-photo" src="/static/ace/avatars/user.png" />
        <span class="user-info"><small>欢迎你</small><?php echo $_SESSION['think']['username']; ?></span> <i class="ace-icon fa fa-caret-down"></i> </a>
          <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
            <li> <a href="<?php echo url('Index/repwd'); ?>"> <i class="ace-icon fa fa-cog"></i> 修改密码 </a></li>
            <li> <a href="<?php echo url('Publics/logout'); ?>"> <i class="ace-icon fa fa-power-off"></i> 退出后台 </a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</div>
    <div class="main-container" id="main-container"> <div id="sidebar" class="sidebar ">
  <div class="sidebar-shortcuts" id="sidebar-shortcuts">
    <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
      <button class="btn btn-success">
      <i class="ace-icon fa fa-group"></i>
      </button>
      <button class="btn btn-info">
      <i class="ace-icon fa fa-list"></i>
      </button>
      <button class="btn btn-warning">
      <i class="ace-icon fa fa-arrow-circle-up"></i>
      </button>
      <button class="btn btn-danger">
      <i class="ace-icon fa fa-cog"></i>
      </button>
    </div>
    <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
      <span class="btn btn-success"></span>
      <span class="btn btn-info"></span>
      <span class="btn btn-warning"></span>
      <span class="btn btn-danger"></span>
    </div>
  </div>
  <ul class="nav nav-list">
    <?php if(is_array($sidebar) || $sidebar instanceof \think\Collection || $sidebar instanceof \think\Paginator): $i = 0; $__LIST__ = $sidebar;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
      <li <?php if($vo['name'] == $rule2): ?>class="open active"<?php endif; ?>><a href="<?php echo url('/'.$vo['name']); ?>" <?php if($vo['count'] != 0): ?>class="dropdown-toggle"<?php endif; ?>><i class="menu-icon fa fa-<?php echo $vo['icon']; ?>"></i><span class="menu-text"> <?php echo $vo['title']; ?> </span><b class="arrow <?php if($vo['count'] != 0): ?>fa fa-angle-down<?php endif; ?>"></b></a>
        <b class="arrow"></b>
        <ul class="submenu">
          <?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($i % 2 );++$i;?>
          <li <?php if($sub['name'] == $rule): ?>class="active"<?php endif; ?>><a href="<?php echo url('/'.$sub['name']); ?>"><i class="menu-icon fa fa-caret-right"></i> <?php echo $sub['title']; ?> </a><b class="arrow"></b></li>
          <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
      </li>
    <?php endforeach; endif; else: echo "" ;endif; ?>
  </ul>
  <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
    <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
  </div>
</div>
        <div class="main-content">
            <div class="main-content-inner">
                <div class="breadcrumbs" id="breadcrumbs">
                    <ul class="breadcrumb">
                        <li> <i class="ace-icon fa fa-home home-icon"></i> <a href="<?php echo url('Index/index'); ?>"><?php echo config('WEB_SITE_NAME'); ?></a> </li>
                        <li> <a href="<?php echo url('index'); ?>">权限管理</a> </li>
                        <li class="active"><?php echo $pagename; ?></li>
                    </ul>
                </div>
                <div class="page-content">
                    <div class="page-header">
                        <h1> <?php echo $pagename; ?> <small> <i class="ace-icon fa fa-angle-double-right"></i> 一共<?php echo $info['count']; ?>个用户 </small> </h1>
                    </div>
                    <div class="row">
                        <div class="col-xs-12" style="margin-bottom:10px;">
                            <form action="<?php echo url('index'); ?>" method="get" class="form-inline" role="form">
                                <div class="form-group">
                                    <label>关键词</label>
                                    <input name="keywords" type="text" class="form-control" placeholder="用户名">
                                </div>
                                <button type="submit" class="btn btn-sm btn-primary">查询</button>
                                <a class="btn btn-sm btn-success" style="float:right; margin-right:10px;" href="<?php echo url('add_user'); ?>" >新增用户</a>
                                <button type="reset" class="btn btn-sm btn-danger hidden-xs" style="float:right;margin-right:10px;">清空查询条件</button>
                            </form>
                        </div>
                        <div class="col-xs-12">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="center">用户ID</th>
                                        <th>用户名</th>
                                        <th>用户类型</th>
                                        <th>用户备注</th>
                                        <th>最后登录时间</th>
                                        <th>最后登录IP</th>
                                        <th>更新时间</th>
                                        <th>登陆次数</th>
                                        <th>用户状态</th>
                                        <th>创建时间</th>
                                        <th>操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(is_array($info['list']) || $info['list'] instanceof \think\Collection || $info['list'] instanceof \think\Paginator): $k = 0; $__LIST__ = $info['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
                                    <tr>
                                        <td class="center"> <?php echo $vo['id']; ?></td> 
                                        <td> <?php echo $vo['username']; ?> </td>
                                        <td> <?php echo $vo['user_type']; ?> </td>
                                        <td> <?php echo $vo['description']; ?> </td>
                                        <td> <?php echo date("Y-m-d H:i:s",$vo['last_login_time']); ?> </td>
                                        <td> <?php echo $vo['last_login_ip']; ?> </td>
                                        <td> <?php echo $vo['update_time']; ?> </td>
                                        <td> <?php echo $vo['login_number']; ?> </td>
                                        <td> <?php echo $vo['status']; ?> </td>
                                        <td> <?php echo $vo['create_time']; ?> </td>
                                        <td>
                                            <a class="btn btn-sm btn-success" href="<?php echo url('edit_user?id='.$vo['id']); ?>">修改</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>
                            <div style="width:100%;margin: 0 auto; text-align:center;">
                                <ul class="pagination" >
                                    <?php echo $info['page']; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer">
            <div class="footer-inner">
                <div class="footer-content"> <span class="bigger-120"> <span class="blue bolder"><?php echo config('WEB_SITE_NAME'); ?> </span><?php echo WEB_VERSION; ?>版 </span></div>
            </div>
        </div>
        <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse"><i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i></a> </div>
    <!-- basic scripts --> 
    <script type="text/javascript">if($(window).width()<1024)  $("#sidebar").addClass('menu-min');</script>
<script src="/static/ace/js/bootstrap.js"></script>
<script src="/static/ace/js/ace/ace.js"></script> 
<script src="/static/ace/js/ace/ace.sidebar.js"></script> 
    <script src="/static/ace/js/layer/layer.js"></script>
    <script type="text/javascript">
        $('a[href="/Admin/Admin/index.html"]').parents().filter('li').addClass('open active');
        <?php if(input('get.keywords')): ?>
        $('input[name="keywords"]').val('<?php echo $_GET["keywords"]; ?>');
        <?php endif; if(is_numeric(input('get.is_show'))): ?>
        $('select[name="is_show"]').val(<?php echo $_GET['is_show']; ?>);
        <?php endif; ?>
    </script>
    <script type="text/javascript">
                jQuery(function($) {
                //清除查询条件
                $(document).on('click', 'button:reset', function() {
                location.href = '<?php echo url('index'); ?>';
                });
                if ('<?php echo \think\Request::instance()->get('keywords'); ?>'){
                $('input[name="keywords"]').val('<?php echo \think\Request::instance()->get('keywords'); ?>');
                }
                if ('<?php echo \think\Request::instance()->get('group_id'); ?>'){
                $('select[name="group_id"]').val('<?php echo \think\Request::instance()->get('group_id'); ?>');
                }
                });
    </script>
</body>
</html>