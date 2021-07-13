@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新链接</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.site.map.update',['id'=>$siteMap->id])}}" method="post">
                {{ method_field('post') }}
                @include('admin.siteMap._form')
            </form>
        </div>
    </div>
@endsection
