@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加产品选项</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.catalog.option.create')}}" method="post" >
                @include('admin.product-option._form')
            </form>
        </div>
    </div>
@endsection

{{-- 必须这个位置，DOM元素预先加载进缓存才能调用方法 --}}
<script>
    function goBack(){
        window.history.back()
    }
</script>

@section('script')
    @include('admin.product-option._js')
@endsection
