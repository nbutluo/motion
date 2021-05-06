@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新产品分类</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.catalog.category.update',['id'=>$category->id])}}" method="post">
                {{ method_field('post') }}
                @include('admin.product-category._form')
            </form>
        </div>
    </div>
@endsection
