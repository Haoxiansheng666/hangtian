<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:75:"D:\PHPTutorial\WWW\anji\public/../application/index\view\index\service.html";i:1588209716;s:65:"D:\PHPTutorial\WWW\anji\application\index\view\public\header.html";i:1588069630;s:62:"D:\PHPTutorial\WWW\anji\application\index\view\public\top.html";i:1588122557;s:65:"D:\PHPTutorial\WWW\anji\application\index\view\public\footer.html";i:1588754618;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <title>服务支持</title>
        <meta charset="utf-8">
    <script src="/web/js/jquery.js"></script>
    <link rel="stylesheet" href="/web/css/common.css">
    <link rel="stylesheet" href="/web/css/header.css">
    <link rel="stylesheet" href="/web/css/footer.css">
    <meta name="Description"  content=""/>
    <meta name="Keywords" content=""/>

    <link rel="stylesheet" href="/web/css/server.css">
</head>
<body>
<!-- 头部 -->
<header>
    <div>
        <img height="100%" src="/web/img/logo.png" alt="">
    </div>
    <div>
        <ul>
            <?php if(is_array($top) || $top instanceof \think\Collection || $top instanceof \think\Paginator): $i = 0; $__LIST__ = $top;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
            <li ><a class="headerItem" href="<?php echo $server; ?><?php echo $v['url']; ?>"><?php echo $v['title']; ?></a></li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
</header>
<script>
	$(function () { 
		var url = location.href
		var headerItems = $('header .headerItem')
		var i = 0
		if(url.indexOf('about')!=-1) i=1
		if(url.indexOf('problem')!=-1) i=2
		if(url.indexOf('service')!=-1) i=3
		if(url.indexOf('brand')!=-1) i=4
		if(url.indexOf('notice')!=-1) i=5
		headerItems[i].style.color = 'rgb(71,168,249)'
		
	});
	
</script>

<div id="server">
    <!-- 服务支持轮播 -->
    <div class="my_banner">
        <div class="left">
            <h2>河南安济管理有限公司</h2> <br>
            <p>但愿世间人无病,宁可架上药生尘,一家生物科技有限公司</p>
        </div>
        <div class="right">
            <img src="/web/img/banner.png" alt="">
        </div>
    </div>

    <div class="top">
        <div class="titleText" style="margin-top: -50px;">
            <h2>服务支持</h2>
            <div class="line"></div>
        </div>
        <ul>
            <?php if(is_array($problem) || $problem instanceof \think\Collection || $problem instanceof \think\Paginator): $i = 0; $__LIST__ = $problem;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
            <li>
                <img src="<?php echo $v['link']; ?>" alt="">
                <p class="show"><?php echo $v['name']; ?></p>
                <div>
                    <div style="font-size: 20px;"><?php echo $v['name']; ?>2</div>
                    <div><?php echo $v['content']; ?></div>
                </div>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
    <div class="bgColor">
        <div class="bottom">
            <div class="titleText" style="margin-top: -50px;">
                <h2>产品概述</h2>
                <div class="line"></div>
            </div>
            <ul class="tab" style="display: flex;justify-content: space-around;">
                <?php if(is_array($overview) || $overview instanceof \think\Collection || $overview instanceof \think\Paginator): $i = 0; $__LIST__ = $overview;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                <li onclick="cli('<?php echo $v['id']; ?>')"><?php echo $v['name']; ?></li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <div class="box">
                <div>
                    <img src="<?php echo $one['link']; ?>" style="width: 411px;height: 100%;" alt="">
                </div>
                <div>
                    <ul>
                        <li style="list-style: disc;">
                            <h3><?php echo $one['title']; ?></h3>
                            <div><?php echo $one['content']; ?></div>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- 底部 -->
<footer class="footer">
    <ul>
        <div class="first">
            <img style="width: 80px;" src="/web/img/aaa.png" alt="">
        </div>
        <li style="padding: 20px;">
            <h4>联系我们</h4>
            <p class="danColor">公司电话:<?php echo $data['tel']['value']; ?></p>
            <p class="danColor">公司邮箱:<?php echo $data['email']['value']; ?></p>
            <p class="danColor">地址:<?php echo $data['address']['value']; ?></p>
            <p class="danColor">公众号:<?php echo $data['gzh']['value']; ?></p>
        </li>
        <li>
            <h4>产品介绍</h4>
            <?php if(is_array($product) || $product instanceof \think\Collection || $product instanceof \think\Paginator): $i = 0; $__LIST__ = $product;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
            <p class="danColor"><?php echo $v['name']; ?></p>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </li>
        <li>
            <h4>解决方案</h4>
            <?php if(is_array($problem) || $problem instanceof \think\Collection || $problem instanceof \think\Paginator): $i = 0; $__LIST__ = $problem;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
            <p class="danColor"><?php echo $v['name']; ?></p>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </li>
        <li>
            <h4><?php echo $data['up']['name']; ?></h4>
            <img src="<?php echo $data['up']['link']; ?>" alt="">
            <h4 style="margin: 20px 0;"><?php echo $data['down']['name']; ?></h4>
            <img src="<?php echo $data['down']['link']; ?>" alt="">
        </li>
    </ul>
    <div class="last danColor">
        <div style="line-height: 20px;margin: 15px 0">安济医院 版权所有</div>
        <div style="line-height: 20px;">
            <?php if(is_array($footer_up) || $footer_up instanceof \think\Collection || $footer_up instanceof \think\Paginator): $i = 0; $__LIST__ = $footer_up;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
            <span><a href="<?php echo $v['url']; ?>" class="danColor"><?php echo $v['name']; ?></a>  </span> &nbsp;&nbsp;
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <div style="line-height: 20px;">
            <?php if(is_array($footer_down) || $footer_down instanceof \think\Collection || $footer_down instanceof \think\Paginator): $i = 0; $__LIST__ = $footer_down;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
            <span><a href="<?php echo $v['url']; ?>" class="danColor"><?php echo $v['name']; ?></a>  </span> &nbsp;&nbsp;
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
</footer>

</body>
<script>
    $(function () {
        var tabs = $('#server .bottom .tab li')
        console.log(tabs)
        tabs[0].className = 'active'
    })

    function cli(id) {

        $.ajax({
            url: "<?php echo url('index/index/service_list'); ?>",
            data: {id: id},
            type: "post",
            success: function (r) {
                var img = $('#server .bottom .box img')
                var h3 = $('#server .bottom .box h3')
                var p = $('#server .bottom .box p')
                img[0].src = r.link
                h3[0].innerHTML = r.title
                p[0].innerHTML = r.content
            }
        });
    }

    $('#server .bottom .tab li').on('click', function () {
        $(this).addClass('active').siblings().removeClass('active');
    })
</script>
</html>
