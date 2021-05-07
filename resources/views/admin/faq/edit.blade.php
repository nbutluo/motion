@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新答疑</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.faq.update',['id'=>$question->id])}}" method="post">
                {{ method_field('post') }}
                @include('admin.faq._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.faq._js')
@endsection
