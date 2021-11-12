<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:60:"D:\11\anji\public/../application/index\view\index\brand.html";i:1588210698;s:52:"D:\11\anji\application\index\view\public\header.html";i:1588069630;s:49:"D:\11\anji\application\index\view\public\top.html";i:1588122557;s:52:"D:\11\anji\application\index\view\public\footer.html";i:1588147706;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <title>解决方案</title>
        <meta charset="utf-8">
    <script src="/web/js/jquery.js"></script>
    <link rel="stylesheet" href="/web/css/common.css">
    <link rel="stylesheet" href="/web/css/header.css">
    <link rel="stylesheet" href="/web/css/footer.css">
    <meta name="Description"  content=""/>
    <meta name="Keywords" content=""/>

    <link rel="stylesheet" href="/web/css/culture.css">
	<link rel="stylesheet" href="/public/web/css/common.css">
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

<div id="culture">
    <!-- 解决方案banner -->
    <div class="my_banner">
        <div class="left">
            <h2>河南安济管理有限公司</h2> <br>
            <p>但愿世间人无病,宁可架上药生尘,一家生物科技有限公司</p>
        </div>
        <div class="right">
            <img src="/web/img/banner.png" alt="">
        </div>
    </div>
    <div class="tab">
        <ul>
            <a href="#produce1" class="active">
                产品理念
            </a>
            <a href="#produce2">
                产品介绍
            </a>

            <a href="#produce3">
                产品优势
            </a>
            <a href="#produce4">
                产品展示
            </a>
        </ul>
    </div>

    <div class="main">
        <!-- 产品理念 -->
        <div id="produce1">
            <h3 class="title">产品理念</h3>
            <ul>
                <?php if(is_array($ldea) || $ldea instanceof \think\Collection || $ldea instanceof \think\Paginator): $i = 0; $__LIST__ = $ldea;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                <li>
                    <div>
                        &nbsp;&nbsp; <img  style="vertical-align: middle;width: 39px;height: 39px;" src="<?php echo $v['link']; ?>" alt="">
                        <b><?php echo $v['title']; ?></b>
                    </div>
                    <div class="text" class="danColor">
                        <?php echo $v['content']; ?> 
                    </div>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
        <!-- 产品介绍 -->
        <div id="produce2">
            <h3 class="title">产品介绍</h3>
            <div style="display: flex;">
                <div style="margin-right: 10px;">
                    <img height="80px" src="/web/img/aaa.png" alt="">
                </div>
                <div style="color: #000;"><?php echo $introduce['content']; ?></div>
            </div>
<!--            <div style="color: #000;">-->
<!--                河南安吉一眼成立于2018年河南安吉一眼成立于2018年河南安吉一眼成立于2018年河南安吉一眼成立于2018年河南安吉一眼成立于2018年河南安吉-->
<!--                一眼成立于2018年河南安吉一眼成立于2018年河南安吉一眼成立于2018年河南安吉一眼成立于2018年河南安吉一眼成立于2018年河南安吉-->
<!--            </div>-->
        </div>
        <!-- 产品优势 -->
        <div id="produce3">
            <h3 class="title">产品优势</h3>
            <ul>
                <li class="outCircle">
                    <div class="innerCircle">
                        <h1>
                            <?php echo $hospital; ?>
                        </h1>
                    </div>
                    <div class="text">
                        基层医疗诊所
                    </div>
                </li>
                <li class="outCircle">
                    <div class="innerCircle">
                        <h1>
                            <?php echo $brand; ?>
                        </h1>
                    </div>
                    <div class="text">
                        医疗品牌
                    </div>
                </li>
                <li class="outCircle">
                    <div class="innerCircle">
                        <h1>
                            <?php echo $exp; ?>
                        </h1>
                    </div>
                    <div class="text">
                        医疗行业经验
                    </div>
                </li>
            </ul>
            <div class="itemList" style="margin: 100px 0;">
                <div>
                    <?php if(is_array($adva) || $adva instanceof \think\Collection || $adva instanceof \think\Paginator): $i = 0; $__LIST__ = $adva;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                    <div class="item">
                        <h5><?php echo $v['title']; ?></h5>
                        <div class="danColor"><?php echo $v['content']; ?></div>
                    </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>

        </div>
        <!-- 产品展示 -->
        <div id="produce4">
            <h3 class="title">产品展示</h3>
        </div>

    </div>
    <div class="show bgColor">
        <div class="main">
            <ul style="display: flex;">
                <li style="padding: 20px;">
                    <img style="width: 674px;height: 439px;" src="<?php echo $show['link']; ?>" alt="">
                </li>
                <li>
                    <h3><?php echo $show['title']; ?></h3>
                    <div class="textList" style="">
                        <?php echo $show['content']; ?>  
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="show">
        <div class="main">
            <ul style="display: flex;justify-content: space-between;">
                <li>
                    <h3><?php echo $live['title']; ?></h3>
                    <div class="textList">
                        <?php echo $live['content']; ?>
                    </div>
                </li>
                <li style="padding: 20px;">
                    <img style="width: 674px;height: 439px;" src="<?php echo $live['link']; ?>" alt="">
                </li>
            </ul>
        </div>
    </div>
    <div style="padding: 40px;" class="bgColor"></div>
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
    $('#culture .tab ul a').on('click',function(){
        $(this).addClass('active').siblings().removeClass('active');
    })
	
	$('#culture .main #produce1 li .text p').addClass('danColor')
</script>
</html>
