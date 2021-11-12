<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:70:"D:\11\guanwang2\public/../application/index\view\index\notice_log.html";i:1600935906;s:54:"D:\11\guanwang2\application\index\view\public\top.html";i:1601000580;s:57:"D:\11\guanwang2\application\index\view\public\footer.html";i:1601020256;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/web/css/common.css">
    <title>新闻资讯</title>
    <link rel="stylesheet" href="/web/css/header.css">
    <script src="/web/js/jquery.js"></script>
    <meta name="keyword" content="<?php echo isset($list['source'])?$list['source']:'1'; ?>">
    <meta name="description" content="<?php echo isset($list['describe'])?$list['describe']:'2'; ?>">
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
                    <p class="danColor"><?php echo $list['time']; ?></p>
                </div>
                <div class="text danColor"><?php echo $list['content']; ?></div>
            </div>
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
			<li>
				<a href="https://www.beian.miit.gov.cn/" style="color: #fff;">
					<span style="color: #AAA;">备案号：豫ICP备19022268号-2</span>
				</a>
				<a href="https://www.beian.miit.gov.cn/" style="color: #fff;">
					<span style="color: #AAA;">备案号：豫ICP备19022268号-2</span>
				</a>
				
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
