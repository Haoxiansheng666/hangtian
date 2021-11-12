<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:60:"D:\11\anji\public/../application/index\view\index\index.html";i:1588143527;s:52:"D:\11\anji\application\index\view\public\header.html";i:1588069630;s:49:"D:\11\anji\application\index\view\public\top.html";i:1588122557;s:52:"D:\11\anji\application\index\view\public\footer.html";i:1588748836;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <title>首页</title>
        <meta charset="utf-8">
    <script src="/web/js/jquery.js"></script>
    <link rel="stylesheet" href="/web/css/common.css">
    <link rel="stylesheet" href="/web/css/header.css">
    <link rel="stylesheet" href="/web/css/footer.css">
    <meta name="Description"  content=""/>
    <meta name="Keywords" content=""/>

    <link rel="stylesheet" href="/web/css/swiper.min.css">
    <link rel="stylesheet" href="/web/css/index.css">
    <style>
        .swiper-button-next {
            right: 250px;
        }

        .swiper-button-prev {
            left: 250px;
        }
    </style>
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

<!-- 轮播 -->
<div class="lunbo swiper-container">
    <div class="swiper-wrapper">
        <?php if(is_array($banner) || $banner instanceof \think\Collection || $banner instanceof \think\Paginator): $i = 0; $__LIST__ = $banner;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
        <div class="swiper-slide">
            <div class="left">
                <h2><?php echo $v['title']; ?></h2> <br>
                <p><?php echo $v['content']; ?></p>
            </div>
            <div class="right">
                <img style="width: 600px;height: 337px;" src="<?php echo $v['link']; ?>" alt="">
            </div>
        </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>

    </div>
    <div class="swiper-pagination"></div>
</div>
<!-- 产品介绍 -->
<div class="productDesc">

    <div class="left">
        <img src="/web/img/homePage.png" alt="">
    </div>
    <div class="right">
        <div class="titleText" style="margin-right: 600px;">
            <h2>产品介绍</h2>
            <div class="line"></div>
        </div>
        <div>
            <ul>
                <?php if(is_array($product) || $product instanceof \think\Collection || $product instanceof \think\Paginator): $i = 0; $__LIST__ = $product;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                <li>
                    <h4><?php echo $v['name']; ?></h4>
                    <div>
                        <?php echo $v['content']; ?>
                    </div>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
    </div>
</div>
<!-- 解决方案 -->
<div class="functionBody">
    <div class="titleText">
        <h2>解决方案</h2>
        <div class="line"></div>
    </div>
    <div class="functionItem">
        <div>
            <ul class="bgImg" style="height: 400px;">
                <?php if(is_array($problem) || $problem instanceof \think\Collection || $problem instanceof \think\Paginator): $i = 0; $__LIST__ = $problem;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                <li>
                    <img src="<?php echo $v['link']; ?>" alt="">
                    <p><?php echo $v['name']; ?></p>
                    <div class="isShowText" style="font-size: 13px;">
                        <?php echo $v['content']; ?>
                    </div>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
    </div>
</div>
<!-- 媒体中心 -->
<div class="mediaCenter">
    <div class="titleText">
        <h2>媒体中心</h2>
        <div class="line"></div>
    </div>
    <div class="content">
        <div style="display: flex;flex-wrap: wrap;">
            <?php if(is_array($news) || $news instanceof \think\Collection || $news instanceof \think\Paginator): $i = 0; $__LIST__ = $news;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
            <div style="margin-left: 30px;width: 30%;">
                <?php if($v['type'] == 1): ?>
                <a href="<?php echo url('Index/index/notice_log'); ?>?id=<?php echo $v['id']; ?>">
                    <img style="width: 381px;height: 230px;" src="<?php echo $v['link']; ?>" alt="">
                    <div><?php echo $v['title']; ?></div>
                </a>
                <?php endif; ?>
                <a href="<?php echo url('Index/index/notice_log'); ?>?id=<?php echo $v['id']; ?>">
                    <div style="text-align: left;">
                        <div style="padding: 20px 0 10px 0;"><?php echo $v['title']; ?></div>
                    </div>
                </a>
            </div>

            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
</div>
<!-- 合作伙伴 -->
<div class="hezuo">
    <div class="titleText">
        <h2>合作伙伴</h2>
        <div class="line"></div>
    </div>
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide content">

                <ul style="display: flex;width: 70%;margin: 0 auto;flex-wrap: wrap;;">
                    <?php if(is_array($partner) || $partner instanceof \think\Collection || $partner instanceof \think\Paginator): $i = 0; $__LIST__ = $partner;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                    <li style=""><img style="width: 300px;height: 108px;border-radius: 4px;" src="<?php echo $v['link']; ?>" alt="">
                    </li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>

            </div>
        </div>
        <!-- <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div> -->
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
		<div style="line-height: 20px;">Copyright © 2008-2020 vip.com，All Rights Reserved  使用本网站即表示接受 唯品会用户协议。版权所有 广州唯品会电子商务有限公司</div>
		<div style="line-height: 20px;">
			<span ><a href="" class="danColor">粤公网安备 44010302111111号</a>  </span> &nbsp;&nbsp;
			<span ><a href="" class="danColor">粤ICP备08114786号</a>  </span> &nbsp;&nbsp;
			<span> <a href="" class="danColor">增值业务经营许可证：粤B2-20170777</a> </span> &nbsp;&nbsp;
			<span> <a href="" class="danColor">网络文化经营许可证：粤网文〔2018〕5030-1743号</a> </span>
		</div>
		<div style="line-height: 20px;">
			经营主体证照   风险监测信息   互联网药品信息服务资格证书：（粤）-经营性-2018-0271 网络食品交易第三方平台备案凭证：粤B2-20170777 医疗器械网络交易服务第三方平台备案凭证：（粤）网械平台备字[2019]第00001号
		</div>
    </div>
</footer>

</body>
<script src="js/swiper.min.js"></script>
<script>
    var mySwiper = new Swiper('.lunbo', {
        autoplay: true,//可选选项，自动滑动
        pagination: {
            el: '.swiper-pagination',
        },
    })
    var swiper = new Swiper('.swiper-container', {

        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
</script>
</html>
