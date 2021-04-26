<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>后台登录</title>
    <link rel="stylesheet" href="/static/layui/css/layui.css">
    <script src="/static/js/jquery-3.5.1.min.js"></script>
    <style>
        body {
            background-color: #f2f2f2;
        }
        .layadmin-user-login {
            position: relative;
            left: 0;
            top: 0;
            padding: 110px 0;
            min-height: 100%;
            box-sizing: border-box;
        }
        .layadmin-user-login-main {
            width: 375px;
            margin: 0 auto;
            box-sizing: border-box;
        }
        .layadmin-user-login-header {
            text-align: center;
            padding: 20px 20px;
            padding-left: 100px;
        }
        .layadmin-user-login-header h2 {
            margin-bottom: 10px;
            font-weight: 300;
            font-size: 30px;
            color: #000;
        }
        .layadmin-user-login-header p {
            font-weight: 300;
            color: #999;
        }
        .layui-form-label {
            width:20%;
        }
        .layui-col-xs6 {
            width: 70%;
        }
        #canvas {
            float: left;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 15px;
        }

    </style>
</head>
<body>
<div class="layadmin-user-login">
    <div class="layadmin-user-login-main">
        <div class="layadmin-user-login-header">
            <h2>Backstage management</h2>
            <p>Backstage management system, for internal use only</p>
        </div>
        <form class="layui-form" action="{{route('admin.user.login')}}" method="post">
            {{csrf_field()}}
            <div class="layui-form-item" pane>
                <label class="layui-form-label layui-icon layui-icon-username" ></label>
                <div class="layui-input-block">
                    <input type="text" name="username" required lay-verify="required" placeholder="username" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label layui-icon layui-icon-password"></label>
                <div class="layui-input-block">
                    <input type="password" name="password" required lay-verify="required" placeholder="please enter your password" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-form-item">
                <label class="layui-form-label layui-icon layui-icon-vercode"></label>
                <div class="layui-input-block">
                    <input type="text" name="captcha" id="captcha" placeholder="请输入验证码" autocomplete="off" class="layui-input admin-input admin-input-verify" value="">
                    <canvas id="canvas" width="100" height="43" class="admin-captcha"></canvas>
                </div>
            </div>
            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                    <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                </div>
            </div>
        </form>
    </div>

</div>

<script>
    $(function(){
        var show_num = [];
        draw(show_num);

        $("#canvas").on('click',function(){
            draw(show_num);
        })
        $(".layui-btn").on('click',function(){
            var val = $(".admin-input-verify").val().toLowerCase();
            var num = show_num.join("");
            if(val==''){
                alert('please enter verification code！');
            }else if(val == num){
                // alert('提交成功！');
                $(".admin-input-verify").val('');
                draw(show_num);

            }else{
                alert('Verification code error! please enter again！');
                $(".admin-input-verify").val('');
                draw(show_num);
            }
        })
    })
    function draw(show_num) {
        var canvas_width=$('#canvas').width();
        var canvas_height=$('#canvas').height();
        var canvas = document.getElementById("canvas");//获取到canvas的对象，演员
        var context = canvas.getContext("2d");//获取到canvas画图的环境，演员表演的舞台
        canvas.width = canvas_width;
        canvas.height = canvas_height;
        var sCode = "A,B,C,E,F,G,H,J,K,L,M,N,P,Q,R,S,T,W,X,Y,Z,1,2,3,4,5,6,7,8,9,0";
        var aCode = sCode.split(",");
        var aLength = aCode.length;//获取到数组的长度

        for (var i = 0; i <= 3; i++) {
            var j = Math.floor(Math.random() * aLength);//获取到随机的索引值
            var deg = Math.random() * 30 * Math.PI / 180;//产生0~30之间的随机弧度
            var txt = aCode[j];//得到随机的一个内容
            show_num[i] = txt.toLowerCase();
            var x = 10 + i * 20;//文字在canvas上的x坐标
            var y = 20 + Math.random() * 8;//文字在canvas上的y坐标
            context.font = "bold 23px 微软雅黑";

            context.translate(x, y);
            context.rotate(deg);

            context.fillStyle = randomColor();
            context.fillText(txt, 0, 0);

            context.rotate(-deg);
            context.translate(-x, -y);
        }
        for (var i = 0; i <= 5; i++) { //验证码上显示线条
            context.strokeStyle = randomColor();
            context.beginPath();
            context.moveTo(Math.random() * canvas_width, Math.random() * canvas_height);
            context.lineTo(Math.random() * canvas_width, Math.random() * canvas_height);
            context.stroke();
        }
        for (var i = 0; i <= 30; i++) { //验证码上显示小点
            context.strokeStyle = randomColor();
            context.beginPath();
            var x = Math.random() * canvas_width;
            var y = Math.random() * canvas_height;
            context.moveTo(x, y);
            context.lineTo(x + 1, y + 1);
            context.stroke();
        }
    }

    function randomColor() {//得到随机的颜色值
        var r = Math.floor(Math.random() * 256);
        var g = Math.floor(Math.random() * 256);
        var b = Math.floor(Math.random() * 256);
        return "rgb(" + r + "," + g + "," + b + ")";
    }
</script>

<script src="/static/layui/layui.js"></script>
<script>
    layui.use(['layer', 'form'], function(){
        var layer = layui.layer
            ,form = layui.form;

        // layer.msg('Hello World');
    });
</script>
</body>
</html>
