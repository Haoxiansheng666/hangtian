<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:74:"D:\PHPTutorial\WWW\anji\public/../application/index\view\index\notice.html";i:1588752343;s:65:"D:\PHPTutorial\WWW\anji\application\index\view\public\header.html";i:1588069630;s:62:"D:\PHPTutorial\WWW\anji\application\index\view\public\top.html";i:1588122557;s:65:"D:\PHPTutorial\WWW\anji\application\index\view\public\footer.html";i:1588754618;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <title>媒体中心</title>
        <meta charset="utf-8">
    <script src="/web/js/jquery.js"></script>
    <link rel="stylesheet" href="/web/css/common.css">
    <link rel="stylesheet" href="/web/css/header.css">
    <link rel="stylesheet" href="/web/css/footer.css">
    <meta name="Description"  content=""/>
    <meta name="Keywords" content=""/>

    <link rel="stylesheet" href="/web/css/media.css">
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

<div id="mediaCenter">
    <!-- 媒体中心轮播 -->
    <div class="my_banner">
        <div class="left">
            <h2>河南安济管理有限公司</h2> <br>
            <p>但愿世间人无病,宁可架上药生尘,一家生物科技有限公司</p>
        </div>
        <div class="right">
            <img src="/web/img/banner.png" alt="">
        </div>
    </div>
    <div class="content">
        <div class="left" style="width: 60%;">
            <br>
            筛选文章：
            <ul class="tab">
                <?php if(is_array($noticeType) || $noticeType instanceof \think\Collection || $noticeType instanceof \think\Paginator): $i = 0; $__LIST__ = $noticeType;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                <!--                <li class="choice" onclick="type1('<?php echo $v['id']; ?>')"><?php echo $v['name']; ?></li>-->
                <li class="choice"><a style="color:inherit" href="<?php echo url('Index/index/notice',['type'=>$v['id']]); ?>"><?php echo $v['name']; ?></a>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
            <hr>
            <!--            <div id="forloop">-->
            <?php if($p->data): if(is_array($p->data) || $p->data instanceof \think\Collection || $p->data instanceof \think\Paginator): $i = 0; $__LIST__ = $p->data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
            <a href="<?php echo url('Index/index/notice',['id'=>$v['id']]); ?>">
                <div class="article">
                    <div>
                        <img style="width:362px;height:162px" src="<?php echo $v['link']; ?>" alt="">
                    </div>
                    <div class="text">
                        <h3><?php echo $v['title']; ?></h3>
                        <div class="danColor"><?php echo $v['content']; ?></div>
                        <div class="time danColor">
                            <div>
                                <span><?php echo $v['time']; ?></span>
                                <span style="margin-left: 30px;"><?php echo $v['source']; ?></span>
                            </div>

                            <!-- <div>
                                <img width="30px" src="/web/img/media/share.png" alt="">
                            </div> -->
                        </div>
                    </div>
                </div>
            </a>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <div style="text-align: center;color: red">
                <?php echo $p->render; ?>
            </div>
            <?php else: ?>
            <div class="article">
                <div style="width: 100px;margin: 0 auto;">
                    暂无数据......
                </div>
            </div>
            <?php endif; ?>
            <!--            </div>-->
        </div>
        <div class="right" style="width: 40%;">
            <br>
            <div class="top">
                <h1>医疗咨询早知道</h1>
                <p style="margin: 40px 0;">最新、最热医疗咨询一手掌握</p>
                <img src="<?php echo $data['up']['link']; ?>" alt="">
            </div>
            <div class="bottom">
                <h1 style="padding: 20px 0;">
                    热门文章
                </h1>

                <ul>
                    <?php if(is_array($new_read) || $new_read instanceof \think\Collection || $new_read instanceof \think\Paginator): $i = 0; $__LIST__ = $new_read;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
                    <!--                <?php if($v['type'] == 1): ?>-->
                    <!--                <?php else: ?>-->
                    <!--                <?php endif; ?>-->
                    <!--                <div>-->
                    <!--                    <div style="background-image: url(/upload/banner/20200428\2c2ea6f30e363077449ff458ec06d8aa.png);">-->
                    <!--                        <p>-->
                    <!--                            <?php echo $v['title']; ?>-->
                    <!--                        </p>-->
                    <!--                    </div>-->
                    <!--                </div>-->
                    <a href="<?php echo url('Index/index/notice_log',['id'=>$v['id']]); ?>">
                        <li>
                            <div style="width: 30%;">
                                <img style="width: 100%;height: 80px;" src="<?php echo $v['link']; ?>" alt="">
                            </div>
                            <div class="text danColor">
                                <p><?php echo $v['title']; ?></p>
                                <p><?php echo $v['time']; ?></p>
                            </div>
                        </li>
                    </a>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="imgList" style="margin-top: 30px;">
        <?php if(is_array($foot) || $foot instanceof \think\Collection || $foot instanceof \think\Paginator): $i = 0; $__LIST__ = $foot;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
        <div class="item">
            <a href="<?php echo url('Index/index/notice_log',['id'=>$v['id']]); ?>">
                <img style="width: 392px;height: 230px;" src="<?php echo $v['link']; ?>" alt="">
                <h3><?php echo $v['title']; ?></h3>
            </a>
        </div>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <input hidden id="hiddenInput" value="<?php echo $type; ?>">
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
    <div class="last danColor">
        <div style="line-height: 20px;margin: 15px 0">安济医院 版权所有</div>
        <div style="line-height: 20px;">
            <?php if(is_array($footer_up) || $footer_up instanceof \think\Collection || $footer_up instanceof \think\Paginator): $i = 0; $__LIST__ = $footer_up;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
            <span><a href="<?php echo $v['url']; ?>" class="danColor"><?php echo $v['name']; ?></a>  </span> &nbsp;&nbsp;
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <div style="line-height: 20px;">
            <?php if(is_array($footer_down) || $footer_down instanceof \think\Collection || $footer_down instanceof \think\Paginator): $i = 0; $__LIST__ = $footer_down;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>
            <span><a href="<?php echo $v['url']; ?>" class="danColor"><?php echo $v['name']; ?></a>  </span> &nbsp;&nbsp;
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </div>
    </div>
</footer>

</body>
<script>

    $('#mediaCenter .content .left .tab li').on('click', function () {
        $(this).addClass('active').siblings().removeClass('active');
    })
    $(function () {
        var idArray = window.location.search.split("=");
        var type = idArray[1];

        // type = parseInt(type)
        var type = $('#hiddenInput').val()


        var tabs = $('#mediaCenter .content .left .tab li')
        if (type == 1 || !type) {
            tabs[0].className = 'active'
        }
        if (type == 2) {
            tabs[1].className = 'active'
        }
        if (type == 3) {
            tabs[2].className = 'active'
        }
    })

    function type1(id) {
        $.ajax({
            url: "<?php echo url('index/index/notice_list'); ?>",
            data: {id: id},
            type: "post",
            success: function (r) {

                if (r.length != 0) {
                    var html = ''
                    for (var i in r) {
                        html += `<a href="<?php echo url('Index/index/notice_log'); ?>?id=${r[i].id}"><div class="article">
                      <div>
                          <img style="width:362px;height:162px" src="${r[i].link}" alt="">
                      </div>
                      <div class="text">
                          <h3>${r[i].title}</h3>
                          <div class="danColor">
                           ${r[i].content}
                          </div>
                          <div class="time danColor">
                              <div>
                                  <span>${r[i].time}</span>
                              </div>
                          </div>
                      </div>
                  </div>
                         </a>`
                    }
                } else {
                    html = ` <div class="article">
								<div  style="width: 100px;margin: 0 auto;">
									暂无数据......
								</div>
							</div>`
                }
                $('#forloop').html(html)


            }
        });
    }
</script>
</html>
