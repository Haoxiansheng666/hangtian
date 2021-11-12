<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:60:"D:\11\anji\public/../application/index\view\index\about.html";i:1588737230;s:52:"D:\11\anji\application\index\view\public\header.html";i:1588069630;s:49:"D:\11\anji\application\index\view\public\top.html";i:1588122557;s:52:"D:\11\anji\application\index\view\public\footer.html";i:1588147706;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <title>关于我们</title>
        <meta charset="utf-8">
    <script src="/web/js/jquery.js"></script>
    <link rel="stylesheet" href="/web/css/common.css">
    <link rel="stylesheet" href="/web/css/header.css">
    <link rel="stylesheet" href="/web/css/footer.css">
    <meta name="Description"  content=""/>
    <meta name="Keywords" content=""/>

    <link rel="stylesheet" href="/web/css/about.css">
    <script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&key=OB4BZ-D4W3U-B7VVO-4PJWW-6TKDJ-WPB77"></script>
	<script type="text/javascript" src="/web/layer/2.4/layer.js"></script>
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

<div id="about">
    <!-- 关于我们banner -->
    <div class="my_banner">
        <div class="left">
            <h2>河南安济管理有限公司</h2> <br>
            <p>但愿世间人无病,宁可架上药生尘,一家生物科技有限公司</p>
        </div>
        <div class="right">
            <img src="/web/img/banner.png" alt="">
        </div>
    </div>
    <!-- tab切换  -->
    <div class="tab">
        <ul>
            <li class="active">创始人简介</li>
            <li>公司介绍</li>
            <li>企业文化</li>
            <li>联系我们</li>
        </ul>
    </div>
    <!-- 切换项目 -->
    <div class="tabItem">
        <!-- 创始人简介 -->
        <div>
            <div class="tabItem1">
                <div style="text-align: center;">
                    <div class="top">
                        <img style="width: 83%;" src="/web/img/about/brief1.png" alt="">
                    </div>
                    <div class="text">
                        <img style="" src="/web/img/about/brief2.png" alt="">
                        <div style="text-align: left;margin-left: 20px;">
                            <h3>王宝华</h3>
                            <p><?php echo $founder['jj']; ?></p>
                        </div>
                    </div>
                    <div class="textBottom">
                        <h3><?php echo $founder['content']; ?></h3>
                    </div>
                </div>
            </div>
            <!-- 公司介绍 -->
            <div class="tabItem2">
                <div class="titleText">
                    <h2>公司介绍</h2>
                    <div class="line"></div>
                </div>
                <div class="copy_desc">
                    <div class="first">
                        <img src="/web/img/about/banner.png" alt="">
                    </div>
                    <div class="last">
                        <p class="danColor"><?php echo $company['content']; ?></p>
                    </div>
                </div>
                <div class="bgColor">
                    <div class="titleText">
                        <h2>团队介绍</h2>
                        <div class="line"></div>
                    </div>
                    <div class="imgList" style="text-align: center;">
                        <?php if(is_array($team) || $team instanceof \think\Collection || $team instanceof \think\Paginator): $i = 0; $__LIST__ = $team;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                        <img style="width: 384px;height: 227px;border-radius: 4px;" src="<?php echo $v['link']; ?>" alt="">
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <div>
                    <div class="titleText">
                        <h2>许可资质</h2>
                        <div class="line"></div>
                    </div>
                    <div class="aptList" style="text-align: center;margin-bottom: 10px;">
                        <?php if(is_array($picture) || $picture instanceof \think\Collection || $picture instanceof \think\Paginator): $i = 0; $__LIST__ = $picture;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                        <img style="width: 355px;height: 462px;margin-right: 60px;border-radius: 4px;" src="<?php echo $v['link']; ?>"
                             alt="">
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </div>
                <div class="bgColor" style="padding-bottom: 100px;">
                    <div class="titleText">
                        <h2>公司历程</h2>
                        <div class="line"></div>
                    </div>
                    <div style="text-align: center;padding-top: 40px;">
                        <img src="/web/img/about/time.png" alt="">
                    </div>
                    <ul class="timeShift" style="width: 40%;margin: 0 auto;">
                        <?php if(is_array($course) || $course instanceof \think\Collection || $course instanceof \think\Paginator): $i = 0; $__LIST__ = $course;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                        <div>
                            <?php if($v['type'] == 1): ?>
                            <li class="left">
                                <div style="position: absolute;bottom: 0;">
                                    <span class="color"><?php echo $v['name']; ?></span> <span
                                        style="margin-left: 10px;"><?php echo $v['title']; ?></span>
                                </div>
                                <p>
                                </p>
                            </li>
                            <?php else: ?>
                            <li class="right">
                                <div style="position: absolute;bottom: 0;right:0;">
                                    <span class="color"><?php echo $v['name']; ?></span> <span
                                        style="margin-left: 10px;"><?php echo $v['title']; ?></span>
                                </div>
                                <p>

                                </p>
                            </li>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
            </div>
            <!-- 企业文化 -->
            <div class="tabItem3" style="background-color: rgb(248,249,253);">
                <div class="titleText">
                    <h2>企业文化</h2>
                    <div class="line"></div>
                </div>
                <div class="content">
                    <div>
                        <img style="width: 365px;height: 312px;" src="<?php echo $up['link']; ?>" alt="">
                    </div>
                    <div style="padding-top: 80px;margin:50px;">
                        <?php echo $up['content']; ?>
                    </div>
                </div>
                <div class="content">
                    <div style="padding-top: 80px;">
                        <?php echo $dow['content']; ?>
                    </div>
                    <div style="margin: 50px;">
                        <img style="width: 365px;height: 312px;" src="<?php echo $dow['link']; ?>" alt="">
                    </div>
                </div>
            </div>
            <!-- 联系我们 -->
            <div class="tabItem4">
                <div class="titleText">
                    <h2>联系我们</h2>
                    <div class="line"></div>
                </div>
                <div class="lianxi">
                    <div style="display: flex;">
                        <div>
                            <img style="width: 58px;height: 58px" src="/web/img/about/phone.png" alt="">
                        </div>
                        <div style="margin-left: 10px;">
                            <h3>联系电话</h3>
                            <p style="margin: 10px 0;"><?php echo $data['tel']['value']; ?></p>
                            <p>工作时间：<?php echo $data['work_time']['value']; ?></p>
                        </div>
                    </div>
                    <div style="display: flex;">
                        <div>
                            <img style="width: 58px;height: 58px" src="/web/img/about/address.png" alt="">
                        </div>
                        <div style="margin-left: 10px;">
                            <h3>公司地址</h3>
                            <p style="margin: 10px 0;">邮编：<?php echo $data['email_id']['value']; ?></p>
                            <p><?php echo $data['address']['value']; ?></p>
                        </div>
                    </div>
                </div>
                <div id="container" style="width: 100%;height: 300px;"></div>

                <div class="bgColor">
                    <div class="titleText">
                        <h2>合作咨询</h2>
                        <div class="line"></div>
                    </div>
                </div>
                <div class="form bgColor">

                    <div class="top">
                        <div style="width: 50%;margin-right: 80px;">
                            <input id="name" type="text" placeholder="姓名"> <br>
                            <input id="company" type="text" placeholder="公司"> <br>
                            <input id="phone" type="text" placeholder="电话"> <br>
                            <input id="email" type="text" placeholder="邮箱"> <br>
                        </div>
                        <div style="width: 50%;">
                            <textarea id="content" type="text" rows="3" placeholder="请填写您咨询的内容"></textarea>
                        </div>
                        <div id="marsk" style="z-index: 1;position: fixed;top:0;bottom:0;right: 0;left: 0;background: rgb(0,0,0,.5);display: none;">
							<div style="text-align: center;position: fixed;top: 50%;left: 50%;margin-left: -300px;margin-top: -300px;width: 600px;height: 600px;background-color: #fff;">
								
									<img src="<?php echo url('/admin/Publics/self_verify'); ?>" class="verifyimg reloadverify" onClick="this.src = '/admin/Publics/self_verify?d=' + Math.random();"/>
								
								
							</div>
                            
                        </div>
                    </div>
                    <div class="bottom">
                        <div class="sColor" style="line-height: 40px;">
                            或者您发送咨询邮件至8965427299@qq.com
                        </div>
                        <div class="btn" onclick="ti()">
                            确定
                        </div>
                    </div>
                </div>

            </div>
        </div>

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

    </div>
</footer>

</body>

<script>
	
	
    function ti() {
            var name = $("#name").val(); //名字
            var company = $("#company").val(); //公司
            var phone = $("#phone").val(); //手机
            var email = $("#email").val(); //邮箱
            var content = $("#content").val(); //邮箱
		 layer.open({
			 type: 2,
			 title: '验证码',
			 shadeClose: true,
			 shade: false,
			 maxmin: true, //开启最大化最小化按钮
			 area: ['364px', '417px'],
			 content: "yzm/?name=" + name+"&company="+company+"&phone="+phone+"&email="+email+"&content="+content
		 });
    }
</script>
<script>
    setInterval(
        function () {
            var a = sessionStorage.getItem('ok')
            console.log(a)
            if(a=='11'){
                setTimeout(function () {
                    layer.closeAll()
                    sessionStorage.removeItem('ok')
                },2000)
            }

    },1000
    )
    //地图初始化函数，本例取名为init，开发者可根据实际情况定义
    function initMap() {

        var center = new qq.maps.LatLng(34.745280, 113.776946);
        var map = new qq.maps.Map(document.getElementById('container'), {
            center: center,
            zoom: 16
        });

        var anchor = new qq.maps.Point(10, 30);
        var size = new qq.maps.Size(32, 30);
        var origin = new qq.maps.Point(0, 0);
        var icon = new qq.maps.MarkerImage('https://3gimg.qq.com/lightmap/api_v2/2/4/99/theme/default/imgs/marker.png', size, origin, anchor);
        size = new qq.maps.Size(52, 30);
        var originShadow = new qq.maps.Point(32, 0);
        var shadow = new qq.maps.MarkerImage(
            'https://3gimg.qq.com/lightmap/api_v2/2/4/99/theme/default/imgs/marker.png',
            size,
            originShadow,
            anchor
        );

        var marker = new qq.maps.Marker({
            icon: icon,
            shadow: shadow,
            map: map,
            position: center,
            animation: qq.maps.MarkerAnimation.BOUNCE
        });

        var jump = function (event) {
            marker.setPosition(event.latLng);
        };

        var str = `
               地址<br>
               河南省郑州市郑东新区中兴路商都路建正东方中心B座1313室`

        var infoWin = new qq.maps.InfoWindow({
            map: map
        });
        infoWin.open();
        infoWin.setContent(str);
        infoWin.setPosition(map.getCenter());
        var flag = true;
    }
</script>
<script>
    // tab切换
    var a = 1
    $('#about .tab li').on('click', function () {
        console.log()
        $(this).addClass('active').siblings().removeClass('active');
        var text = $(this)[0].innerText
        if (text == '创始人简介') {
            $(".tabItem1").show()
            $(".tabItem2").hide()
            $(".tabItem3").hide()
            $(".tabItem4").hide()
        }
        if (text == '公司介绍') {
            $(".tabItem1").hide()
            $(".tabItem2").show()
            $(".tabItem3").hide()
            $(".tabItem4").hide()
        }
        if (text == '企业文化') {
            $(".tabItem1").hide()
            $(".tabItem2").hide()
            $(".tabItem3").show()
            $(".tabItem4").hide()
        }
        if (text == '联系我们') {
            $(".tabItem1").hide()
            $(".tabItem2").hide()
            $(".tabItem3").hide()
            $(".tabItem4").show()
            if (a == 1) {
                initMap()
                a++
            }
        }

    })
</script>
</html>
