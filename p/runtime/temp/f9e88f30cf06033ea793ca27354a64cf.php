<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:72:"D:\11\guanwang2\public/../application/admin\view\notice_types\index.html";i:1587693932;s:54:"D:\11\guanwang2\application\admin\view\common\top.html";i:1541637509;s:57:"D:\11\guanwang2\application\admin\view\common\header.html";i:1541637509;s:58:"D:\11\guanwang2\application\admin\view\common\sidebar.html";i:1541637509;s:57:"D:\11\guanwang2\application\admin\view\common\bottom.html";i:1541637509;}*/ ?>
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

    .main-container .table tr td a {
        margin-right: 10px;
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
                    <li><i class="ace-icon fa fa-home home-icon"></i> <a href="<?php echo url('Index/index'); ?>"><?php echo config('WEB_SITE_NAME'); ?></a>
                    </li>
                    <li><a href="<?php echo url('index'); ?>">信息管理</a></li>
                    <li class="active"><?php echo $pagename; ?></li>
                </ul>
            </div>
            <div class="page-content">
                <div class="page-header">
                    <h1> <?php echo $pagename; ?>
                        <small><i class="ace-icon fa fa-angle-double-right"></i> 查询出<?php echo $info['count']; ?>条数据</small>
                    </h1>
                </div>
                <!-- /.page-header -->
                <div class="row">
                    <div class="col-xs-12">
                        <!-- PAGE CONTENT BEGINS -->
                        <div class="row">
                            <div class="col-xs-12" style="margin-bottom:10px;">
                                <form action="<?php echo url('index'); ?>" method="get" class="form-inline" role="form">
                                    <a class="btn btn-sm btn-success" style="float:right; margin-right:10px;"
                                       href="<?php echo url('add'); ?>">添加资讯类型</a>
                                </form>
                            </div>
                            <div class="col-xs-12">
                                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th class="center">ID</th>
                                        <th>名称</th>
                                        <th>显示状态</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($info['list']) || $info['list'] instanceof \think\Collection || $info['list'] instanceof \think\Paginator): $k = 0; $__LIST__ = $info['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
                                    <tr>
                                        <td class="center"><?php echo $vo['id']; ?></td>
                                        <td><?php echo $vo['name']; ?></td>
                                        <td>
                                            <select class="state form-control" data-id="<?php echo $vo['id']; ?>">
                                                <?php if(is_array($state) || $state instanceof \think\Collection || $state instanceof \think\Paginator): $i = 0; $__LIST__ = $state;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$so): $mod = ($i % 2 );++$i;?>
                                                <option value="<?php echo $so['value']; ?>" <?php if($vo['is_show'] == $so['value']): ?>selected<?php endif; ?> ><?php echo $so['key']; ?></option>
                                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-success"
                                               href="<?php echo url('edits',array('id'=>$vo['id'])); ?>">修改</a>
                                            <a class="btn btn-sm btn-danger" href="javascript:void(0);"
                                               onclick="deleteInfo(this,<?php echo $vo['id']; ?>)">删除</a>
                                        </td>
                                    </tr>
                                    <?php if(is_array($vo['child']) || $vo['child'] instanceof \think\Collection || $vo['child'] instanceof \think\Paginator): $kk = 0; $__LIST__ = $vo['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($kk % 2 );++$kk;?>
                                    <tr>
                                        <td class="center"></td>
                                        <td>--------<?php echo $vv['title']; ?></td>
                                        <td class="wrap">
                                            <div class="wrap" style="max-width: 1000px"><?php echo $vv['content']; ?></div>
                                        </td>
                                        <td>
                                            <select class="state form-control" data-id="<?php echo $vv['id']; ?>">
                                                <?php if(is_array($state) || $state instanceof \think\Collection || $state instanceof \think\Paginator): $i = 0; $__LIST__ = $state;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$so): $mod = ($i % 2 );++$i;?>
                                                <option value="<?php echo $so['value']; ?>" <?php if($vv['is_show'] == $so['value']): ?>selected<?php endif; ?> ><?php echo $so['key']; ?>
                                                </option>
                                                <?php endforeach; endif; else: echo "" ;endif; ?>
                                                </selec>
                                        </td>
                                        <td>
                                            <input class="col-xs-10 sort" value="<?php echo $vv['sort']; ?>" data-id="<?php echo $vv['id']; ?>">
                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-success"
                                               href="<?php echo url('edits',array('id'=>$vv['id'])); ?>">修改</a>
                                            <a class="btn btn-sm btn-danger" href="javascript:void(0);"
                                               onclick="deleteInfo(this,<?php echo $vv['id']; ?>)">删除</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>
                                    </tbody>
                                </table>
                                <div style="width:100%;margin: 0 auto; text-align:center;">
                                    <ul class="pagination">
                                        <?php echo $info['page']; ?>
                                    </ul>
                                </div>
                            </div>
                            <!-- /.span -->
                        </div>
                        <!-- /.row -->
                        <!-- PAGE CONTENT ENDS -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.page-content -->
        </div>
    </div>
    <!-- /.main-content -->
    <div class="footer">
        <div class="footer-inner">
            <!-- #section:basics/footer -->
            <div class="footer-content"><span class="bigger-120"> <span
                    class="blue bolder"><?php echo config('WEB_SITE_NAME'); ?> </span><?php echo WEB_VERSION; ?>版 </span></div>
            <!-- /section:basics/footer -->
        </div>
    </div>
    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse"><i
            class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i></a></div>
<!-- /.main-container -->
<!-- basic scripts -->
<script type="text/javascript">if($(window).width()<1024)  $("#sidebar").addClass('menu-min');</script>
<script src="/static/ace/js/bootstrap.js"></script>
<script src="/static/ace/js/ace/ace.js"></script> 
<script src="/static/ace/js/ace/ace.sidebar.js"></script> 
<script src="/static/ace/js/layer/layer.js"></script>
<script type="text/javascript">
    $('a[href="/Admin/NoticeTypes/index.html"]').parents().filter('li').addClass('open active');
</script>
<script type="text/javascript">
    jQuery(function ($) {
        //清除查询条件
        $(document).on('click', 'button:reset', function () {
            location.href = '<?php echo url('index'); ?>';
        });
        //更改状态
        $('.state').change(function () {
            var state = $(this).val();
            var id = $(this).attr('data-id');
            $.post("<?php echo url('edits'); ?>", {id: id, status: state}).success(function (data) {
                layer.msg(data.info, {icon: data.is_show, time: 1500}, function () {
                    location.href = self.location.href;
                });
            })
        });
        //排序
        $('.table input.sort').change(function () {
            $.post("<?php echo url('edit_rule'); ?>", {id: $(this).attr('data-id'), sort: $(this).val()}).success(function (data) {
                layer.msg(data.info, {icon: data.status, time: 1500}, function () {
                    location.href = self.location.href;
                });
            })
        });
    });

    //删除导航
    function deleteInfo(obj, id) {
        layer.confirm('确定要删除吗？<br>所有的信息都将被完全删除，不可恢复！', {
                btn: ['确定', '关闭'] //按钮
            }, function () {
                $.post("<?php echo url('delete'); ?>", {id: id}).success(function (data) {
                    if (data.code == 0) {
                        layer.msg(data.msg, {icon: data.code, time: 1500}, function () {
                            location.href = self.location.href;
                        });
                    } else {
                        layer.msg(data.info, {icon: data.status, time: 1500}, function () {
                            location.href = self.location.href;
                        });
                    }
                })
            }
        );
    }
</script>
</body>
</html>