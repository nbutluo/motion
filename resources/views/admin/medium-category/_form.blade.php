{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">资源类型</label>
    <div class="layui-input-inline">
        <select name="media_type">
            <option value="0">未选择</option>
            @foreach($media_type as $category)
                <option value="{{ $category->id }}" @if(isset($mediumCategory->media_type)&&$mediumCategory->media_type==$category->id)selected @endif >{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">资源分类</label>
    <div class="layui-input-inline">
        <select name="category_parent_id">
            <option value="0">未选择</option>
            @foreach($categories as $category)
                <option value="{{ $category['id'] }}" @if(isset($mediumCategory->parent_id)&&$mediumCategory->parent_id==$category['id'])selected @endif >{{ $category['title'] }}</option>
            @if (isset($category['children']) && !empty($category['children']))
                    @foreach($category['children'] as $firstCategory)
                        <option value="{{ $firstCategory['id'] }}" @if(isset($mediumCategory->parent_id)&&$mediumCategory->parent_id==$firstCategory['id'])selected @endif >-----{{ $firstCategory['title'] }}</option>
                        @if (isset($firstCategory['children']) && !empty($firstCategory['children']))
                            @foreach($firstCategory['children'] as $secondCategory)
                                <option value="{{ $secondCategory['id'] }}" disabled >----------{{ $secondCategory['title'] }}</option>
                            @endforeach
                        @endif
                    @endforeach
            @endif
            @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">分类名称</label>
    <div class="layui-input-block">
        <input type="text" name="category_name" value="{{$mediumCategory->name??old('name')}}" lay-verify="required" placeholder="请输入分类名" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">是否启用</label>
    <div class="layui-input-block">
        <select name="is_active">
            <option value="0" @if(isset($mediumCategory->is_active)&&$mediumCategory->is_active==0)selected @endif>否</option>
            <option value="1" @if(isset($mediumCategory->is_active)&&$mediumCategory->is_active==1)selected @endif>是</option>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a class="layui-btn" href="{{route('admin.medium.category.index')}}" >返 回</a>
    </div>
</div>
