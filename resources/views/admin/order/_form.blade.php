{{csrf_field()}}
<input type="hidden" name="order_id" value="{{$id}}">
<div class="layui-form-item">
    <label for="" class="layui-form-label">订单状态</label>
    <div class="layui-input-inline">
        <select name="status">
            <option value="pending" @if(isset($data['status'])&&$data['status']=='pending')selected @endif>pending</option>
            <option value="processing" @if(isset($data['status'])&&$data['status']=='processing')selected @endif>processing</option>
            <option value="complete" @if(isset($data['status'])&&$data['status']=='complete')selected @endif>complete</option>
            <option value="closed" @if(isset($data['status'])&&$data['status']=='closed')selected @endif>closed</option>
            <option value="holded" @if(isset($data['status'])&&$data['status']=='holded')selected @endif>holded</option>
        </select>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">价格</label>
    <div class="layui-input-block">
        <input type="text" name="order_price" value="{{$data['order_price']}}" class="layui-input" placeholder="订单价格">
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">顾客名</label>
    <div class="layui-input-block">
        <input type="text" name="customer_name" value="{{$data['customer_name']}}" class="layui-input" disabled="disabled">
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">顾客邮箱</label>
    <div class="layui-input-block">
        <input type="text" name="customer_email" value="{{$data['customer_email']}}" class="layui-input">
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">业务员</label>
    <div class="layui-input-inline">
        <select name="salesman">
            <option value="">---未选择---</option>
            @foreach($salesmans as $salesman)
                <option value="{{ $salesman->id }}" @if(isset($data['salesman'])&&$data['salesman']==$salesman->id)selected @endif >{{ $salesman->nickname }}</option>
            @endforeach
        </select>
    </div>
</div>
<hr class="layui-border-black">
@if (isset($data['items']) && !empty($data['items']))
@foreach($data['items'] as $key => $item)
    <h2>产品{{$key+1}}</h2>
    <div class="layui-form-item">
        <label for="" class="layui-form-label">产品名称</label>
        <div class="layui-input-block">
            <input type="text" value="{{$item['product_name']}}" class="layui-input" disabled="disabled">
        </div>
    </div>
    <div class="layui-form-item">
        <label for="" class="layui-form-label">产品sku</label>
        <div class="layui-input-block">
            <input type="text" value="{{$item['product_sku']}}" class="layui-input" disabled="disabled">
        </div>
    </div>
    <div class="layui-form-item">
        <label for="" class="layui-form-label">单价</label>
        <div class="layui-input-block" id="layer-picture">
            <input type="text" name="item_price_{{$item['item_id']}}" value="{{$item['item_price']}}" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label for="" class="layui-form-label">购买数量</label>
        <div class="layui-input-block" id="layer-picture">
            <input type="text" name="item_qty_{{$item['item_id']}}" value="{{$item['product_qty']*1}}" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label for="" class="layui-form-label">产品主图</label>
        <div class="layui-input-block" id="layer-picture">
            @if(isset($item['product_image']))
                <img src="{{$item['product_image'] }}" alt="{{$item['product_image_label']}}" />
            @endif
        </div>
    </div>
    @if (isset($item['child']) && !empty($item['child']))
        @foreach($item['child'] as $option)
            @if (isset($option['option_color']))
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">颜色</label>
                    <div class="layui-input-block">
                        <input type="text" style="background-color: {{$option['option_color']}}" value="{{$option['option_color']}}" class="layui-input" disabled="disabled">
                    </div>
                </div>
            @endif
            @if (isset($option['option_size']))
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">尺寸</label>
                    <div class="layui-input-block">
                        <input type="text" value="{{$option['option_size']}}" class="layui-input" disabled="disabled">
                    </div>
                </div>
            @endif
        @endforeach
    @endif
    <hr class="layui-border-cyan">
@endforeach
@endif
<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a class="layui-btn" href="{{route('admin.order.index')}}" >返 回</a>
    </div>
</div>
