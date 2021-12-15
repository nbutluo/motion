@extends('admin.base')

@section('content')
<div class="layui-card">
    <div class="layui-card-header layuiadmin-card-header-auto">
        <h2>更新文章</h2>
    </div>
    <div class="layui-card-body">
        <form class="layui-form" action="{{route('admin.blog.article.update',$post->post_id)}}" method="post">
            <input type="hidden" name="_method" value="PUT">
            @include('admin.blog._form')
        </form>
    </div>
</div>
@endsection

@section('script')
@include('admin.blog._js')
@endsection
