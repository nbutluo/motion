@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加产品分类</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.catalog.category.store')}}" method="post">
                @include('admin.product-category._form')
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
