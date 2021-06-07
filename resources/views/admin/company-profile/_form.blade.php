{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">标题</label>
    <div class="layui-input-block">
        <input type="text" name="title" value="{{$profile->title??old('title')}}" lay-verify="required" placeholder="请输入标题" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">profile资源</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn layui-btn-sm uploadMedia"><i class="layui-icon">&#xe67c;</i>资源上传</button>
            <div class="layui-upload-list">
                <ul class="layui-upload-box layui-clear">
                    @if(isset($profile->media_link))
                        <li id="layer-picture" onclick="delMultipleImgs(this)"><img src="{{ $profile->media_link }}" /><p>点击删除</p></li>
                    @endif
                </ul>
                <input type="hidden" name="media_link" id="hidden-media" class="layui-upload-input" value="{{ $profile->media_link??'' }}">
            </div>
        </div>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">内容</label>
    <div class="layui-input-block">
        <script id="container" name="content" type="text/plain" style="width: 98%">
            {!! $profile->content??old('content') !!}
        </script>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">是否启用</label>
    <div class="layui-input-block">
        <select name="is_active">
            <option value="0" @if(isset($profile->is_active)&&$profile->is_active==0)selected @endif>否</option>
            <option value="1" @if(isset($profile->is_active)&&$profile->is_active==1)selected @endif>是</option>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">权重</label>
    <div class="layui-input-block">
        <input type="text" name="position" value="{{$profile->position??old('position')}}" placeholder="请输入权重值" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a class="layui-btn" href="{{route('admin.company.profile.index')}}" >返 回</a>
    </div>
</div>
