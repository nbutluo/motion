{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">名称</label>
    <div class="layui-input-block">
        <input type="text" name="name" value="{{$product->name??old('name')}}" placeholder="请输入产品标题"
               class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">SKU</label>
    <div class="layui-input-block">
        <input type="text" name="sku" value="{{$product->sku??old('sku')}}" placeholder="请输入SKU" class="layui-input">
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
@isset($product)
<div class="layui-form-item">
    <label for="" class="layui-form-label">是否为新品</label>
    <div class="layui-input-block">
        <select name="is_new_arrival">
            <option value="0" @if(isset($product->is_new_arrival)&&$product->is_new_arrival==0)selected @endif>否
            </option>
            <option value="1" @if(isset($product->is_new_arrival)&&$product->is_new_arrival==1)selected @endif>是
            </option>
        </select>
    </div>
</div>
@endisset

<div class="layui-form-item">
    <label for="" class="layui-form-label">分类</label>
    <div class="layui-input-inline">
        <select name="category_id">
            <option value="">未选择</option>
            @foreach($categories as $category)
            <option value="{{ $category->id }}" @if(isset($product->
                category_id)&&$product->category_id==$category->id)selected @endif >@if($category->level ==2)
                ----@endif{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">图片</label>
    <div class="layui-input-block">
        <div id="product-image"></div>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">主图label</label>
    <div class="layui-input-block">
        <input type="text" name="image_label" value="{{$product->image_label??old('image_label')}}"
               placeholder="请输入主图标签" class="layui-input">
    </div>
</div>

@isset($product)
<div class="layui-form-item">
    <label for="" class="layui-form-label">meta_title</label>
    <div class="layui-input-block">
        <input type="text" name="meta_title" value="{{$product->meta_title??old('meta_title')}}" class="layui-input">
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">meta_desc</label>
    <div class="layui-input-block">
        <input type="text" name="meta_description" value="{{$product->meta_description??old('meta_description')}}"
               class="layui-input">
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">meta_keyword</label>
    <div class="layui-input-block">
        <input type="text" name="meta_keywords" value="{{$product->meta_keywords??old('meta_keywords')}}"
               class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">视频封面</label>
    <div class="layui-input-block">
        <div id="product_video_poster"></div>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">视频</label>
    <div class="layui-input-block" style="width: 30%">
        @if ($product->video_url)
        <video src="{!! $product->video_url !!}" controls style="width: 400px"></video>
        <input type="text" name="video_url" hidden value="{{old('video_url',$product->video_url)}}">
        <span class="layui-btn layui-btn-sm layui-btn-danger btn-del">删除</span>
        @else
        <input type="file" name="video_url" id="product-video" class="filepond" data-max-files="1">
        @endif
    </div>
</div>
@endisset

<div class="layui-form-item">
    <label for="" class="layui-form-label">产品关联</label>
    <div id="product-list" class="demo-transfer"></div>
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
    </fieldset>
</div>

@isset($product)
<div class="layui-form-item">
    <label for="" class="layui-form-label">同系列产品</label>
    <div id="product-list2" class="demo-transfer"></div>
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
    </fieldset>
</div>
@endisset

<div class="layui-form-item">
    <label for="" class="layui-form-label">短描述</label>
    <div class="layui-input-block">
        <textarea type="text" name="short_description" placeholder="短描述，可为空"
                  class="layui-textarea">{!! $product->short_description??old('short_description') !!}</textarea>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">产品内容</label>
    <div class="layui-input-block">
        <textarea name="description" id="container" cols="30"
                  rows="10">{{$product->description??old('description')}}</textarea>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">手机端产品内容</label>
    <div class="layui-input-block">
        <textarea name="description_mobile" id="container-mobile" cols="30"
                  rows="10">{{$product->description_mobile??old('description_mobile')}}</textarea>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">产品参数</label>
    <div class="layui-input-block">
        <textarea name="parameters" id="parameters" cols="30"
                  rows="10">{{$product->parameters??old('parameters')}}</textarea>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">手机端产品参数</label>
    <div class="layui-input-block">
        <textarea name="parameters_mobile" id="parameters_mobile" cols="40" rows="10"
                  class="layui-textarea">{{$product->parameters_mobile??old('parameters_mobile')}}</textarea>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">位置权重</label>
    <div class="layui-input-block">
        <input type="text" name="position" value="{{$product->position??old('position')}}" placeholder="请输入位置权重值"
               class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a class="layui-btn" href="{{route('admin.catalog.product')}}">返 回</a>
    </div>
</div>

<script type="text/javascript">
    var cupload = new Cupload({
        ele: "#product-image",
        name: 'image',
        num: 5,
        data: "{{ $product->image }}".split(';'),
    });
</script>


<script type="text/javascript">
    var cupload = new Cupload({
        ele: "#product_video_poster",
        name: 'video_poster',
        @isset($product->video_poster)
        data : ["{{ $product->video_poster ?? '' }}"],
        @endisset

    });
</script>


<script type="text/javascript">
    $(function() {
        $('.btn-del').click(function(el) {
            if (confirm('确认删除吗？')) {
                $input = `<input type="file" name="video_url" id="product-video">`
                $(this).parent().html($input);
            }
        })
    });
</script>

<script>
    var inputElement = document.querySelector('input[id="product-video"]')
      // Register the plugin
    FilePond.registerPlugin(
        FilePondPluginFileValidateSize,
        FilePondPluginFileValidateType
    );

    FilePond.setOptions({
        server: {
            url: "{{ route('admin.product.video') }}",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        allowFileTypeValidation: true,
        acceptedFileTypes:['video/mp4'],
        labelFileTypeNotAllowed:'格式有误',
        labelIdle: '<span class="filepond--label-action">点击上传视频</span>',
        allowFileSizeValidation:true,
        maxFileSize:'20MB',
        labelMaxFileSizeExceeded:'视频最大不能超过20M',
        allowMultiple:false
    });
    FilePond.create(inputElement)
</script>
