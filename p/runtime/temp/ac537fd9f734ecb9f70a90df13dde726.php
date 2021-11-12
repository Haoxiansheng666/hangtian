<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:63:"D:\11\guanwang2\public/../application/index\view\index\add.html";i:1600929667;s:57:"D:\11\guanwang2\application\index\view\public\header.html";i:1600930606;s:54:"D:\11\guanwang2\application\index\view\public\top.html";i:1601000580;s:57:"D:\11\guanwang2\application\index\view\public\footer.html";i:1601020640;}*/ ?>
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



    <script charset="utf-8" src="https://map.qq.com/api/js?v=2.exp&key=GQEBZ-3NFK4-5HWUL-XVOD5-4Y653-CBF5Y"></script>
    <link rel="stylesheet" href="/web/css/add.css">
    <title>加入我们</title>
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
            <div>JOIN US</div>
            <div>—— 加入我们 ——</div>
        </div>
    </div>
</div>
<!-- 信息交流 -->
<div class="exchange">
    <div class="centerDiv">
        <div class="flex_b content">
            <div class="left">
                <h3>问题资讯</h3>
                <div class="danColor text">
                    如果您对产品想要了解更多，留下您的联系方式，我们将安排行业专家为您解答
                </div>
                <div class="input">
                    <input id="name" type="text" placeholder="姓名">
                </div>
                <div class="input">
                    <input id="phone" type="text" placeholder="手机号">
                </div>
                <div class="textarea">
                    <textarea name="" id="content" cols="70" rows="10" placeholder="问题描述"></textarea>
                </div>
                <div class="btn" onclick="tijiao()">
                    提交问题
                </div>
            </div>
            <div class="right">
                <h3>联系我们</h3>
                <div class="danColor text">
                    如果您对产品想要了解更多，留下您的联系方式，我们将安排行业专家为您解答
                </div>
                <div class="img">
                    <img src="/web/image/add/icon_join_service.png" alt="">
                </div>
                <div class="btn1">
                    拨打 0371-61657519
                </div>
                <div class="btn2 c-color">
                    在线咨询
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 二维码 -->
<div class="qr">
    <img src="<?php echo $data['down']['link']; ?>" alt="">
    <h3>河南安济医院管理有限公司</h3>
    <div>
        <img style="width: 15px;height: 20px;" src="/web/image/add/icon_join_address.png" alt="">
        <span class="danColor">地址：郑州市管城区中兴南路商都路交叉口建正东方中心B座1313
                </span>
    </div>
</div>
<!-- 地图 -->
<div id="container" style="width: 100%;height: 300px;"></div>
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
<script type="text/javascript" src="/web/layer/2.4/layer.js"></script>
<script>
    function tijiao() {
        var name = $("#name").val(); //名字
        var phone = $("#phone").val(); //手机
        var content = $("#content").val(); //内容
        $.ajax({
            url: "<?php echo url('index/index/add_info'); ?>",
            data: {name: name, phone: phone, content: content},
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
<script>
    //地图初始化函数，本例取名为init，开发者可根据实际情况定义
    function initMap() {
        var center = new qq.maps.LatLng(34.745280, 113.776946);
        var map = new qq.maps.Map(document.getElementById('container'), {
            center: center,
            zoom: 16
        });
        var marker = new qq.maps.Marker({
            animation:qq.maps.MarkerAnimation.BOUNCE,
            position: center,
            map: map,
        });
        var anchor = new qq.maps.Point(10, 39),
            size = new qq.maps.Size(42, 68),
            origin = new qq.maps.Point(0, 0),
            markerIcon = new qq.maps.MarkerImage(
                "https://3gimg.qq.com/lightmap/api_v2/2/4/99/theme/default/imgs/marker.png",
                size,
                origin,
                anchor
            );
        marker.setIcon(markerIcon);
    }
    initMap()
</script>
</html>
