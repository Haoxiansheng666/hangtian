<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:65:"D:\11\guanWang2\public/../application/index\view\index\about.html";i:1597989968;s:57:"D:\11\guanWang2\application\index\view\public\header.html";i:1597901922;s:54:"D:\11\guanWang2\application\index\view\public\top.html";i:1597989269;s:57:"D:\11\guanWang2\application\index\view\public\footer.html";i:1597977617;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/web/css/common.css">
<link rel="stylesheet" href="/web/css/header.css">
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
                            <div class=""><?php echo $v['title']; ?></div>
                            <img class="no_show" src="/web/img/jiantou.png" alt="">
                        </a>
                    </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
        <div>
            <div class="search">
                <input type="text" placeholder="请输入关键字">
                <img class="searchImg" src="/web/img/icon_serach.png" alt="">
            </div>
        </div>
    </div>
</header>
<script>
    $(function(){
        
        var divs = $('.nav ul li div')
        var imgs = $('.nav ul li img')
        var title = document.title
       
        if(title=='首页'){
            divs[0].setAttribute('class','active')
            imgs[0].setAttribute('class','show')
        }

        if(title=='关于我们'){
            divs[1].setAttribute('class','active')
            imgs[1].setAttribute('class','show')
        }

        if(title=='新闻资讯' || title=='新闻详情'){
            divs[2].setAttribute('class','active')
            imgs[2].setAttribute('class','show')
        }  
        if(title=='公司资质'){
            divs[3].setAttribute('class','active')
            imgs[3].setAttribute('class','show')
        }
        if(title=='加入我们'){
            divs[4].setAttribute('class','active')
            imgs[4].setAttribute('class','show')
        } 
        if(title=='产品中心'){
            divs[5].setAttribute('class','active')
            imgs[5].setAttribute('class','show')
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
                <div class="text danColor">
                    河南安济医院管理有限公司，成立于2018年。坐落于美丽的郑东新区，毗邻郑州东高铁站。是一家专为中小型民营医院、基层诊所、卫生服务中心等医疗机构提供专业的集采服务、金融服务、医生集团及专家人才培养和医院综合管理咨询为一体的全方位、全链条服务型互联网平台公司。
                    安济旗下的519医家网是针对市场需求倾力打造了药品，耗材及医疗器械的集采服务，金融，转诊和家用医疗器械的销售等功能，完美的实现了平台B2B+2C的运营模式。
                    目前已与省内多家医院合作，提供药品、耗材的集采服务。公司旗下的融资租赁公司也已经与多家医院合作开展业务，提供全方位的金融支持。
                    公司是洛阳市基层医疗协会的会长单位，南阳基层医疗协会副会长单位，59医疗器械网发起人股东，他们为平台的发展提供强有力的支持。
                </div>
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
                    安济公众号
                </div>
                <div class="img" style="margin-left: 40px;">
                    <img src="<?php echo $data['down']['link']; ?>" alt=""> <br>
                    安济公众号
                </div>
            </div>
        </div>
    </div>
    <hr>
    <ul>
        <li>
            <p> @CopyPlight 2017-2018 lylzb.cn inc All Rights 河南安济医药管理有限公司 HeNan AnJi Co. Lid 版权所有</p>
            <p>备案号： 粤ICP备170920153-2 粤公安网备4423655205651号</p>
            <!--<p> <?php echo $footer_up; ?></p>-->
            <!--<p>备案号： <?php echo $footer_down; ?></p>-->
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
