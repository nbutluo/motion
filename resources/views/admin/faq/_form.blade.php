{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">分类</label>
    <div class="layui-input-inline">
        <select name="category_id">
            <option value="0"></option>
{{--            @foreach($categories as $category)--}}
{{--                <option value="{{ $category->category_id }}" @if(isset($post->category_id)&&$post->category_id==$category->category_id)selected @endif >{{ $category->title }}</option>--}}
{{--            @endforeach--}}
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">标题</label>
    <div class="layui-input-block">
        <input type="text" name="title" value="{{$post->title??old('title')}}" lay-verify="required" placeholder="请输入标题" class="layui-input" >
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
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a class="layui-btn" href="{{route('admin.faq.info')}}" >返 回</a>
    </div>
</div>
