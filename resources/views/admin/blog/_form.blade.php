{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">分类</label>
    <div class="layui-input-inline">
        <select name="category_id">
            <option value="0"></option>
            @foreach($categories as $category)
            <option value="{{ $category->category_id }}" @if(isset($post->
                category_id)&&$post->category_id==$category->category_id)selected @endif >{{ $category->title }}
            </option>
            @endforeach
        </select>
    </div>
</div>

{{--<div class="layui-form-item">--}}
    {{-- <label for="" class="layui-form-label">标签</label>--}}
    {{-- <div class="layui-input-block">--}}
        {{-- @foreach($tags as $tag)--}}
        {{-- <input type="checkbox" name="tags[]" {{ $tag->checked??'' }} value="{{ $tag->id }}" title="{{ $tag->name
        }}">--}}
        {{-- @endforeach--}}
        {{-- </div>--}}
    {{--</div>--}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">标题</label>
    <div class="layui-input-block">
        <input type="text" name="title" value="{{$post->title??old('title')}}" placeholder="请输入标题" class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">关键词</label>
    <div class="layui-input-block">
        <input type="text" name="keywords" value="{{$post->keywords??old('keywords')}}" placeholder="请输入关键词"
               class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">是否启用</label>
    <div class="layui-input-block">
        <select name="is_active">
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
    {{-- <label for="" class="layui-form-label">描述</label>--}}
    {{-- <div class="layui-input-block">--}}
        {{-- <textarea name="description" placeholder="请输入描述"
                  class="layui-textarea">{{$article->description??old('description')}}</textarea>--}}
        {{-- </div>--}}
    {{--</div>--}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">点击量</label>
    <div class="layui-input-block">
        <input type="number" name="click" value="{{$post->click??mt_rand(100,500)}}" class="layui-input">
    </div>
</div>

@isset($post)
<div class="layui-form-item">
    <label for="" class="layui-form-label">meta_title</label>
    <div class="layui-input-block layui-sm">
        <input type="text" name="meta_title" value="{{$post->meta_title ?? ''}}" class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">meta_desc</label>
    <div class="layui-input-block">
        <textarea type="text" name="meta_description"
                  class="layui-textarea">{!! $post->meta_description??old('meta_description') !!}</textarea>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">meta_keyword</label>
    <div class="layui-input-block">
        <input type="text" name="meta_keywords" value="{{$post->meta_keywords??old('meta_keywords')}}"
               class="layui-input">
    </div>
</div>
@endisset

<div class="layui-form-item">
    <label for="" class="layui-form-label">缩略图Alt</label>
    <div class="layui-input-block layui-sm">
        <input type="text" name="featured_img_alt" value="{{$post->featured_img_alt ?? ''}}" class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">缩略图</label>
    <div class="layui-input-block">
        <div id="featured_img"></div>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">blog关联</label>
    <div id="blog-list" class="demo-transfer"></div>
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 30px;">
    </fieldset>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">短描述</label>
    <div class="layui-input-block">
        <textarea type="text" name="short_content" placeholder="短描述，可为空"
                  class="layui-textarea">{!! $post->short_content??old('short_content') !!}</textarea>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">内容</label>
    <div class="layui-input-block">
        <textarea name="content" id="container" cols="30" rows="10">{{$post->content??old('content')}}</textarea>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">外链</label>
    <div class="layui-input-block">
        <input type="text" name="link" value="{{$post->link??''}}" placeholder="资讯外部链接，可为空" class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a class="layui-btn" href="{{route('admin.blog.article')}}">返 回</a>
    </div>
</div>

<script type="text/javascript">
    var cupload = new Cupload({
        ele: "#featured_img",
        name: 'featured_img',
        @isset($post->featured_img)
        data: "{{ $post->featured_img }}".split(';'),
        @endisset
    });
</script>
