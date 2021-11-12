<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:80:"/data/wwwroot/anjiWebsite/public/../application/index/view/index/notice_log.html";i:1601174456;s:67:"/data/wwwroot/anjiWebsite/application/index/view/public/header.html";i:1602558760;s:64:"/data/wwwroot/anjiWebsite/application/index/view/public/top.html";i:1607397318;s:67:"/data/wwwroot/anjiWebsite/application/index/view/public/footer.html";i:1609317513;}*/ ?>
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



    <title><?php echo $list['title']; ?>--河南安济医院管理有限公司，致力于为中小型医疗机构提供集采，转诊，耗材采购服务</title>
    <link rel="stylesheet" href="/web/css/newInfo.css">
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
            <div>NEWS</div>
            <div>—— 新闻详情 ——</div>
        </div>
    </div>
</div>
<!-- 详情内容 -->
<div class="content">
    <div class="centerDiv ">
        <div class="flex_b">
            <div class="left">
                <p class="headTitle">栏目列表</p>
                <hr>
                <div class="c-color">——</div>
                <ul class="top">
                    <?php if(is_array($type) || $type instanceof \think\Collection || $type instanceof \think\Paginator): $i = 0; $__LIST__ = $type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                    <!-- <a href="<?php echo url('Index/index/news',['id'=>$vo['type']]); ?>"> -->
                        <li class="flex_b" onclick="toPage1('<?php echo $v['id']; ?>')" style="cursor: pointer;">
                            <div><?php echo $v['name']; ?></div>
                            <div>
                                <img src="/web/image/newImg/icon_news_go.png" alt="">
                            </div>
                        </li>
                        <hr>
                    <!-- </a> -->
                    <?php endforeach; endif; else: echo "" ;endif; ?>

                </ul>
                <div class="bottom">
                    <p class="headTitle">栏目列表</p>
                    <hr>
                    <div class="c-color">——</div>
                    <ul>
                        <?php if(is_array($new_read) || $new_read instanceof \think\Collection || $new_read instanceof \think\Paginator): $i = 0; $__LIST__ = $new_read;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <!-- <a href="<?php echo url('Index/index/notice_log',['id'=>$vo['id']]); ?>"> -->
                            <li  onclick="toPage2('<?php echo $vo['id']; ?>')" style="cursor: pointer;">
                                <p id="a<?php echo $vo['id']; ?>"><?php echo $vo['title']; ?></p>
                                <div class="danColor"><?php echo $vo['time']; ?></div>
                                <hr>
                            </li>
                        <!-- </a> -->
                        <?php endforeach; endif; else: echo "" ;endif; ?>

                    </ul>
                </div>
            </div>
            <div class="right">
                <div class="headTitle">
                    <h1><?php echo $list['title']; ?></h1>
                    <p class="danColor" style="font-size:14px;font-weight:400"><?php echo $list['time']; ?></p>
                </div>
                <div class="text danColor"><?php echo $list['content']; ?></div>
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
<script>
    function toPage1(id){
        var url ='http://'+location.host + '/Index/index/news/type/' + id+'.html'
        location.href = url
    }
    function toPage2(id){
        var url ='http://'+location.host + '/Index/index/notice_log/id/' + id+'.html'
        location.href = url
    }
    $(function(){
        var baseUrl  = location.pathname
            var len = baseUrl.length - 5
            var id = baseUrl.slice(27,len)
            var p = $('#a'+id)
            p.addClass('text-color')
    })
</script>
</html>
