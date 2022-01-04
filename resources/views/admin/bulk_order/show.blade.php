@extends('admin.base')

@section('content')
<div class="layui-form-item">
    <label for="" class="layui-form-label">姓名</label>
    <div class="layui-input-block layui-sm">
        <input type="text" name="name" value="{{$bulkOrder->name ?? ''}}" class="layui-input" disabled>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">邮箱</label>
    <div class="layui-input-block layui-sm">
        <input type="text" name="email" value="{{$bulkOrder->email ?? ''}}" class="layui-input" disabled>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">公司</label>
    <div class="layui-input-block layui-sm">
        <input type="text" name="company" value="{{$bulkOrder->company ?? ''}}" class="layui-input" disabled>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">Message</label>
    <div class="layui-input-block">
        <textarea type="text" name="message" placeholder="Message" class="layui-textarea"
                  disabled>{!! $bulkOrder->message??old('message') !!}</textarea>
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <a class="layui-btn" href="{{route('admin.bulk_order.index')}}">返 回</a>
    </div>
</div>
@endsection
