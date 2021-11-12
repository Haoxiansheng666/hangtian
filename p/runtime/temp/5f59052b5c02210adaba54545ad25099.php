<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:75:"D:\PHPTutorial\WWW\anji\public/../application/index\view\index\product.html";i:1607411920;s:65:"D:\PHPTutorial\WWW\anji\application\index\view\public\header.html";i:1602558760;s:62:"D:\PHPTutorial\WWW\anji\application\index\view\public\top.html";i:1607397318;s:65:"D:\PHPTutorial\WWW\anji\application\index\view\public\footer.html";i:1607396140;}*/ ?>
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



    <link rel="stylesheet" href="/web/css/product.css">
    <title>产品中心-河南安济医院管理有限公司，致力于为中小型医疗机构提供集采，转诊，耗材采购服务</title>
    <style>
    	.content .web .right{
				width: 734px;background-color: #f5f5f5;padding: 50px;box-sizing: border-box;position: relative;
			}
			.content .web .right>div{
				display: flex;flex-direction: column;justify-content: space-between;
			}
			.content .web .right .btn{
				text-align: center;width: 120px;height: 40px;line-height: 40px;position: absolute;bottom: 50px;border: 1px solid #004A8B;color: #004A8B;
				cursor: pointer;
			}
			.content .web .right .text{
				margin: 30px 0;line-height: 27px;
			}
			.content .web .right .head{
					font-size: 22px;
					font-family: Microsoft YaHei;
					font-weight: bold;
					color: #004A8B;
			}
			.boxs .box1{
				width: 300px;height: 410px;background-color: #f5f5f5;margin-right: 10px;text-align: center;
			}
			.boxs .box2{
				width: 200px;height: 200px;background-color: #f5f5f5;float: left;text-align: center;
			}
			.boxs .box3{
				width: 200px;height: 200px;background-color: #f5f5f5;margin-left: 210px;text-align: center;
			}
			.boxs .box4{
				width: 410px;height: 200px;background-color: #f5f5f5;margin-top: 10px;text-align: center;
			}
			.boxs .box5{
				width: 300px;height: 410px;background-color: #f5f5f5;margin:0 10px;text-align: center;padding-top: 40px;box-sizing: border-box;
			}
			.boxs .box6{
				width: 200px;height: 200px;background-color: #f5f5f5;text-align: center;
			}
			.boxs .box7{
				width: 200px;height: 200px;background-color: #f5f5f5;margin-top: 10px;text-align: center;
			}
			.boxs .text{
				color: #666;margin-top: 10px;
			}
			.boxs .marsk{
				transition: opacity 0.8s;
				background-color: #004A8B;opacity: 0;color: #fff;cursor: pointer;display: flex;justify-content: center;align-items: center;
			}
			.boxs .marsk:hover{
				opacity: 0.9;
			}
			input{
				border: none;
				outline: none;
				font-size: 16px;
				color: #AAA;
				background: #fff;
				
			}
			.inputBox{
				background: #fff;
				height: 50px;
				width: 540px;
				line-height: 50px;
				padding: 0 20px;
				margin-bottom: 30px;
			}
			 .textareaBox{
			    background: #fff;
			    height: 150px;
			    padding:  20px;
			    margin-bottom: 30px;
				
			}
			textarea{
			    border: none;
			    outline: none;
				color: #AAA;
				resize:none;
				font-size: 16px;
			}
			.feedback .btn{
				width: 1180px;
				height: 50px;
				background: #004A8B;
				color: #fff;
				text-align: center;
				line-height: 50px;
				cursor: pointer;
			}
			.feedback{
				margin: 100px 0;background-color: #f5f5f5;height: 622px;padding: 30px;
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
            <div>PRODUCT CENTER</div>
            <div>—— 产品中心 ——</div>
        </div>
    </div>
</div>
<!-- 板块内容 -->
<div class="title" style="margin: 80px auto;width: 230px;">
    —— <span class="c-color">519医家网</span> ——
    <div>FOUNDER&nbspPROFILE</div>
</div>
<div class="content">
            <div style="width: 1240px;margin: 0 auto;">
                <div class="flex web">
					<div>
						<img src="/web/image/statusImg/pic_product.png" alt="">
						
					</div>
					<div class="right">
						<div>
							<div class="head"><?php echo $list['title']; ?></div>
							<div class="text"><?php echo $list['content']; ?></div>
							<a href="http://www.anjiyiliao.com/">
								<div class="btn">
								点击进入
							</div>
							</a>
						</div>
					</div>
				</div>
				<div class="title" style="margin: 80px auto;width: 230px;">
				    —— <span class="c-color">超值精选</span> ——
				    <div>MyriadPro-Regular</div>
				</div>
				<div class="boxs" style="position: relative;">
					<div class="flex">
						<div class="box1" style="padding-top: 40px;box-sizing: border-box;">
							<img src="<?php echo $da['one']['link']; ?>" alt="" style="width: 184px;height: 305px;">
							
							<p class="text"><?php echo $da['one']['name']; ?></p>
						</div>
						<div>
							<div>
								<div class="box2">
									<br>
									<img src="<?php echo $da['two']['link']; ?>" alt="" style="width: 100px;height: 120px;">
									<p class="text"><?php echo $da['two']['name']; ?></p>
								</div>
								<div class="box3">
									<br>
									<img src="<?php echo $da['stree']['link']; ?>" alt="" style="width: 117px;height: 109px;">
									<p class="text"><?php echo $da['stree']['name']; ?></p>
								</div>
								<div class="box4">
									<br>
									<img src="<?php echo $da['four']['link']; ?>" alt="" style="width: 320px;height: 148px;">
									<p class="text" style="position: relative;top: -15px;"><?php echo $da['four']['name']; ?></p>
								</div>
							</div>
						</div>
						<div class="box5">
							<br>
							<img src="<?php echo $da['five']['link']; ?>" alt="" style="width: 167px;height: 280px;">
							<p class="text"><?php echo $da['five']['name']; ?></p>
						</div>
						<div>
							<div class="box6">
								<br>
								<img src="<?php echo $da['six']['link']; ?>" alt="" style="width: 117px;height: 126px;">
								<p class="text"><?php echo $da['six']['name']; ?></p>
							</div>
							<div class="box7">
								<br>
								<img src="<?php echo $da['seven']['link']; ?>" alt="" style="width: 84px;height: 137px;">
								<p class="text"><?php echo $da['seven']['name']; ?></p>
							</div>
						</div>
					</div>
					<div class="flex" style="position: absolute;top: 0;">
						<div class="box1 marsk">
							<div>
								<?php echo $da['one']['name']; ?>
								  <br />
								  ->>
							</div>
						</div>
						<div>
							<div>
								<div class="box2 marsk">
									<div>
										<?php echo $da['two']['name']; ?>
										<br />
										->>
									</div>
								</div>
								<div class="box3 marsk" >
									<div>
										<?php echo $da['stree']['name']; ?>
										<br />
										->>
									</div>
								</div>
								<div class="box4 marsk">
									<div>
										<?php echo $da['four']['name']; ?>
										<br />
										->>
									</div>
								</div>
							</div>
						</div>
						<div class="box5 marsk">
							<div>
								<?php echo $da['five']['name']; ?>
								 <br />
								 ->>
							</div>
						</div>
						<div>
							<div class="box6 marsk">
								<div>
									<?php echo $da['six']['name']; ?>
									 <br />
										->>
								</div>
							</div>
							<div class="box7 marsk">
								<div>
									<?php echo $da['seven']['name']; ?>
									 <br />
										->>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="feedback">
					<h3>问题反馈</h3>
					<p class="danColor" style="margin: 22px 0 39px;">
						如果您想了解更多产品，请在此留言，我们会安排行业专家为您解答
					</p>
					<div style="float:right;margin-right:154px;margin-top:-50px;text-align:center">
						<img id="" src="/web/image/statusImg/kefu.png" alt=""  >
						<br />  <br />
						<p>
							客服热线：0371-61657519
						</p>
					</div>
					
					<div class="inputBox">
					 <span style="color:red">*</span> <span>公司: </span>	<input style="width:300px" id="company" type="text" placeholder="请输入公司名称"/ >
					</div>
					<div class="inputBox">
					  <span style="color:red">*</span> <span>姓名: </span>	<input style="width:300px" id="name" type="text" placeholder="请输入姓名"/>
					</div>
					<div class="inputBox">
					  <span style="color:red">*</span> <span>手机号: </span>	<input style="width:300px;margin-left:12px" id="phone" type="text" placeholder="请输入手机号"/>
					</div>
					<div class="textareaBox">
						<textarea id="content" cols="100" rows="8" placeholder="问题描述"></textarea>
					</div>
					<div class="btn" onclick="tijiao()">
						提交问题
					</div>
				</div>
            </div>
            <br><br>
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


<script type="text/javascript" src="/web/layer/2.4/layer.js"></script>
<script>
    function tijiao() {
        // var name = $("#name").val(); //名字
        var company = $("#company").val(); //公司名称
        var phone = $("#phone").val(); //手机
        var content = $("#content").val(); //内容
        // var verify = $("#verify").val(); //验证码
        var name,verify
        $.ajax({
            url: "<?php echo url('index/index/add_info'); ?>",
            data: {name: name, phone: phone, content: content, company: company, verify: verify},
            type: "post",
            success: function (r) {
                if (r['code'] == 1) {
                    layer.msg(r['msg']);
                    window.location.replace("<?php echo url('index/index/add'); ?>");
                } else {
                    layer.msg(r['msg']);
                }
            }
        });
    }
</script>
</body>
</html>
