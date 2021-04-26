@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新文章</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.blog.article.update',['id'=>$post->post_id])}}" method="post">
                {{ method_field('post') }}
                @include('admin.blog._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.blog._js')
@endsection
