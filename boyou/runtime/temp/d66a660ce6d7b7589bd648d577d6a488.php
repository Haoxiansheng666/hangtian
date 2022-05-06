<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:76:"D:\phpstudy_pro\WWW\boyou\public/../application/admin\view\company\base.html";i:1647859127;s:68:"D:\phpstudy_pro\WWW\boyou\application\admin\view\layout\default.html";i:1642752126;s:65:"D:\phpstudy_pro\WWW\boyou\application\admin\view\common\meta.html";i:1642752126;s:67:"D:\phpstudy_pro\WWW\boyou\application\admin\view\common\script.html";i:1642752126;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">
<meta name="referrer" content="never">
<meta name="robots" content="noindex, nofollow">

<link rel="shortcut icon" href="/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<?php if(\think\Config::get('fastadmin.adminskin')): ?>
<link href="/assets/css/skins/<?php echo \think\Config::get('fastadmin.adminskin'); ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">
<?php endif; ?>

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/assets/js/html5shiv.js"></script>
  <script src="/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>

    </head>

    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if(!IS_DIALOG && !\think\Config::get('fastadmin.multiplenav') && \think\Config::get('fastadmin.breadcrumb')): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <?php if($auth->check('dashboard')): ?>
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                    <?php endif; ?>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                <style>
    .focus:focus{
        border-color: #4397fd;
        box-shadow: none;
    }
</style>
<form id="edit-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('个人信息'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div>
                联系人员: <input style="border: 1px solid #ccc" class="focus" readonly type="text" value="<?php echo htmlentities($row['contact']); ?>">
                联系电话: <input style="border: 1px solid #ccc" class="focus" readonly type="text" value="<?php echo htmlentities($row['mobile']); ?>">
            </div>
           <div>
               身份证号: <input style="border: 1px solid #ccc" class="focus" readonly type="text" value="<?php echo htmlentities($row['ident']); ?>">
               注册时间: <input style="border: 1px solid #ccc" class="focus" readonly type="text" value="<?php echo datetime($row['create_time']); ?>">
           </div>
           <div>
               用户头像  <img width="12%" src="<?php echo $row['user']['avatar'] ? $row['user']['avatar'] : request()->domain().'/assets/img/avatar.png'; ?>">
           </div>
        </div>

    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('基本信息'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div>
                企业名称: <input style="border: 1px solid #ccc" class="focus" readonly name="row[company]" type="text" value="<?php echo htmlentities($row['company']); ?>">
                证件类型: <input style="border: 1px solid #ccc" class="focus" readonly name="row[cert_type]" type="text" value="<?php echo htmlentities($row['cert_type']); ?>">
            </div>
           <div>
               证件号码: <input style="border: 1px solid #ccc" class="focus" readonly name="row[code]" type="text" value="<?php echo htmlentities($row['code']); ?>">
               经营地址: <input style="border: 1px solid #ccc" class="focus" readonly name="row[address]" type="text" value="<?php echo $row['address']; ?><?php echo $row['house']; ?>">
           </div>
           <div>
               经营状态: <input style="border: 1px solid #ccc" class="focus" readonly name="row[open]" type="text" value="<?php echo $row['open'] == 1 ? '营业' : '停业'; ?>">
               企业logo  <img width="12%" src="<?php echo $row['logo'] ? $row['logo'] : request()->domain().'/assets/img/avatar.png'; ?>">
           </div>

        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('餐饮信息'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <div>
                餐饮类型: <input style="border: 1px solid #ccc" class="focus" readonly type="text" value="<?php echo htmlentities($row['detail']['type_text']); ?>">
                联系人员: <input style="border: 1px solid #ccc" class="focus" readonly type="text" value="<?php echo htmlentities($row['contact']); ?>">
            </div>
           <div>
               经营地址: <input style="border: 1px solid #ccc" class="focus" readonly type="text" value="<?php echo htmlentities($row['address']); ?>">
               场所面积: <input style="border: 1px solid #ccc" class="focus" readonly type="text" value="<?php echo htmlentities($row['detail']['area']); ?>">
           </div>
            <div>
                就餐位数: <input style="border: 1px solid #ccc" class="focus" readonly type="text" value="<?php echo htmlentities($row['detail']['number']); ?>">
                排口数量: <input style="border: 1px solid #ccc" class="focus" readonly type="text" value="<?php echo htmlentities($row['detail']['count']); ?>">
            </div>
           <div>
               发热功率: <input style="border: 1px solid #ccc" readonly type="text" value="<?php echo htmlentities($row['detail']['power']); ?>">
           </div>
        </div>
    </div>
</form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>
