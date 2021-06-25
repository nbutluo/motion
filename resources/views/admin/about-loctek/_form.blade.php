{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">标题</label>
    <div class="layui-input-block">
        <input type="text" name="title" value="{{$loctek->title??old('title')}}" lay-verify="required" placeholder="请输入标题" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">类型</label>
    <div class="layui-input-block">
        <select name="type">
            <option value="2" @if(isset($loctek->type)&&$loctek->type==2)selected @endif>展示信息</option>
            <option value="1" @if(isset($loctek->type)&&$loctek->type==1)selected @endif>页面信息</option>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">aboutLoctek资源</label>
    <div class="layui-input-block">
        <div class="layui-upload">
            <button type="button" class="layui-btn layui-btn-sm uploadMedia"><i class="layui-icon">&#xe67c;</i>资源上传</button>
            <div class="layui-upload-list">
                <ul class="layui-upload-box layui-clear">
                    @if(isset($loctek->media_link))
                        <li id="layer-picture" onclick="delMultipleImgs(this)"><img src="{{ $loctek->media_link }}" /><p>点击删除</p></li>
                    @endif
                </ul>
                <input type="hidden" name="media_link" id="hidden-media" class="layui-upload-input" value="{{ $loctek->media_link??'' }}">
            </div>
        </div>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">资源类型</label>
    <div class="layui-input-block">
        <select name="media_type">
            <option value="1" @if(isset($loctek->media_type)&&$loctek->media_type==1)selected @endif>图片</option>
            <option value="2" @if(isset($loctek->media_type)&&$loctek->media_type==2)selected @endif>视频</option>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">alt属性</label>
    <div class="layui-input-block">
        <input type="text" name="media_lable" value="{{$loctek->media_lable??old('media_lable')}}" placeholder="请输入alt属性" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">内容</label>
    <div class="layui-input-block">
        <textarea name="content" id="container" cols="30" rows="10">{{$loctek->content??old('content')}}</textarea>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">是否启用</label>
    <div class="layui-input-block">
        <select name="is_active">
            <option value="0" @if(isset($loctek->is_active)&&$loctek->is_active==0)selected @endif>否</option>
            <option value="1" @if(isset($loctek->is_active)&&$loctek->is_active==1)selected @endif>是</option>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">权重</label>
    <div class="layui-input-block">
        <input type="text" name="position" value="{{$loctek->position??old('position')}}" placeholder="请输入权重值" class="layui-input" >
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a class="layui-btn" href="{{route('admin.about.loctek.index')}}" >返 回</a>
    </div>
</div>
