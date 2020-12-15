<section class="sidebar">
    <div class="user-panel">
        <div class="pull-left image">
            <img src="/adminlte/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p>Admin-你好</p>
        </div>
    </div>
    <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
            </span>
        </div>
    </form>

    <ul class="sidebar-menu" data-widget="tree">

        <li class="header">用户</li>
        <li class=" treeview">
            <a href="#">
                <i class="fa fa-user"></i>
                <span>用户管理</span>
            </a>
            <ul class="treeview-menu">
                <li class=""><a href="{{ route('user.index') }}"><i class="fa fa-list-ul"></i> 用户列表</a></li>
                <li class=""><a href="#"><i class="fa fa-book"></i>用户管理-图文</a></li>
                <li class=""><a href="#"><i class="fa fa-video-camera"></i>用户管理-视频</a></li>
            </ul>
        </li>
        <li class="header">视频</li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-video-camera"></i> <span>视频管理</span>
            </a>
            <ul class="treeview-menu">
                <li><a href=""><i class="fa fa-bars"></i> 视频列表</a></li>
                <li><a href=""><i class="fa  fa-download"></i> 下载详情</a></li>
                <li><a href=""><i class="fa fa-circle-o"></i> 视频类别</a></li>
                <li><a href=""><i class="fa  fa-upload"></i> 上传视频</a></li>
            </ul>
        </li>
        <li class="header">图文</li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-folder"></i>
                <span>图文资源</span>
            </a>
            <ul class="treeview-menu">
                <li><a href=""><i class="fa  fa-book"></i> 图文列表</a></li>
                <li><a href=""><i class="fa  fa-download"></i> 下载详情</a></li>
                <li><a href=""><i class="fa fa-circle-o"></i> 图文类别</a></li>
                <li><a href=""><i class="fa  fa-upload"></i> 图文上传</a></li>
            </ul>
        </li>
        <li class="header">权限</li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-lock"></i>
                <span>权限设置</span>
            </a>
            <ul class="treeview-menu">
                <li><a href=""><i class="fa fa-circle-o"></i> 游客</a></li>
                <li><a href=""><i class="fa fa-circle-o"></i> 普通用户</a></li>
                <li><a href=""><i class="fa fa-circle-o"></i> 一级用户</a></li>
                <li><a href=""><i class="fa fa-circle-o"></i>二级用户</a></li>
            </ul>
        </li>
    </ul>
</section>
