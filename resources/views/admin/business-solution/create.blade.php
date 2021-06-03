@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加solution</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.solution.add')}}" method="post" >
                @include('admin.business-solution._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.business-solution._js')
@endsection
