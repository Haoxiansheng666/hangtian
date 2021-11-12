<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:65:"D:\11\anji\public/../application/index\view\index\notice_log.html";i:1588209332;s:52:"D:\11\anji\application\index\view\public\header.html";i:1588069630;s:49:"D:\11\anji\application\index\view\public\top.html";i:1588122557;s:52:"D:\11\anji\application\index\view\public\footer.html";i:1588147706;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <title>资讯详情</title>
        <meta charset="utf-8">
    <script src="/web/js/jquery.js"></script>
    <link rel="stylesheet" href="/web/css/common.css">
    <link rel="stylesheet" href="/web/css/header.css">
    <link rel="stylesheet" href="/web/css/footer.css">
    <meta name="Description"  content=""/>
    <meta name="Keywords" content=""/>

    <link rel="stylesheet" href="/web/css/media.css">
	
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

<div id="mediaCenter" class="info">
    <!-- 文章详情轮播 -->
    <div class="my_banner">
        <div class="left">
            <h2>河南安济管理有限公司</h2> <br>
            <p>但愿世间人无病,宁可架上药生尘,一家生物科技有限公司</p>
        </div>
        <div class="right">
            <img src="/web/img/banner.png" alt="">
        </div>
    </div>
    <div class="content">
        <div class="left" style="width: 60%;">
            <h3 style="font-size: 40px;"><?php echo $list['type']; ?></h3>
            <p>
                <a href="<?php echo url('Index/index/index'); ?>">首页</a>>
                <a href="<?php echo url('Index/index/notice'); ?>">新闻中心</a>>
                <span class="danColor"><?php echo $list['type']; ?></span>
            </p>
            <div style="text-align: center;">
                <h3><?php echo $list['title']; ?></h3>
                <p>来源：<?php echo $list['source']; ?>|浏览量：<?php echo $list['reading']; ?>|发布时间|<?php echo $list['time']; ?></p>
            </div>
            <span>
                <?php echo $list['content']; ?>
            </span>
        </div>
        <div class="right" style="width: 40%;">
            <br>
            <div class="top">
                <h1>医疗咨询早知道</h1>
                <p style="margin: 40px 0;">最新、最热医疗咨询一手掌握</p>
                <img src="<?php echo $data['up']['link']; ?>" alt="">
            </div>
            <div class="bottom">
                <h1 style="padding: 20px 0;">
                    为您推荐
                </h1>
                <ul>
                    <?php if(is_array($new_read) || $new_read instanceof \think\Collection || $new_read instanceof \think\Paginator): $i = 0; $__LIST__ = $new_read;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                    <a href="<?php echo url('Index/index/notice_log'); ?>?id=<?php echo $v['id']; ?>">
                        <li>
                            <div style="width: 30%;">
                                <img style="width: 100%;" src="<?php echo $v['link']; ?>" alt="">
                            </div>
                            <div class="text danColor">
                                <p><?php echo $v['title']; ?></p>
                                <p><?php echo $v['time']; ?></p>
                            </div>
                        </li>
                    </a>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
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
    <div class="last danColor" >

    </div>
</footer>


</body>
<script>
    $('#mediaCenter .content .left .tab li').on('click', function () {
        $(this).addClass('active').siblings().removeClass('active');
    })
</script>
</html>
