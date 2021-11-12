<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"D:\PHPTutorial\WWW\anji\public/../application/index\view\index\yzm.html";i:1588736799;}*/ ?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
<head>
    <title>TODO supply a title</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div style="text-align: center;padding-top: 50px">
    <input style="height: 40px" id="verify" placeholder="请输入验证码">
    <img style="position: relative;top: 20px" width="150px" src="<?php echo url('/admin/Publics/self_verify'); ?>"
         class="verifyimg reloadverify"
         onClick="this.src = '/admin/Publics/self_verify?d=' + Math.random();"/>
    <div onclick="tijiao()" style="background: rgb(71,168,249);margin: 10px;padding: 10px;color: #fff">提交</div>
    <input id="name" hidden value="<?php echo $get['name']; ?>">
    <input id="company" hidden value="<?php echo $get['company']; ?>">
    <input id="phone" hidden value="<?php echo $get['phone']; ?>">
    <input id="email" hidden value="<?php echo $get['email']; ?>">
    <input id="content" hidden value="<?php echo $get['content']; ?>">

</div>
</body>
<script src="/web/js/jquery.js"></script>
<script type="text/javascript" src="/web/layer/2.4/layer.js"></script>

<script>
    function tijiao() {
        var verify = $("#verify").val(); //名字
        var name = $("#name").val(); //名字
        var company = $("#company").val(); //公司
        var phone = $("#phone").val(); //手机
        var email = $("#email").val(); //邮箱
        var content = $("#content").val(); //邮箱
        $.ajax({
            url: "<?php echo url('index/index/add_info'); ?>",
            data: {verify: verify, name: name, company: company, phone: phone, email: email, content: content},
            type: "post",
            success: function (r) {
                if (r['code'] == 1) {
                    layer.msg(r['msg']);
                    sessionStorage.setItem('ok','11');
                } else {
                    layer.msg(r['msg']);
                }
            }
        });

    }
</script>
</html>
