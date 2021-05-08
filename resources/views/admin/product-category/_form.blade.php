{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">分类名称</label>
    <div class="layui-input-block">
        <input type="text" name="name" value="{{$category->name??old('name')}}" lay-verify="required" placeholder="请输入产品分类名称" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">描述</label>
    <div class="layui-input-block">
        <input type="text" name="description" value="{{$category->description??old('description')}}" lay-verify="required" placeholder="请输入产品分类描述" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">上级分类</label>
    <div class="layui-input-block">
        <select name="parent_id" id="">
            @if (isset($categories))
                <option value="0">一级分类</option>
                @foreach ($categories as $cate)
                    <option value="{{$cate->id}}" @if (isset($category->id) && $category->parent_id==$cate->id)
                        selected
                    @endif>{{$cate->name}}</option>
                @endforeach
            @endif

        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">是否启用</label>
    <div class="layui-input-block">
        <select name="is_active">
            <option value="0" @if(isset($category->is_active)&&$category->is_active==0)selected @endif>否</option>
            <option value="1" @if(isset($category->is_active)&&$category->is_active==1)selected @endif>是</option>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">位置权重</label>
    <div class="layui-input-block">
        <input type="text" name="position" value="{{$category->position??old('position')}}" lay-verify="number" placeholder="请输入数字(值越大越靠后)" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a class="layui-btn" href="{{route('admin.catalog.category')}}" >返 回</a>
    </div>
</div>
