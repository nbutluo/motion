@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新solution</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.solution.update',['id'=>$id])}}" method="post">
                {{ method_field('post') }}
                @include('admin.business-solution._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.business-solution._js')
@endsection
