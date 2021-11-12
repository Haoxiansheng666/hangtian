<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:78:"/data/wwwroot/anjiWebsite/public/../application/index/view/index/aptitude.html";i:1605607138;s:67:"/data/wwwroot/anjiWebsite/application/index/view/public/header.html";i:1602558760;s:64:"/data/wwwroot/anjiWebsite/application/index/view/public/top.html";i:1607397318;s:67:"/data/wwwroot/anjiWebsite/application/index/view/public/footer.html";i:1609317513;}*/ ?>
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



        <title>公司资质-河南安济医院管理有限公司，致力于为中小型医疗机构提供集采，转诊，耗材采购服务</title>
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
					<div>HONORS&nbspAND&nbspCERTIFICATION</div>
                </div>
                <div class="imgs1 flex_a">
                    <?php if(is_array($problem) || $problem instanceof \think\Collection || $problem instanceof \think\Paginator): $i = 0; $__LIST__ = $problem;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$problem): $mod = ($i % 2 );++$i;?>
                    <img src="<?php echo $problem['link']; ?>" width="350px" height="258px" alt="">
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <div class="title" style="margin: 80px auto;">
					—— <span class="c-color">合作伙伴</span> ——
					<div>PARTNERS&nbspFRIEND</div>
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
                @CopyRights 2018-2020 www.hnanji.com All Rights Reserved® 河南安济医院管理有限公司 Henan Anji Hospital Management Co., Ltd 版权所有
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
</html>
