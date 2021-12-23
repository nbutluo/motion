@extends('admin.base')

@section('content')
<div class="layui-card">
    <div class="layui-card-header layuiadmin-card-header-auto">
        <h2>首页banner更新</h2>
    </div>
    <div class="layui-card-body">
        <form class="layui-form" action="{{route('admin.homepage_banner.update',$banner->id)}}" method="post">
            @csrf
            @method('PATCH')

            <div class="layui-form-item">
                <label for="" class="layui-form-label">PC端banner</label>
                <div class="layui-input-block">
                    <div id="media_url_pc"></div>
                </div>
            </div>

            <div class="layui-form-item">
                <label for="" class="layui-form-label">手机端banner</label>
                <div class="layui-input-block">
                    <div id="media_url_mobile"></div>
                </div>
            </div>

            <div class="layui-form-item">
                <label for="" class="layui-form-label">图片alt</label>
                <div class="layui-input-block">
                    <input type="text" name="banner_alt" value="{{$banner->banner_alt??old('banner_alt')}}"
                           placeholder="请输入banner图片alt属性值" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="" class="layui-form-label">排序</label>
                <div class="layui-input-block">
                    <input type="number" name="order" value="{{$banner->order??old('order')}}" placeholder="请输入图片顺序"
                           class="layui-input" min="0">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="" class="layui-form-label">链接地址</label>
                <div class="layui-input-block">
                    <input type="text" name="link_url" placeholder="跳转链接" value="{{$banner->link_url??old('link_url')}}"
                           class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="" class="layui-form-label">是否启用</label>
                <div class="layui-input-block">
                    <select name="is_active">
                        <option value="0" @if(isset($banner->is_active)&&$banner->is_active==0)selected @endif>否
                        </option>
                        <option value="1" @if(isset($banner->is_active)&&$banner->is_active==1)selected @endif>是
                        </option>
                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <label for="" class="layui-form-label">描述</label>
                <div class="layui-input-block">
                    <input type="text" name="description" value="{{$banner->description??old('description')}}"
                           placeholder="请输入描述" class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <div class="layui-input-block">
                    <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
                    <a class="layui-btn" href="{{route('admin.homepage_banner')}}">返 回</a>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    var cupload = new Cupload({
        ele: "#media_url_pc",
        name: 'media_url_pc',
        num:1,
        maxWidth:1920,
        data: ["{{ $banner->media_url_pc }}"],
    });

    var cupload = new Cupload({
        ele: "#media_url_mobile",
        name: 'media_url_mobile',
        num:1,
        maxWidth:375,
        data: ["{{ $banner->media_url_mobile }}"],
    });
</script>

@include('admin.banner._js')
@endsection
