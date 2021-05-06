{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">名称</label>
    <div class="layui-input-block">
        <input type="text" name="name" value="{{$product->name??old('name')}}" lay-verify="required" placeholder="请输入产品标题" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">SKU</label>
    <div class="layui-input-block">
        <input type="text" name="sku" value="{{$product->sku??old('sku')}}" lay-verify="required" placeholder="请输入SKU" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">是否启用</label>
    <div class="layui-input-block">
        <select name="is_active">
            <option value="0" @if(isset($product->is_active)&&$product->is_active==0)selected @endif>否</option>
            <option value="1" @if(isset($product->is_active)&&$product->is_active==1)selected @endif>是</option>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">分类</label>
    <div class="layui-input-inline">
        <select name="category_id">
            <option value="0">未选择</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @if(isset($product->category_id)&&$product->category_id==$category->id)selected @endif >{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">主图</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn layui-btn-sm uploadPic"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul class="layui-upload-box layui-clear">
                    @if(isset($product->image))
                        <li><img src="{{ $product->image }}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="image" class="layui-upload-input" value="{{ $product->image??'' }}">
            </div>
        </div>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">主图label</label>
    <div class="layui-input-block">
        <input type="text" name="image_label" value="{{$product->image_label??old('image_label')}}" placeholder="请输入主图标签" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">短描述</label>
    <div class="layui-input-block">
        <textarea type="text" name="short_description" placeholder="短描述，可为空" class="layui-textarea" >{!! $product->short_description??old('short_description') !!}</textarea>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">产品内容</label>
    <div class="layui-input-block">
        <script id="container" name="description" type="text/plain" style="width: 98%">
            {!! $product->description??old('description') !!}
        </script>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">位置权重</label>
    <div class="layui-input-block">
        <input type="text" name="position" value="{{$product->position??old('position')}}" placeholder="请输入位置权重值" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a class="layui-btn" onclick="goBack()" >返 回</a>
    </div>
</div>
