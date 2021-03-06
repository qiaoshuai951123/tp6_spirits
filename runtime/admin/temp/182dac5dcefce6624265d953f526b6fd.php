<?php /*a:1:{s:61:"/Applications/MAMP/htdocs/tp6/app/admin/view/login/index.html";i:1604155065;}*/ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>后台</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <script src="/static/layui/layui.js"></script>
    <style>
        body{
            background: -webkit-linear-gradient(-90deg,#0087b3, #00b3d9); /* Safari 5.1 - 6.0 */
            background: -o-linear-gradient(-90deg,#0087b3, #00b3d9); /* Opera 11.1 - 12.0 */
            background: -moz-linear-gradient(-90deg,#0087b3, #00b3d9); /* Firefox 3.6 - 15 */
            background: linear-gradient(-90deg,#0087b3,#00b3d9); /* 标准的语法（必须放在最后） */
            min-width: 1200px;
        }
        .layui-layout-admin .layui-logo{
            color:#fff;
            font-size:18px;
            width:320px;
        }

        .yingke_logo{
            width:45px;
            height:45px;
        }
        .yingke_mark{
            padding-left:10px;
            font-style: italic;
            border-left:2px solid rgba(229, 229, 229, 0.41);
        }
        .layui-layout-left{
            left: 320px;
        }

        .layui-layout-admin .layui-header {
            background: -webkit-linear-gradient(-90deg,#0087b3, #00b3d9); /* Safari 5.1 - 6.0 */
            background: -o-linear-gradient(-90deg,#0087b3, #00b3d9); /* Opera 11.1 - 12.0 */
            background: -moz-linear-gradient(-90deg,#0087b3, #00b3d9); /* Firefox 3.6 - 15 */
            background: linear-gradient(-90deg,#0087b3,#00b3d9); /* 标准的语法（必须放在最后） */

            color:#fff;
        }
        .layui-body{
            left:0;
        }
        .login_form{
            width:440px;
            height:350px;
            float:right;
            background-color: rgba(255, 255, 255, 0.3214285714285714);
            border-radius: 16px;
            padding:23px 35px;
            margin-top:70px;
            box-sizing: border-box;
        }
        .banner_login{
            float:left;
        }
        .banner_login img{
            width:480px;
            height:480px;
        }
        .login_container{
            overflow: hidden;
            height:480px;
            margin:auto;
            position: relative;
        }
        .layui-layout-admin .layui-body{
            top:0;bottom: 0;
        }
        .layui-body{
            background: -webkit-linear-gradient(-90deg,#0087b3, #00b3d9); /* Safari 5.1 - 6.0 */
            background: -o-linear-gradient(-90deg,#0087b3, #00b3d9); /* Opera 11.1 - 12.0 */
            background: -moz-linear-gradient(-90deg,#0087b3, #00b3d9); /* Firefox 3.6 - 15 */
            background: linear-gradient(-90deg,#0087b3,#00b3d9); /* 标准的语法（必须放在最后） */
            background-image: url('/static/img/login.png');
            background-size: 100%;
            background-repeat: no-repeat;
            -overflow-x:scroll;
        }
        .form_title{
            color: rgba(0, 0, 0, 1);
            font-size: 20px;
            margin-bottom: 20px
        }
        .login_form .layui-input-inline{
            width:100%;
        }
        .user_login{
            width:100%;
            border-radius: 20px;
            background: rgba(255, 195, 0, 1);
            color:rgba(10, 95, 89, 1);
        }
    </style>
</head>
<body class="layui-layout-body" style="background-image: url('/static/img/login.png') center center no-repeat;">
<div class="layui-layout layui-layout-admin">
    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div class='login_container' style="padding: 15px;width:1200px;margin:70px auto;">
            <div class='login_form'>
                <div class="layui-form">
                    <div class='form_title'>登录</div>
                    <div class="layui-form-item">
                        <div class="layui-input-inline">
                            <input type="text" name="user_name" lay-verify="user_name" autocomplete="off" placeholder="请输入账号" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-inline">
                            <input type="password" name="user_pass" lay-verify="user_pass" placeholder="请输入密码" autocomplete="off" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-inline">
                            <input type="text" style="width: calc( 100% - 130px );display: inline-block;float: left;" name="user_code" lay-verify="user_code" placeholder="请输入验证码" autocomplete="off" class="layui-input">
                            <img id="code" src="<?php echo captcha_src(); ?>" onclick="this.src=this.src+'?rand='+Math.random()" alt="captcha" style="display: inline-block;float: right;cursor: pointer;" />
                        </div>
                    </div>
                    <div class='layui-form-item' style='margin-bottom: 20px;'>
                        <!-- <a style='float:right;color:rgba(255, 235, 59, 1)' href="" target="_blank">忘记密码？</a> -->
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-inline">
                            <button class="layui-btn user_login" lay-submit id="userLogin" lay-filter="userLogin">立即登录</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script type="text/javascript">
        layui.use('form', function(){
            var form = layui.form,$ = layui.jquery;
            //表单验证
            form.verify({
                user_name: function (value) {
                    if (value == ''){
                        return '用户名不能为空';
                    }
                },
                user_pass: function (value) {
                    if (value == ''){
                        return '密码不能为空';
                    }
                },
                user_code: function (value) {
                    if (value == ''){
                        return '验证码不能为空';
                    }
                }
            });
            //监听提交
            form.on('submit(userLogin)', function(data){
                $.ajax({
                    type: 'POST',
                    url: "<?php echo url('login/indexLogin'); ?>",
                    data: data.field,
                    dataType: 'json',
                    success: function (data) {
                        if (data.code == 0) {
                            window.location.href = "<?php echo url('index/index'); ?>";
                        } else {
                            $('#code').attr('src',$('#code').attr('src')+'?rand='+Math.random());
                            layer.msg(data.message)
                        }
                    }
                });
            });
        });
    </script>
</div>
</body>
</body>
</html>