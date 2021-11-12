<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:71:"D:\PHPTutorial\WWW\anji\public/../application/index\view\index\add.html";i:1607406782;s:65:"D:\PHPTutorial\WWW\anji\application\index\view\public\header.html";i:1602558760;s:62:"D:\PHPTutorial\WWW\anji\application\index\view\public\top.html";i:1607397318;s:65:"D:\PHPTutorial\WWW\anji\application\index\view\public\footer.html";i:1607396140;}*/ ?>
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



    <script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&key=GQEBZ-3NFK4-5HWUL-XVOD5-4Y653-CBF5Y"></script>
    <link rel="stylesheet" href="/web/css/add.css">
    <title>加入我们-河南安济医院管理有限公司，致力于为中小型医疗机构提供集采，转诊，耗材采购服务</title>
    <style>
    	.navAdd{
				background-color: #004A8B;
				height: 50px;
				line-height: 50px;
				padding: 0 20px;
				color: #fff;
				font-size: 18px;
				font-weight: bold;
			}
			.content{
				background: rgba(245, 245, 245, 0);
				border: 1px solid #CCCCCC;
				padding: 20px;
				line-height: 27px;
				margin-bottom: 50px;
			}
			.msg>div{
				width: 49%;
				background-color: #f5f5f5;
				height:166px;
				padding: 20px;
				box-sizing: border-box;
				line-height: 30px;
			}
			.msg .line{
				width: 16px;
				height: 4px;
				background: #004A8B;
				margin: 10px 0;
			}
			.msg p{
				font-size: 20px;
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
	<div class="banner">
			<div class="flex">
				<div class="center">
                    <div>JOIN US</div>
                    <div>—— 加入我们 ——</div>
                </div>
			</div>
        </div>
		<div class="centerDiv" style="padding: 100px;">
			<div class="title" style="margin: 0 auto;">
				—— <span class="c-color">人才招聘</span> ——
				<div>VALUE SELECTION</div>
			</div>
			<div style="margin-top: 50px;">
				<?php if(is_array($da['list']) || $da['list'] instanceof \think\Collection || $da['list'] instanceof \think\Paginator): $i = 0; $__LIST__ = $da['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$d): $mod = ($i % 2 );++$i;?>
				<div class="navAdd"><?php echo $d['name']; ?></div>
				<div class="content"><?php echo $d['content']; ?></div>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</div>
			<div class="flex_b msg">
				<div class="left flex" >
					<div style="margin: 10px;">
						<img src="/web/image/statusImg/phone.png" alt="">
					</div>
					<div style="margin-left: 20px;">
						<p>招聘联系电话</p>
						<div class="line"></div>
						<div>
							您可以来电咨询我们，联系电话：<span class="c-color"> <?php echo $da['PER_PHONE']['value']; ?> </span>  <br>
							联系人：<?php echo $da['PER_NAME']['value']; ?>
						</div>	
					</div>
				</div>
				<div class="right flex">
					<div style="margin: 10px;">
						<img src="/web/image/statusImg/message.png" alt="">
					</div>
					<div style="margin-left: 20px;">
						<p>简历投递邮箱</p>
						<div class="line"></div>
						<div>
							您可以把信息发送人力资源部邮箱：<span class="c-color">  <?php echo $da['PER_EMAIL']['value']; ?> </span>
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
<script type="text/javascript" src="/web/layer/2.4/layer.js"></script>

</html>
