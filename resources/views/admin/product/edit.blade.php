@extends('admin.base')

@section('content')
<div class="layui-card">
    <div class="layui-card-header layuiadmin-card-header-auto">
        <h2>更新产品 ID: {{$product->id}}</h2>
    </div>
    <div class="layui-card-body">
        <form class="layui-form" action="{{route('admin.catalog.product.update',['id'=>$product->id])}}" method="post"
              enctype="multipart/form-data">
            {{ method_field('post') }}
            @include('admin.product._form')
        </form>
    </div>
</div>
@endsection

{{-- 必须这个位置，DOM元素预先加载进缓存才能调用方案 --}}
{{--<script>
    --}}
{{--    function goBack(){--}}
{{--        window.history.back()--}}
{{--    }--}}
{{--
</script>--}}

@section('script')
@include('admin.product._js')
@endsection
