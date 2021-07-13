{{csrf_field()}}
<div class="layui-form-item">
    <label for="" class="layui-form-label">标题</label>
    <div class="layui-input-block">
        <input type="text" name="name" value="{{$siteMap->name??old('name')}}" placeholder="请输入类型" class="layui-input" disabled>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">url_key</label>
    <div class="layui-input-block">
        <input type="text" name="url" value="{{$siteMap->url??old('url')}}" placeholder="请输入新的url_key" class="layui-input" @if (isset($siteMap->name) && $siteMap->name != '产品详情') disabled @endif>
    </div>
</div><div class="layui-form-item">
    <label for="" class="layui-form-label">源链接</label>
    <div class="layui-input-block">
        <input type="text" name="origin" value="{{$siteMap->origin??old('origin')}}" placeholder="请输入类型" class="layui-input" disabled>
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo" @if (isset($siteMap->name) && $siteMap->name != '产品详情') style="display: none;" @endif>确 认</button>
        <a class="layui-btn" href="{{route('admin.site.map.index')}}" >返 回</a>
    </div>
</div>
