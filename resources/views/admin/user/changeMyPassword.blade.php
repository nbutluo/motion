@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header">
            <h2>change password</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route("admin.user.changeMyPassword")}}" method="post">
                {{csrf_field()}}
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">原密码</label>
                    <div class="layui-input-inline">
                        <input type="password" name="old_password" required lay-verify="required" placeholder="请输入原始密码" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">新密码</label>
                    <div class="layui-input-inline">
                        <input type="password" id="new_password" name="new_password" maxlength="" required lay-verify="required" placeholder="请输入新密码" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">确认密码</label>
                    <div class="layui-input-inline">
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" maxlength="" required lay-verify="required" placeholder="请确认新密码" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label"></label>
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="formDemo">change</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(function(){
            $(".layui-btn").on('click',function(){
                var password = $("#new_password").val().toLowerCase();
                var password_confirmation = $("#new_password_confirmation").val().toLowerCase();
                if (password !== password_confirmation) {
                    alert('The password you entered is inconsistent');
                    return false;
                }
            })
        })
    </script>
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
