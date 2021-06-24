{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">类型</label>
    <div class="layui-input-block">
        <select name="category_type">
            <option value="1" @if(isset($solution->category_type)&&$solution->category_type==1)selected @endif>Home Solutions</option>
            <option value="2" @if(isset($solution->category_type)&&$solution->category_type==2)selected @endif>Office Solution</option>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">标题</label>
    <div class="layui-input-block">
        <input type="text" name="title" value="{{$solution->title??old('title')}}" lay-verify="required" placeholder="请输入标题" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">资源类型</label>
    <div class="layui-input-block">
        <select name="media_type">
            <option value="1" @if(isset($solution->media_type)&&$solution->media_type==1)selected @endif>视频</option>
            <option value="2" @if(isset($solution->media_type)&&$solution->media_type==2)selected @endif>图片</option>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">solution资源</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn layui-btn-sm uploadMedia"><i class="layui-icon">&#xe67c;</i>资源上传</button>
            <div class="layui-upload-list">
                <ul class="layui-upload-box layui-clear">
                    @if(isset($solution->media_link))
                        <li id="layer-picture" onclick="delMultipleImgs(this)"><img src="{{ $solution->media_link }}" /><p>点击删除</p></li>
                    @endif
                </ul>
                <input type="hidden" name="media_link" id="hidden-media" class="layui-upload-input" value="{{ $solution->media_link??'' }}">
            </div>
        </div>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">solution alt</label>
    <div class="layui-input-block">
        <input type="text" name="media_alt" value="{{$solution->media_alt??old('media_alt')}}" placeholder="请输alt值(上传图片时需要填写)" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">solution内容</label>
    <div class="layui-input-block">
        <textarea name="content" id="container" cols="30" rows="10">{{$solution->content??old('content')}}</textarea>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">是否启用</label>
    <div class="layui-input-block">
        <select name="is_active">
            <option value="0" @if(isset($solution->is_active)&&$solution->is_active==0)selected @endif>否</option>
            <option value="1" @if(isset($solution->is_active)&&$solution->is_active==1)selected @endif>是</option>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">权重</label>
    <div class="layui-input-block">
        <input type="text" name="position" value="{{$solution->position??old('position')}}" placeholder="请输入权重值" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a class="layui-btn" href="{{route('admin.solution.index')}}" >返 回</a>
    </div>
</div>
