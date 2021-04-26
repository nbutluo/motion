@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header">
            <h2>个人资料</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.user.infoUpdate')}}" method="post">
                {{csrf_field()}}
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">用户名</label>
                    <div class="layui-input-inline">
                        <input type="text" name="username" placeholder="请输入用户名" class="layui-input" value="{{auth()->user()->username}}">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">昵称</label>
                    <div class="layui-input-inline">
                        <input type="text" name="nickname" placeholder="请输入昵称" class="layui-input" value="{{auth()->user()->nickname}}">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">email</label>
                    <div class="layui-input-inline">
                        <input type="text" name="email" placeholder="请输入邮箱" class="layui-input" value="{{auth()->user()->email}}">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">电话</label>
                    <div class="layui-input-inline">
                        <input type="text" name="phone" placeholder="请输入电话" class="layui-input" value="{{auth()->user()->phone}}">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label"></label>
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="formDemo">修改</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        layui.use(['layer','table','form','element'],function () {
            var layer = layui.layer;
            var form = layui.form;
            var table = layui.table;

        })
    </script>
@endsection
