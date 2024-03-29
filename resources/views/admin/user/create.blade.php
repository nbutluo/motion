@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加管理员</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.user.store')}}" method="post">
                @include('admin.user._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        layui.use(['element','form'],function () {

        })
    </script>
@endsection
