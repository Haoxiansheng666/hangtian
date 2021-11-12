<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:65:"D:\11\guanwang2\public/../application/index\view\index\about.html";i:1597999564;s:57:"D:\11\guanwang2\application\index\view\public\header.html";i:1600930606;s:54:"D:\11\guanwang2\application\index\view\public\top.html";i:1601000580;s:57:"D:\11\guanwang2\application\index\view\public\footer.html";i:1601020640;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/web/css/common.css">
<link rel="stylesheet" href="/web/css/header.css">

<meta name="keyword" content="<?php echo isset($data['keyword']['value'])?$data['keyword']['value']:''; ?>">
<meta name="description" content="<?php echo isset($data['description']['value'])?$data['description']['value']:''; ?>">
<script src="/web/js/jquery.js"></script>

<style>
    footer {
        height: 400px;
        background: rgba(12, 46, 73, 1);
        color: #fff;
    }

    footer > div {
        width: 1300px;
        margin: auto;
        padding: 80px 0;
    }

    footer .img {
        text-align: center;
    }

    footer .img > img {
        width: 100px;
        height: 100px;
    }

    footer ul li {
        text-align: center;
        margin-top: 28px;
        font-size: 14px;
    }
</style>



    <link rel="stylesheet" href="/web/css/swiper.min.css">
    <title>关于我们</title>
    <link rel="stylesheet" href="/web/css/about.css">
</head>
<!-- 头部 -->
<header>
    <div class="flex_a nav">
        <div>
            <img class="logoImg" src="/web/img/logo.png" alt="">
        </div>
        <div style="margin-left: 317px;">
            <ul class="flex_a">
                <?php if(is_array($top) || $top instanceof \think\Collection || $top instanceof \think\Paginator): $i = 0; $__LIST__ = $top;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                    <li >
                        <a href="<?php echo $v['url']; ?>">
                            <div class="" style="position: relative;top: 10px;"><?php echo $v['title']; ?></div>
                            <img class="no_show" src="/web/img/jiantou.png" alt="">
                        </a>
                    </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
        <div>
            <div class="search" style="position: relative;top: 15px;">
                <input type="text" placeholder="请输入关键字">
                <img class="searchImg" src="/web/img/icon_serach.png" alt="">
            </div>
        </div>
    </div>
</header>
<!-- 联系客服 -->
<div>
    <div class="serviceBtn">
        <div>
            <img src="/web/img/icon_service.png" alt="">
        </div>
        <div class="service">
            联系客服
        </div>
    </div>
</div>
<script>
    $(function(){
        
        var divs = $('.nav ul li div')
        var imgs = $('.nav ul li img')
        var title = document.title
		for(let i in divs){
			if(divs[i].childNodes){
				if(divs[i].childNodes[0].data==title){
					divs[i].setAttribute('class','active')
					imgs[i].setAttribute('class','show')
				}
			}
		}
    })
</script>

<body>
<!-- banner -->
<div class="banner">
    <div class="flex">
        <div class="center">
            <div>ABOUT US</div>
            <div>—— 关于我们 ——</div>
        </div>
    </div>
</div>
<!-- 公司简介 -->
<div class="biref">
    <div class="centerDiv">
        <div class="flex">
            <div>
                <img src="<?php echo $company['link']; ?>" alt="">
            </div>
            <div>
                <div>
                    <div class="title" style="margin: 0 auto;">
                        —— <span class="c-color">公司简介</span> ——
                        <div>COMPANY PROFILE</div>
                    </div>
                </div>
                <div class="text danColor"><?php echo $company['content']; ?></div>
            </div>
        </div>
    </div>
    <div class="title" style="margin: 0 auto;">
        —— <span class="c-color">公司照片</span> ——
        <div>COMPANY PROFILE</div>
    </div>
</div>
<!-- 公司照片 -->
<div class="pics flex">
    <img src="<?php echo $one['link']; ?>" alt="">
    <div></div>
    <img src="<?php echo $two['link']; ?>" alt="">
    <div></div>
    <div></div>
    <img src="<?php echo $stree['link']; ?>" alt="">
    <div></div>
    <img src="<?php echo $four['link']; ?>" alt="">
</div>
<!-- 发展历程 -->
<div class="develop">
    <div class="title" style="margin: 80px auto;">
        —— <span class="c-color">发展历程</span> ——
        <div>DEVELOPMENT COURSE</div>
    </div>
    <div class="lunbolineTime swiper-container">
        <div class="swiper-wrapper">
            <?php if(is_array($course) || $course instanceof \think\Collection || $course instanceof \think\Paginator): $i = 0; $__LIST__ = $course;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$course_val): $mod = ($i % 2 );++$i;?>
            <div class="swiper-slide">
                <div class="flex_a time_line">
                    <?php if(is_array($course_val) || $course_val instanceof \think\Collection || $course_val instanceof \think\Paginator): $i = 0; $__LIST__ = $course_val;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cour_val): $mod = ($i % 2 );++$i;?>
                    <div><?php echo $cour_val['name']; ?></div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <div class="time_line_img">
                </div>
                <div class="flex_a time_text danColor">
                    <?php if(is_array($course_val) || $course_val instanceof \think\Collection || $course_val instanceof \think\Paginator): $i = 0; $__LIST__ = $course_val;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cour_val): $mod = ($i % 2 );++$i;?>
                    <div>
                        <p><?php echo $cour_val['title']; ?></p>
                    </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
</div>
<!-- 创始人简介 -->
<div class="originator">
    <div>
        <div class="title" style="margin: 80px auto;width: 300px;">
            —— <span class="c-color">创始人简介</span> ——
            <div>FOUNDER PROFILE</div>
        </div>
    </div>
    <div class="centerDiv">
        <div class="flex">
            <div class="left">
                <img style="width: 400px;height:530px;" src="/web/image/aboutImg/about_pic7.png" alt="">
            </div>
            <div class="right">
                <div class="headTitle">
                    王总
                </div>
                <div class="text danColor"><?php echo $founder['content']; ?></div>
            </div>
        </div>
    </div>
</div>
<!-- 团队介绍 -->
<div class="group">
    <div>
        <div class="title" style="margin: 80px auto;">
            —— <span class="c-color">团队介绍</span> ——
            <div>TEAM INTRODUCE</div>
        </div>
    </div>
    <div class="centerDiv">
        <div class="flex_a img_group">
            <?php if(is_array($team) || $team instanceof \think\Collection || $team instanceof \think\Paginator): $i = 0; $__LIST__ = $team;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$team): $mod = ($i % 2 );++$i;?>
            <div>
                <img src="<?php echo $team['link']; ?>" alt="">
                <p><?php echo $team['name']; ?></p>
                <span class="danColor"><?php echo $team['class']; ?></span>
            </div>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
</div>
<footer>
    <div class="flex">
        <div style="width: 25%;">
            全国免费热线
            <div style="margin-top: 20px;">
                <img src="/web/img/icon_footer_phone.png" style="vertical-align: middle;" alt="">
                <span><?php echo $data['tel']['value']; ?></span>
            </div>
        </div>
        <div class="flex" style="width: 50%;">
            <div style="height: 56px;border:2px solid #fff"></div>
            <div style="margin-left: 20px;">
                <p>邮箱：<?php echo $data['email']['value']; ?></p>
                <p style="margin-top: 20px;">地址：<?php echo $data['address']['value']; ?></p>
            </div>
        </div>
        <div style="width: 25%;">
            <div class="flex">
                <div class="img">
                    <img src="<?php echo $data['up']['link']; ?>" alt=""> <br>
                    <?php echo $data['up']['name']; ?>
                </div>
                <div class="img" style="margin-left: 40px;">
                    <img src="<?php echo $data['down']['link']; ?>" alt=""> <br>
                    <?php echo $data['down']['name']; ?>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <ul>
		<li style="width: 30%;margin: 30px auto;">
			<div>
				<a href="https://www.beian.miit.gov.cn/">
					<!-- <span style="color: #AAA;">备案号：豫ICP备19022268号-2</span> -->
					<span style="color: #aaa;">
						 @CopyPlight 2017-2018 lylzb.cn inc All Rights 河南安济医药管理有限公司 HeNan AnJi Co. Lid 版权所有
						备案号：豫ICP备19022268号-2 粤公安网备4423655205651号
					</span>
				</a>
			</div>
		</li>
    </ul>
</footer>


</body>
<script src="/web/js/swiper.min.js"></script>
<script>
    var mySwiper1 = new Swiper('.lunbolineTime', {
        autoplay: true,//可选选项，自动滑动
        pagination: {
            el: '.swiper-pagination',
        },
    })
</script>
</html>
