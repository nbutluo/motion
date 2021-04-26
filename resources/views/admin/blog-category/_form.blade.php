{{csrf_field()}}
{{--<div class="layui-form-item">--}}
{{--    <label for="" class="layui-form-label">上级分类</label>--}}
{{--    <div class="layui-input-inline">--}}
{{--        <select name="parent_id" lay-search  lay-filter="parent_id">--}}
{{--            <option value="0">分类名称</option>--}}
{{--            @foreach($categories as $first)--}}
{{--                <option value="{{ $first->id }}" @if(isset($category->parent_id)&&$category->parent_id==$first->id) selected @endif>{{ $first->name }}</option>--}}
{{--                @if($first->childs->isNotEmpty())--}}
{{--                    @foreach($first->childs as $second)--}}
{{--                        <option value="{{ $second->id }}" {{ isset($category->id) && $category->parent_id==$second->id ? 'selected' : '' }}>┗━━{{$second->name}}</option>--}}
{{--                    @endforeach--}}
{{--                @endif--}}
{{--            @endforeach--}}
{{--        </select>--}}
{{--    </div>--}}
{{--</div>--}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">名称</label>
    <div class="layui-input-inline">
        <input type="text" name="title" value="{{ $category->title ?? old('title') }}" lay-verify="required" placeholder="请输入名称" class="layui-input" >
    </div>
</div>
<div class="layui-form-item">
    <label for="" class="layui-form-label">排序</label>
    <div class="layui-input-inline">
        <input type="number" name="position" value="{{ $category->position ?? 10 }}" lay-verify="required|number" placeholder="请输入数字" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">分类关键词</label>
    <div class="layui-input-inline">
        <input type="text" name="keywords" value="{{ $category->keywords ?? '' }}" placeholder="请输入分类关键词" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">是否启用</label>
    <div class="layui-input-inline">
        <select name="is_active">
            <option value="0" @if(isset($post->is_active)&&$post->is_active==0)selected @endif>否</option>
            <option value="1" @if(isset($post->is_active)&&$post->is_active==1)selected @endif>是</option>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a  class="layui-btn" href="{{route('admin.blog.category')}}" >返 回</a>
    </div>
</div>
