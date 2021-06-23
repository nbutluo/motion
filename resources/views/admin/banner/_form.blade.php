{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">所属页面</label>
    <div class="layui-input-inline">
        <select name="page_name">
            <option value="">---请选择---</option>
            @foreach($pageNames as $pageName)
                <option value="{{$pageName}}" @if(isset($banner->page_name)&&$banner->page_name==$pageName)selected @endif>{{$pageName}}</option>
            @endforeach
        </select>
    </div>
</div>

{{--<div class="layui-form-item">--}}
{{--    <label for="" class="layui-form-label">banner图片</label>--}}
{{--    <div class="layui-input-block">--}}
{{--        <div class="layui-upload">--}}
{{--            <button type="button" class="layui-btn layui-btn-sm uploadPic"><i class="layui-icon">&#xe67c;</i>图片上传</button>--}}
{{--            <div class="layui-upload-list" >--}}
{{--                <ul class="layui-upload-box layui-clear">--}}
{{--                    @if(isset($banner->media_url))--}}
{{--                        <li id="layer-picture"><img src="{{ $banner->media_url }}" /><p>上传成功</p></li>--}}
{{--                        <span>可点击放大图片</span>--}}
{{--                    @endif--}}
{{--                </ul>--}}
{{--                <input type="hidden" name="media_url" class="layui-upload-input" value="{{ $banner->media_url??'' }}">--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">banner图片</label>
    <div class="layui-upload">
        <button type="button" class="layui-btn" id="images">多图片上传</button>
        <button type="button" class="layui-btn" id="btn_image_clear">清空多图</button>
        <blockquote class="layui-elem-quote layui-quote-nm" style="margin-top: 10px;">
            预览图:<span style="color:#8d8d8d;">(单击删除)</span>
            <div class="layui-upload-list" id="images_show">
                @if (isset($banner->media_url) && $banner->media_url != '')
                    @foreach($banner->media_url as $image)
                        <div onclick="delMultipleImgs(this)">
                            <img style="float:left;width:100%;height:auto;" src="{{$image}}" alt="{{$image}}" id="{{$image}}"{{-- onclick="delMultipleImgs(this)"--}}>
                            <input type="hidden" name="media_url[]" class="{{$image}}" value="{{$image}}">
                        </div>
                    @endforeach
                @endif
            </div>
        </blockquote>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">banner图片alt</label>
    <div class="layui-input-block">
        <input type="text" name="banner_alt" value="{{$banner->banner_alt??old('banner_alt')}}" lay-verify="required" placeholder="请输入banner图片alt属性值" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">是否启用</label>
    <div class="layui-input-block">
        <select name="is_active">
            <option value="0" @if(isset($banner->is_active)&&$banner->is_active==0)selected @endif>否</option>
            <option value="1" @if(isset($banner->is_active)&&$banner->is_active==1)selected @endif>是</option>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">描述</label>
    <div class="layui-input-block">
        <input type="text" name="description" value="{{$banner->description??old('description')}}" lay-verify="required" placeholder="请输入描述" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a class="layui-btn" href="{{route('admin.banner.index')}}" >返 回</a>
    </div>
</div>
