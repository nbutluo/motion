@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加About Loctek</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.about.loctek.add')}}" method="post" >
                @include('admin.about-loctek._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.about-loctek._js')
@endsection
