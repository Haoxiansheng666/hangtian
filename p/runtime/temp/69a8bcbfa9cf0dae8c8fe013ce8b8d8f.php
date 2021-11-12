<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:65:"D:\11\guanWang2\public/../application/index\view\index\index.html";i:1597977471;s:57:"D:\11\guanWang2\application\index\view\public\header.html";i:1597901922;s:54:"D:\11\guanWang2\application\index\view\public\top.html";i:1597989269;s:57:"D:\11\guanWang2\application\index\view\public\footer.html";i:1597977617;}*/ ?>
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



    <link rel="stylesheet" href="/web/css/swiper.min.css">
    <link rel="stylesheet" href="/web/css/index.css">
    <title>首页</title>

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
                <span class="danColor"><?php echo $gong['content']; ?></span>
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
                                        <img src="<?php echo $pro_val['link']; ?>" alt="">
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
            <div>ABOUTUS</div>
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
                <div>NEW INFORMATION</div>
            </div>
        </div>
        <br><br>
        <div class="newLunbo swiper-container">
            <div class="swiper-wrapper">
                <div class="flex_c swiper-slide">
                    <?php if(is_array($news['one']) || $news['one'] instanceof \think\Collection || $news['one'] instanceof \think\Paginator): $i = 0; $__LIST__ = $news['one'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                    <a href="<?php echo url('Index/index/notice_log',['id'=>$vo['id']]); ?>">
                        <div class="newItem ">
                            <div class="flex">
                                <div class="date">
                                    <div class="top"><?php echo $vo['m']; ?></div>
                                    <div class="bottom"><?php echo $vo['d']; ?></div>
                                </div>
                                <div class="c-color"><?php echo $vo['title']; ?></div>
                            </div>
                            <div class="text danColor"><?php echo $vo['content']; ?></div>
                            <div class="text c-color">
                                详情 > >
                            </div>
                        </div>
                    </a>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
                <div class="flex_c swiper-slide">
                    <?php if(is_array($news['two']) || $news['two'] instanceof \think\Collection || $news['two'] instanceof \think\Paginator): $i = 0; $__LIST__ = $news['two'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                    <a href="<?php echo url('Index/index/notice_log',['id'=>$v['id']]); ?>">
                        <div class="newItem ">
                            <div class="flex">
                                <div class="date">
                                    <div class="top"><?php echo $vo['m']; ?></div>
                                    <div class="bottom"><?php echo $vo['d']; ?></div>
                                </div>
                                <div class="c-color"><?php echo $vo['title']; ?></div>
                            </div>
                            <div class="text danColor"><?php echo $vo['content']; ?></div>
                            <div class="text c-color">
                                详情 > >
                            </div>
                        </div>
                    </a>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
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
<div class="originator">
    <div class="centerDiv">
        <br><br> <br><br>
        <div class="flex" >
            <div>
                <div class="title" style="width: 230px;">
                    —— <span class="c-color">创始人简介</span> ——
                    <div>FOUNDER PROFILE</div>
                </div>
                <div class="text danColor"><?php echo $founder['content']; ?></div>
                <a href="<?php echo url('Index/index/about'); ?>">
                    <div class="more c-color">
                        了解更多
                    </div>
                </a>
                
            </div>
            <div class="marskImg">
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
			'弹幕1', 
			'弹幕1', 
			'弹幕1', 
			'弹幕1', 
			'弹幕1', 
			'弹幕1', 
			'弹幕1', 
			'弹幕1', 
			'弹幕1', 
			'弹幕1',
			'弹幕1'
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
