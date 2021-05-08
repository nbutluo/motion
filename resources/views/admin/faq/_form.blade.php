{{csrf_field()}}
{{--<div class="layui-form-item">--}}
{{--    <label for="" class="layui-form-label">范围</label>--}}
{{--    <div class="layui-input-inline" id="scope" style="width:300px;">--}}
{{--        <input type="radio" name="scope" lay-filter= "questiontype" value="0" title="所有" checked>--}}
{{--        <input type="radio" name="scope" lay-filter= "questiontype" value="1" title="指定分类">--}}
{{--        <input type="radio" name="scope" lay-filter= "questiontype" value="2" title="指定产品">--}}
{{--    </div>--}}
{{--</div>--}}
<input type="hidden" name="user_id" value="{{auth()->user()->id}}">
<div class="layui-form-item">
    <label for="" class="layui-form-label">所属分类</label>
    <div class="layui-input-inline">
        <select name="category_id">
            <option value="0">all</option>
            @foreach($categories as $cate)
                <option value="{{$cate->id}}" @if(isset($question->id)&&$question->category_id==$cate->id)selected @endif>@if($cate->level ==2)  ----@endif{{$cate->name}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">所属产品</label>
    <div class="layui-input-inline">
        <select name="product_id">
            <option value="0">all</option>
            @foreach($products as $pro)
                <option value="{{$pro->id}}" @if (isset($question->id)&&$question->product_id==$pro->id)
                    selected
                @endif>{{$pro->name}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">是否启用</label>
    <div class="layui-input-block">
        <select name="is_active">
            <option value="0" @if(isset($question->is_active)&&$question->is_active==0)selected @endif>否</option>
            <option value="1" @if(isset($question->is_active)&&$question->is_active==1)selected @endif>是</option>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">标题</label>
    <div class="layui-input-block">
        <input type="text" name="title" value="{{$question->title??old('title')}}" lay-verify="required" placeholder="请输入标题" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">短描述</label>
    <div class="layui-input-block">
        <textarea type="text" name="short_content" placeholder="短描述，可为空" class="layui-textarea" >{!! $question->short_content??old('short_content') !!}</textarea>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">内容</label>
    <div class="layui-input-block">
        <script id="container" name="content" type="text/plain" style="width: 98%">
            {!! $question->content??old('content') !!}
        </script>
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a class="layui-btn" href="{{route('admin.faq.info')}}" >返 回</a>
    </div>
</div>
