<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:68:"D:\11\guanwang2\public/../application/index\view\index\aptitude.html";i:1598004029;s:57:"D:\11\guanwang2\application\index\view\public\header.html";i:1600930606;s:54:"D:\11\guanwang2\application\index\view\public\top.html";i:1601000580;s:57:"D:\11\guanwang2\application\index\view\public\footer.html";i:1601020640;}*/ ?>
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



        <title>公司资质</title>
        <style>
            .content .imgs1 img{
                margin-bottom: 50px;
                width: 350px;
                height: 258px;
            }
            .content .imgs2>div{
                width:23%;
                padding: 20px 0;
                background:rgba(255,255,255,1);
                border:1px solid rgba(204,204,204,1);
                margin-bottom: 20px;
                text-align: center;
            }
        </style>
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
                <div>COMPANY QUALIFICATION</div>
                <div>—— 公司资质 ——</div>
            </div>
        </div>
    </div>
        <div class="content">
            <div class="centerDiv">
                <div class="title" style="margin: 80px auto;width: 299px;">
					—— <span class="c-color">荣誉与认证</span> ——
					<div>HONORS AND CERTIFICATION</div>
                </div>
                <div class="imgs1 flex_a">
                    <?php if(is_array($problem) || $problem instanceof \think\Collection || $problem instanceof \think\Paginator): $i = 0; $__LIST__ = $problem;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$problem): $mod = ($i % 2 );++$i;?>
                    <img src="<?php echo $problem['link']; ?>" width="350px" height="258px" alt="">
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <div class="title" style="margin: 80px auto;">
					—— <span class="c-color">合作伙伴</span> ——
					<div>PARTNERS</div>
                </div>
                <div class="imgs2 flex_a" style="margin-bottom: 100px;">
                    <?php if(is_array($partner) || $partner instanceof \think\Collection || $partner instanceof \think\Paginator): $i = 0; $__LIST__ = $partner;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$partner): $mod = ($i % 2 );++$i;?>
                    <div>
                        <img width="227px" height="77px" src="<?php echo $partner['link']; ?>" alt="">
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
</html>
