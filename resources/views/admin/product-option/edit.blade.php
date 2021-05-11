@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新产品选项 ID: {{$product->id}}</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.catalog.option.update',['id'=>$product->id])}}" method="post">
                {{ method_field('post') }}
                @include('admin.product-option._form')
            </form>
        </div>
    </div>
@endsection

{{-- 必须这个位置，DOM元素预先加载进缓存才能调用方案 --}}
<script>
    function goBack(){
        window.history.back()
    }
</script>

@section('script')
    @include('admin.product-option._js')
@endsection
