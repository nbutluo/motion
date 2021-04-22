<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="/static/layui/css/layui.css" media="all">>
    @yield('css')
    <script src="/static/js/jquery-3.5.1.min.js"></script>
</head>
<body>

<div id="layui-admin-content" class="layui-fluid" style="display: none">
    @yield('content')
</div>

<script src="/static/layui/layui.js"></script>
<script>
    /**
     * 点击打开新 tab
     * @param routeName 路由名称，如：task.info, /admin/task/info
     * @param title
     */
    function newTab(routeName, title) {
        let url;
        // 若该路由名是一个菜单，则获取该菜单的信息
        if (top.menu_names.hasOwnProperty(routeName)) {
            url = top.menu_names[routeName]['url'];
            title = top.menu_names[routeName]['display_name'];
        } else {
            url = routeName;
        }

        // 若 top 中存在 layui 的 index 模块
        if (top.layui.index) {
            top.layui.index.openTabsPage(url, title)
        } else {
            window.open(url)
        }
    }

    layui.config({
        base: '/static/admin/layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['layer'], function () {
        var $ = layui.jquery;
        var layer = layui.layer;
    });
</script>
<script type="text/javascript">
    /**
     * layui 全局设置
     */
    layui.use(['element', 'form', 'layer'], function () {
        var element = layui.element;
        var form = layui.form;
        var layer = layui.layer;

        // 表单验证
        form.verify({
            // 必填的提示
            requiredTip: function (input, item) {
                if (!input) {
                    return $(item).attr('placeholder');
                }
            },
            // 手机号验证
            verifyPhone: function (input, item) {
                if (!(/^1[3456789]\d{9}$/.test(input))) {
                    return '请输入正确的手机号码';
                }
            }
        });

        //错误提示
        @if(count($errors)>0)
        @foreach($errors->all() as $k => $error)
        parent.layer.msg("{{$error}}", {icon: 2, anim: 6, offset: '110px'});
        @break
        @endforeach
        @endif

        //一次性正确信息提示
        @if(session('success'))
        parent.layer.msg("{{session('success')}}", {icon: 1, offset: '110px'});
        @endif

        //一次性错误信息提示
        @if(session('error'))
        parent.layer.msg("{{session('error')}}", {icon: 2, anim: 6, offset: '110px'});
        @endif
    });

    /**
     * ajax 全局设置
     */
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function (XHR) {

        },
        complete: function (jqXHR, textStatus) { // 主要用于 layui
            parent.layer.closeAll('loading');
            ajaxErrorFunction(jqXHR, textStatus);
        },
        // error: ajaxErrorFunction,
    });

    function ajaxErrorFunction(jqXHR, textStatus, errorThrown = '服务器异常') {
        let code = jqXHR.status;
        // 若 code = 200 不作处理
        if (code === 200) {
            return;
        }

        let msg = '';

        // 获取错误提示
        if (jqXHR.hasOwnProperty('responseJSON')) {
            if (jqXHR.responseJSON.hasOwnProperty('msg') || jqXHR.responseJSON.hasOwnProperty('message')) {
                msg = jqXHR.responseJSON.msg ? jqXHR.responseJSON.msg : jqXHR.responseJSON.message;
            }
        }

        // 根据不同错误代码进行处理
        switch (code) {
            case(500):
                parent.layer.msg(msg ? msg : '服务器系统内部错误', {icon: 5, anim: 6, offset: '110px'});
                break;
            case(401):
                layer.msg(msg ? msg : '未登录', {icon: 5, anim: 6, offset: '110px'});
                window.setTimeout(function () {
                    top.location.href = '{{ route('admin.user.login') }}';
                }, 2000)
                break;
            case(403):
                parent.layer.msg(msg ? msg : '无权进行此操作', {icon: 5, anim: 6, offset: '110px'});
                break;
            case(408):
                parent.layer.msg(msg ? msg : '请求超时', {icon: 5, anim: 6, offset: '110px'});
                break;
            case(422):
                let array = jqXHR.responseJSON.msg;
                parent.layer.msg(array[0], {icon: 5, anim: 6, offset: '110px'});
                break;
            default: // 其他除了 200 外的错误码
                parent.layer.msg(msg ? msg : errorThrown, {icon: 5, anim: 6, offset: '110px'});
        }
    }

    /**
     * 查看密码
     * @param e 元素对象
     */
    function checkPassword(e) {
        let obj = $(e).parents('.check-password-wrap').find('.check-password-content');

        // 判断是否有显示密码
        if (obj.hasClass('check-password-input-show')) {
            obj.prop('type', 'password').removeClass('check-password-input-show').addClass('check-password-input-hide');
        } else {
            obj.prop('type', 'text').removeClass('check-password-input-hide').addClass('check-password-input-show');
        }
    }

    /**
     * 获取表单所有值
     * @param obj 表单对象，如：$('#form')
     * @returns {{}}
    */
    function getFormValues (obj) {
        let arr = obj.serializeArray();
        let data = {};
        for (k in arr) {
            data[arr[k].name] = arr[k].value;
        }
        return data;
    }
</script>
@include('admin.common.js.pic_check_js')
@yield('script')
</body>
</html>



