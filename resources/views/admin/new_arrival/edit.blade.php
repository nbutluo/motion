@extends('admin.base')

@section('content')
<div class="layui-card">
    <div class="layui-card-header layuiadmin-card-header-auto">
        <h2>更新产品 ID: {{$product->id}}</h2>
    </div>
    <div class="layui-card-body">
        <form class="layui-form" action="{{route('admin.new_arrival.update',$product->id)}}" method="post">
            @method('PATCH')
            @csrf
            <div class="layui-form-item">
                <label for="" class="layui-form-label">名称</label>
                <div class="layui-input-block">
                    <input type="text" name="name" value="{{$product->name??old('name')}}" disabled class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="" class="layui-form-label">SKU</label>
                <div class="layui-input-block">
                    <input type="text" name="sku" value="{{$product->sku??old('sku')}}" disabled class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="" class="layui-form-label">是否为新品</label>
                <div class="layui-input-block">
                    <select name="is_new_arrival">
                        <option value="0" @if(isset($product->is_new_arrival)&&$product->is_new_arrival==0)selected
                            @endif>否
                        </option>
                        <option value="1" @if(isset($product->is_new_arrival)&&$product->is_new_arrival==1)selected
                            @endif>是
                        </option>
                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <label for="" class="layui-form-label">排序</label>
                <div class="layui-input-block">
                    <input type="number" name="new_arrival_order"
                           value="{{$product->new_arrival_order??old('new_arrival_order')}}" placeholder="请输入图片顺序"
                           class="layui-input" min="0">
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
                    <a class="layui-btn" href="{{route('admin.new_arrival.index')}}">返 回</a>
                </div>
            </div>
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
