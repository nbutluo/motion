{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">标题</label>
    <div class="layui-input-inline">
        <input type="text" name="title" value="{{$media->title??old('title')}}" lay-verify="required" placeholder="请输入媒体资源标题" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">资源类型</label>
    <div class="layui-input-inline">
        <select name="media_type">
            <option value="0">未选择</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @if(isset($media->media_type)&&$media->media_type==$category->id)selected @endif >{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">资源分类</label>
    <div class="layui-input-inline">
        <select name="category_id">
            <option value="0">未选择</option>
            @foreach($categoryData as $category)
                <option value="{{ $category['id'] }}" disabled >{{ $category['title'] }}</option>
                @if (isset($category['children']) && !empty($category['children']))
                    @foreach($category['children'] as $firstCategory)
                        <option value="{{ $firstCategory['id'] }}" disabled >-----{{ $firstCategory['title'] }}</option>
                        @if (isset($firstCategory['children']) && !empty($firstCategory['children']))
                            @foreach($firstCategory['children'] as $secondCategory)
                                <option value="{{ $secondCategory['id'] }}" @if(isset($media->category_id)&&$media->category_id==$secondCategory['id'])selected @endif >----------{{ $secondCategory['title'] }}</option>
                            @endforeach
                        @endif
                    @endforeach
                @endif
            @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">描述</label>
    <div class="layui-input-block">
        <input type="text" name="description" value="{{$media->description??old('description')}}" lay-verify="required" placeholder="请输入description" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">是否启用</label>
    <div class="layui-input-inline">
        <select name="is_active">
            <option value="0" @if(isset($media->is_active)&&$media->is_active==0)selected @endif>否</option>
            <option value="1" @if(isset($media->is_active)&&$media->is_active==1)selected @endif>是</option>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">图片文件</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn layui-btn-sm uploadPic"><i class="layui-icon">&#xe67c;</i>图片上传</button>  <span style="color:red">pdf格式需要</span>
            <div class="layui-upload-list" >
                <ul class="layui-upload-box layui-clear">
                    @if(isset($media->media_url))
                        <li><img src="{{ $media->media_url }}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="media_url" class="layui-upload-input" value="{{ $media->media_url??'' }}">
            </div>
        </div>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">资源文件</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn layui-btn-sm uploadMedia"><i class="layui-icon">&#xe67c;</i>资源上传</button>
            <div class="layui-upload-list" >
                <ul class="layui-upload-box layui-clear">

                </ul>
                <input type="hidden" name="media_links" class="layui-upload-input" value="{{ $media->media_links??'' }}">
            </div>
        </div>
        <div class="media_links_box">
            @if(isset($media->media_links))
                <li>资源链接：  {{ $media->media_links??'' }}</li>
            @endif
        </div>
    </div>

</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">位置权重</label>
    <div class="layui-input-block">
        <input type="text" name="position" value="{{$media->position??old('position')}}" placeholder="请输入位置权重值" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-inline">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a class="layui-btn" onclick="goBack()" >返 回</a>
    </div>
</div>
