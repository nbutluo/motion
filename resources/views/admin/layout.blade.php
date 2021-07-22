<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>LoctekMotion后台</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="/static/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/admin/layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/admin/layuiadmin/style/admin.css" media="all">
{{--    <link rel="stylesheet" href="/static/css/chris.css" media="all">--}}
    <script src="/static/js/jquery-3.5.1.min.js"></script>
</head>
<body class="layui-layout-body">
<div id="LAY_app">
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
            <!-- 头部区域 -->
            <ul class="layui-nav layui-layout-left">
                <li class="layui-nav-item layadmin-flexible" lay-unselect>
                    <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
                        <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect style="cursor: pointer;">
                    <a>
                        <i onclick="frontPackage()" class="layui-icon layui-icon-website"></i>
                    </a>
                </li>
                <li class="layui-nav-item" lay-unselect>
                    <a href="javascript:;" layadmin-event="refresh" title="刷新">
                        <i class="layui-icon layui-icon-refresh-3"></i>
                    </a>
                </li>
            </ul>
            <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right">
                <li class="layui-nav-item" lay-unselect>
                    <a  layadmin-event="message" lay-text="消息中心">
                        <i class="layui-icon layui-icon-notice"></i>
                        <!-- 如果有新消息，则显示小圆点 -->
                        <span class="layui-badge-dot"></span>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="theme">
                        <i class="layui-icon layui-icon-theme"></i>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="note">
                        <i class="layui-icon layui-icon-note"></i>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="fullscreen">
                        <i class="layui-icon layui-icon-screen-full"></i>
                    </a>
                </li>
                <li class="layui-nav-item" lay-unselect>
                    <a href="javascript:;">
                        <cite>{{auth()->user()->nickname ?: auth()->user()->username}}</cite>
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a lay-href="{{route('admin.user.myForm')}}">个人资料</a></dd>
                        <dd><a lay-href="{{route('admin.user.changeMyPasswordForm')}}">修改密码</a></dd>
                        <dd><a href="{{route('admin.user.logout')}}">退出</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="about"><i class="layui-icon layui-icon-more-vertical"></i></a>
                </li>
                <li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-unselect>
                    <a href="javascript:;" ><i class="layui-icon layui-icon-more-vertical"></i></a>
                </li>
            </ul>
        </div>

        <!-- 侧边菜单 -->
        <div class="layui-side layui-side-menu">
            <div class="layui-side-scroll">
                <div class="layui-logo" lay-href="{{route('admin.index')}}" style="top: 30px">{{--未完成--}}
                    <span><img loading="lazy" src="/static/images/logo/locteklogo-new.png" alt="Loctek-Logo" width="180"></span>
                </div>
                <ul class="layui-nav layui-nav-tree" lay-shrink="all" id="LAY-system-side-menu" style="margin-top: 100px">
                    <li data-name="home" class="layui-nav-item layui-nav-itemed">
                        <a href="javascript:;" lay-tips="主页" lay-direction="2">
                            <i class="layui-icon layui-icon-home"></i>
                            <cite>主页</cite>
                        </a>
                        <dl class="layui-nav-child">
                            <dd data-name="console" class="layui-this">
                                <a lay-href="{{route('admin.index')}}">控制台</a>
                            </dd>
                        </dl>
                    </li>
                    @foreach($menus as $menu)
                        @if ($currentUser->hasAnyRole(['root']) || $currentUser->can($menu->name))
                            <li data-name="{{$menu->name}}" class="layui-nav-item">
                                <a href="javascript:;" lay-tips="{{$menu->display_name}}" lay-direction="2">
                                    <i class="layui-icon {{$menu->icon}}"></i>
                                    <cite>{{$menu->display_name}}</cite>
                                </a>
                                @if ($menu->childsMenus->isNotEmpty())
                                    <dl class="layui-nav-child">
                                        @foreach ($menu->childsMenus as $subMenu)
                                            @if ($currentUser->hasAnyRole(['root']) || $currentUser->can($menu->name))
                                                <dd data-name="{{$subMenu->name}}">
                                                    <a lay-href="{{ route($subMenu->route) }}">{{$subMenu->display_name}}</a>
                                                </dd>
                                            @endif
                                        @endforeach
                                    </dl>
                                @endif
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- 页面标签 -->
        <div class="layadmin-pagetabs" id="LAY_app_tabs">
            <div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
            <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
            <div class="layui-icon layadmin-tabs-control layui-icon-down">
                <ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
                    <li class="layui-nav-item" lay-unselect>
                        <a href="javascript:;"></a>
                        <dl class="layui-nav-child layui-anim-fadein">
                            <dd layadmin-event="closeThisTabs"><a href="javascripte:;">关闭当前标签页</a></dd>
                            <dd layadmin-event="closeOtherTabs"><a href="javascripte:;">关闭其他标签页</a></dd>
                            <dd layadmin-event="closeAllTabs"><a href="javascripte:;">关闭全部标签页</a></dd>
                        </dl>
                    </li>
                </ul>
            </div>
            <div class="layui-tab" lay-unauto lay-allowClose="true" lay-filter="layadmin-layout-tabs">
                <ul class="layui-tab-title" id="LAY_app_tabsheader">{{--未完成--}}
                    <li lay-id="{{route('admin.index')}}" lay-attr="{{route('admin.index')}}" class="layui-this"><i class="layui-icon layui-icon-home"></i></li>
                </ul>
            </div>
        </div>

        <!-- 主体内容 -->
        <div class="layui-body" id="LAY_app_body">
            <div class="layadmin-tabsbody-item layui-show">
                <iframe src="{{route('admin.index')}}" frameborder="0" class="layadmin-iframe" onload="iframeLoad(this)"></iframe>
            </div>
        </div>

        <!-- 辅助元素，一般用于移动设备下遮罩 -->
        <div class="layadmin-body-shade" layadmin-event="shade"></div>

    </div>
</div>
<script src="/static/admin/layuiadmin/layui/layui.js"></script>
{{--<script src="/static/layui/layui.js"></script>--}}
<script>
    var layform;
    var layelement;

    layui.config({
        base: '/static/admin/layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
    }).use(['index', 'form', 'element'], function () {
        layform = layui.form;
        layelement = layui.element;
    });

    // 变量：菜单名称
    var menu_names = {!! $menu_names !!};

    function iframeLoad(e) {
        $(e).contents().find("#layui-admin-content").fadeIn();
    }

    function frontPackage() {
        var loading = layer.msg('正在刷新', {icon: 16, shade: 0.3, time:0});
        var result = '';
        setTimeout(() => {
            $.ajax({
                type:"post",
                dataType:"json",
                url:'{{route("admin.front.package.index")}}',
                data:{"_token": "{{ csrf_token() }}"},
                cache: false,
                async: false,
                success:function(data){
                    result = data;
                    console.log(data);
                },
            });
            layer.close(loading);
        }, 100)
    }
</script>
@include('admin.common.js.pic_check_js')
</body>
</html>


