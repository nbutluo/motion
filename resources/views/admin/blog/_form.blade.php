{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">分类</label>
    <div class="layui-input-inline">
        <select name="category_id">
            <option value="0"></option>
            @foreach($categories as $category)
                <option value="{{ $category->category_id }}" @if(isset($post->category_id)&&$post->category_id==$category->category_id)selected @endif >{{ $category->title }}</option>
            @endforeach
        </select>
    </div>
</div>

{{--<div class="layui-form-item">--}}
{{--    <label for="" class="layui-form-label">标签</label>--}}
{{--    <div class="layui-input-block">--}}
{{--        @foreach($tags as $tag)--}}
{{--            <input type="checkbox" name="tags[]" {{ $tag->checked??'' }} value="{{ $tag->id }}" title="{{ $tag->name }}">--}}
{{--        @endforeach--}}
{{--    </div>--}}
{{--</div>--}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">标题</label>
    <div class="layui-input-block">
        <input type="text" name="title" value="{{$post->title??old('title')}}" lay-verify="required" placeholder="请输入标题" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">关键词</label>
    <div class="layui-input-block">
        <input type="text" name="keywords" value="{{$post->keywords??old('keywords')}}" placeholder="请输入关键词" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">是否启用</label>
    <div class="layui-input-block">
        <select name="show_in_home">
            <option value="0" @if(isset($post->is_active)&&$post->is_active==0)selected @endif>否</option>
            <option value="1" @if(isset($post->is_active)&&$post->is_active==1)selected @endif>是</option>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">首页显示</label>
    <div class="layui-input-block">
        <select name="show_in_home">
            <option value="0" @if(isset($post->show_in_home)&&$post->show_in_home==0)selected @endif>否</option>
            <option value="1" @if(isset($post->show_in_home)&&$post->show_in_home==1)selected @endif>是</option>
        </select>
    </div>
</div>


{{--<div class="layui-form-item">--}}
{{--    <label for="" class="layui-form-label">描述</label>--}}
{{--    <div class="layui-input-block">--}}
{{--        <textarea name="description" placeholder="请输入描述" class="layui-textarea">{{$article->description??old('description')}}</textarea>--}}
{{--    </div>--}}
{{--</div>--}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">点击量</label>
    <div class="layui-input-block">
        <input type="number" name="click" value="{{$post->click??mt_rand(100,500)}}" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">缩略图</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn layui-btn-sm uploadPic"><i class="layui-icon">&#xe67c;</i>图片上传</button>
            <div class="layui-upload-list" >
                <ul class="layui-upload-box layui-clear">
                    @if(isset($post->featured_img) && $post->featured_img != '')
                        <li><img src="{{ $post->featured_img }}" /><p>上传成功</p></li>
                    @endif
                </ul>
                <input type="hidden" name="featured_img" class="layui-upload-input" value="{{ $post->featured_img??'' }}">
            </div>
        </div>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">短描述</label>
    <div class="layui-input-block">
        <textarea type="text" name="short_content" placeholder="短描述，可为空" class="layui-textarea" >{!! $post->short_content??old('short_content') !!}</textarea>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">内容</label>
    <div class="layui-input-block">
        <script id="container" name="content" type="text/plain" style="width: 98%">
            {!! $post->content??old('content') !!}
        </script>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">外链</label>
    <div class="layui-input-block">
        <input type="text" name="link" value="{{$post->link??''}}" placeholder="资讯外部链接，可为空" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a class="layui-btn" href="{{route('admin.blog.article')}}" >返 回</a>
    </div>
</div>
