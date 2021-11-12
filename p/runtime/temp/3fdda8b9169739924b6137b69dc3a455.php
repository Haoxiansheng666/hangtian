<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:70:"D:\11\guanWang2\public/../application/index\view\index\notice_log.html";i:1597991988;s:57:"D:\11\guanWang2\application\index\view\public\header.html";i:1597901922;s:54:"D:\11\guanWang2\application\index\view\public\top.html";i:1597989269;s:57:"D:\11\guanWang2\application\index\view\public\footer.html";i:1597977617;}*/ ?>
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



    <title>新闻详情</title>
    <link rel="stylesheet" href="/web/css/newInfo.css">
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
                    <h3><?php echo $list['title']; ?></h3>
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
            console.log(baseUrl)
            var len = baseUrl.length - 5
            console.log(len)
            var id = baseUrl.slice(27,len)
            console.log(id)
            var p = $('#a'+id)
            p.addClass('text-color')
           
    })
</script>
</html>
