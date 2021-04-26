@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加文章</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.blog.article.create-post')}}" method="post" >
                @include('admin.blog._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.blog._js')
@endsection
