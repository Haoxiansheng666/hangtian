<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:73:"D:\PHPTutorial\WWW\anji\public/../application/index\view\index\index.html";i:1606463102;s:65:"D:\PHPTutorial\WWW\anji\application\index\view\public\header.html";i:1602558760;s:62:"D:\PHPTutorial\WWW\anji\application\index\view\public\top.html";i:1607397318;s:65:"D:\PHPTutorial\WWW\anji\application\index\view\public\footer.html";i:1607396140;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/web/css/common.css">
<link rel="stylesheet" href="/web/css/header.css">

<meta name="KeyWords" content="<?php echo isset($data['keyword']['value'])?$data['keyword']['value']:''; ?>">
<meta name="description" content="<?php echo isset($data['description']['value'])?$data['description']['value']:''; ?>">
<script src="/web/js/jquery.js"></script>
<script>
(function(){
var src = "https://jspassport.ssl.qhimg.com/11.0.1.js?d182b3f28525f2db83acfaaf6e696dba";
document.write('<script src="' + src + '" id="sozz"><\/script>');
})();
</script>
<style>
    footer {
        background: rgba(12, 46, 73, 1);
        color: #fff;
        padding: 10px;
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
    <link rel="stylesheet" href="/web/css/index.css">
    <title>首页-河南安济医院管理有限公司，致力于为中小型医疗机构提供集采，转诊，耗材采购服务</title>
    <style>
        .serviceBtn{
            height: 160px;
        }
    </style>
</head>
<style type="text/css">
	 /*#_aihecong_chat_container_body ._aihecong_chat_button_body._aihecong_chat_button_pc._aihecong_chat_button_paved{*/
	 /*	position: fixed !important;*/
	 /*	bottom: 100px !important;*/
	 /*}*/
</style>

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
<!--<div>-->
<!--    <div class="serviceBtn" onclick="toService">-->
<!--        <div>-->
<!--            <img src="/web/img/icon_service.png" alt="">-->
<!--        </div>-->
<!--        <div class="service">-->
<!--            联系客服-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->
<script> 
   (function(d, w, c) { var s = d.createElement('script'); w[c] = w[c] || function() { (w[c].z = w[c].z || []).push(arguments); }; s.async = true; s.src = 'https://pubres.aihecong.com/hecong.js'; if (d.head) d.head.appendChild(s); })(document, window, '_AIHECONG'); _AIHECONG('ini',{ entId : 17331 }); 
  </script>
<script>
 $(function(){ 
        var divs = $('.nav ul li div')
        var imgs = $('.nav ul li img')
        var title = document.title
  for(let i in divs){
   if(divs[i].childNodes){
    if(title.indexOf(divs[i].childNodes[0].data)!=-1){
     divs[i].setAttribute('class','active')
     imgs[i].setAttribute('class','show')
    }
   }
  }
    })
    
    function toService(){
    	 _AIHECONG('showChat')
    }
    
    
    
</script>

<body>
<!-- 轮播 -->
<div class="lunbo swiper-container" style="margin-top: 52px;">
    <div class="swiper-wrapper ">
        <?php if(is_array($banner) || $banner instanceof \think\Collection || $banner instanceof \think\Paginator): $i = 0; $__LIST__ = $banner;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
        <div class="swiper-slide">
            <img src="<?php echo $v['link']; ?>" alt="">
        </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <div class="swiper-pagination"></div>
</div>
<!-- 安济功能区 -->
<div class="function">
    <div class="centerDiv flex">
        <div class="firstBlock">
            <div class="c-color">
                <span class="danColor line"></span>
                <span style="font-size: 26px;">安济功能区</span>
                <span class="danColor line"></span>
            </div>
            <div class="text">
                <span class="danColor" style="position: relative;"><?php echo $gong['content']; ?></span>
                <a href="<?php echo url('Index/index/product'); ?>">
                    <div class="infoBtn">
                        详细介绍
                    </div>
                </a>
            </div>
        </div>
        <div style="width: 76%;" class="functionLunbo swiper-container">
            <div class="swiper-wrapper">
                <?php if(is_array($product) || $product instanceof \think\Collection || $product instanceof \think\Paginator): $i = 0; $__LIST__ = $product;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$product_val): $mod = ($i % 2 );++$i;?>
                <div class="flex_a swiper-slide">
                    <?php if(is_array($product_val) || $product_val instanceof \think\Collection || $product_val instanceof \think\Paginator): $i = 0; $__LIST__ = $product_val;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$pro_val): $mod = ($i % 2 );++$i;?>
                    <div class="itemBlock">
                        <img src="/web/img/home_pic1.png" alt="">
                        <div>
                            <div class="floatNoSelectImg">
                                <div style="padding-top: 10px;">
                                    <div class="select">
                                        <img src="<?php echo $pro_val['e_link']; ?>" alt="">
                                        <div><?php echo $pro_val['name']; ?></div>
                                    </div>
                                </div>
                            </div>
                            <div class="floatSelectImg">
                                <div style="padding-top: 10px;">
                                    <div class="select">
                                        <img src="<?php echo $pro_val['link']; ?>" alt="">
                                        <div><?php echo $pro_val['name']; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>
<!-- 关于我们 -->
<div class="about">
    <div class="centerDiv">
        <br> <br> <br> <br>
        <div class="title">
            —— <span class="c-color">关于我们</span> ——
            <div>ABOUT&nbspUS</div>
        </div>
        <div class="flex">
            <div class="text danColor"><?php echo $about['content']; ?></div>
            <div class="marskImg">
                <img src="<?php echo $about['link']; ?>" alt="">
            </div>
        </div>
    </div>
    <div class="imgBottomBlock">
        <div class="centerDiv">
            <a href="<?php echo url('Index/index/about'); ?>">
                <div class="more">
                    了解更多
                </div>
            </a>
        </div>
    </div>
</div>
<!-- 新闻资讯 -->
<div class="new">
    <div class="newContent">
        <div>
            <div class="title" style="margin: 0 auto;">
                —— <span class="c-color">新闻资讯</span> ——
                <div>NEW&nbspINFORMATION</div>
            </div>
        </div>
        <br><br>
        <div class="newLunbo swiper-container">
            <div class="swiper-wrapper">
                <div class="flex_c swiper-slide">
                    <?php if(is_array($news) || $news instanceof \think\Collection || $news instanceof \think\Paginator): $i = 0; $__LIST__ = $news;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if($vo['type'] == 1): ?>
                    <a href="<?php echo url('Index/index/notice_log',['id'=>$vo['id']]); ?>">
                        <div class="newItem" style="margin:0 10px;">
                            <div class="flex" style="flex-wrap: nowrap;">
                                <div class="date" style="width: 20%;">
                                    <div class="top"><?php echo $vo['m']; ?></div>
                                    <div class="bottom"><?php echo $vo['d']; ?></div>
                                </div>
                                <div class="c-color" style="width: 80%;"><?php echo $vo['title']; ?></div>
                            </div>
                            <div class="text danColor" style="height: 90px"><?php echo $vo['describe']; ?></div>
                            <div class="text c-color">
                                详情 > >
                            </div>
                        </div>
                    </a>
                    <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <div class="flex_c swiper-slide">
                    <?php if(is_array($news) || $news instanceof \think\Collection || $news instanceof \think\Paginator): $i = 0; $__LIST__ = $news;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;if($v['type'] == 2): ?>
                    <a href="<?php echo url('Index/index/notice_log',['id'=>$v['id']]); ?>">
                        <div class="newItem" style="margin:0 10px;">
                            <div class="flex" style="flex-wrap: nowrap;">
                                <div class="date" style="width: 20%;">
                                    <div class="top"><?php echo $v['m']; ?></div>
                                    <div class="bottom"><?php echo $v['d']; ?></div>
                                </div>
                                <div class="c-color" style="width: 80%;"><?php echo $v['title']; ?></div>
                            </div>
                            <div class="text danColor" style="height: 90px"><?php echo $v['describe']; ?></div>
                            <div class="text c-color">
                                详情 > >
                            </div>
                        </div>
                    </a>
                    <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
            <div class="swiper-button-next" style="position: relative;top: -140px;left: 1360px;">
                <img style="position: absolute;" src="/web/img/icon_home_right.png" alt="">
            </div>
            <div class="swiper-button-prev" style="position: relative;top: -165px;left: 15px;">
                <img style="position: absolute;" src="/web/img/icon_home_left.png" alt="">
            </div>
        </div>
        <a href="<?php echo url('Index/index/news'); ?>">
            <div class="danColor more">
                查看更多
            </div>
        </a>
    </div>
</div>
<!-- 创始人简介 -->
<div class="originator" style="height:530px">
    <div class="centerDiv">
        <br><br> <br><br>
        <div class="flex_c" >
            <div style="width:500px">
                <div class="title" style="width: 230px;">
                    —— <span class="c-color">创始人简介</span> ——
                    <div>FOUNDER&nbspPROFILE</div>
                </div>
                <div class="text danColor"><?php echo $founder['content']; ?></div>
                <a href="<?php echo url('Index/index/about'); ?>">
                    <div class="more c-color">
                        了解更多
                    </div>
                </a>

            </div>
            <div class="marskImg" style="position:relative;top:42px;">
                <img src="<?php echo $founder['link']; ?>" alt="">
            </div>
        </div>


    </div>
</div>
<!-- 评价 -->

<div class="comments">
    <div class="bgImg">
        <div class="centerDiv" style="padding-top: 70px;">
            <div class="userComments">
                用户评价
            </div>
            <div style="margin-bottom: 55px;">
                <div class="container">
                    <div id="content" class="content"></div>
                </div>
            </div>
            <div class="address">
                <div class="left">
                    公司地址
                </div>
                <div class="center">
                    <img src="/web/img/icon_home_address.png" alt="">
                    地址：<?php echo $data['address']['value']; ?>
                </div>
                <div class="right">
                    <img src="/web/img/icon_home_phone.png" alt="">
                    电话：<?php echo $data['tel']['value']; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<footer>
    <div class="flex">
        <div style="width: 25%;">
            全国客服热线
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
        <li style="width: 60%;margin: 30px auto;">
            <div style="color: #aaa;">
                @CopyRights 2018-2020 www.hnanji.com All Rights Reserved® 河南安济医院管理有限公司 HeNan AnJi Co. Lid 版权所有
            </div>
            <div style="margin: 15px auto 0">
                <a href="https://www.beian.miit.gov.cn/" target="_blank">
					<span style="color: #aaa;">
						备案号：豫ICP备19022268号-2 |
					</span>
                </a>

                <a target="_blank" href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=41010502004705">
		 			<img src="/web/img/a.png"/>
		 				<span style="color: #aaa;">豫公网安备 41010502004705号</span>
		 		</a>
		 				
		 
                    
            </div>
            <!--<div style="margin: 5px auto">-->
                <!--<a href="https://www.beian.miit.gov.cn/" target="_blank">-->
					<!--<span style="color: #aaa;">-->
						<!--备案号：豫ICP备19022268号-2-->
					<!--</span>-->
                <!--</a>-->
                <!--<a href="###" target="_blank">-->
                     <!--<span style="color: #aaa;">-->
                        <!--粤公安网备4423655205651号-->
                    <!--</span>-->
                <!--</a>-->
            <!--</div>-->
        </li>
    </ul>
</footer>



</body>
<script src="/web/js/swiper.min.js"></script>
<script>
    var mySwiper1 = new Swiper('.lunbo', {
        autoplay: true,//可选选项，自动滑动
        pagination: {
            el: '.swiper-pagination',
        },
    })
    var mySwiper2 = new Swiper('.functionLunbo', {
        autoplay: true,//可选选项，自动滑动
        pagination: {
            el: '.swiper-pagination',
        },
    })
    var mySwiper3 = new Swiper('.newLunbo', {
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    })
</script>
<script>
    function tanmu() {
        class Barrage {
            constructor(id) {
                this.domList = [];
                this.dom = document.querySelector('#' + id);
                if (this.dom.style.position == '' || this.dom.style.position == 'static') {
                    this.dom.style.position = 'relative';
                }
                this.dom.style.overflow = 'hidden';
                let rect = this.dom.getBoundingClientRect();
                this.domWidth = rect.right - rect.left;
                this.domHeight = rect.bottom - rect.top;
            }

            shoot(text) {
                let div = document.createElement('div');
                div.style.position = 'absolute';
                div.style.left = this.domWidth + 'px';
                div.style.top = (this.domHeight - 20) * +Math.random().toFixed(2) + 'px';
                div.style.whiteSpace = 'nowrap';
                // div.style.color = '#' + Math.floor(Math.random() * 0xffffff).toString(16);
                div.style.color = '#fff'
                div.innerText = text;
                this.dom.appendChild(div);

                let roll = (timer) => {
                    let now = +new Date();
                    roll.last = roll.last || now;
                    roll.timer = roll.timer || timer;
                    let left = div.offsetLeft;
                    let rect = div.getBoundingClientRect();
                    if (left < (rect.left - rect.right)) {
                        this.dom.removeChild(div);
                    } else {
                        if (now - roll.last >= roll.timer) {
                            roll.last = now;
                            left -= 3;
                            div.style.left = left + 'px';
                        }
                        requestAnimationFrame(roll);
                    }
                }
                roll(50 * +Math.random().toFixed(2));
            }

        }

        let barage = new Barrage('content');

        function appendList(text) {
            let p = document.createElement('p');
            p.innerText = text;
            // document.querySelector('#content-text').appendChild(p);
        }

        // document.querySelector('#send').onclick = () => {
        //     let text = document.querySelector('#text').value;
        //     barage.shoot(text);

        //     appendList(text);
        // };

        const textList = [
            '加油', '团结', '齐心协力',
            '刻不容缓', '共同努力', '携手共济',
            '奋斗', '弹幕1', '弹幕1',
            '弹幕1', '弹幕1',
        ];
        textList.forEach((s) => {
            barage.shoot(s);
        appendList(s);
    })
    }
    tanmu()
    setInterval(function(){
        var content = $('#content div')
        if(content.length<=3){
            tanmu()
        }
    },1000)
</script>
</html>
