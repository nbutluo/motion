@extends('admin.base')

@section('content')
<div class="layui-card">
    <div class="layui-card-header layuiadmin-card-header-auto">
        <h2>新建首页banner</h2>
    </div>
    <div class="layui-card-body">
        <form class="layui-form" action="{{route('admin.homepage_banner.store')}}" method="post">
            @csrf
            @method('PUT')

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
                    <input type="text" name="banner_alt" value="{{old('banner_alt')}}" placeholder="请输入banner图片alt属性值"
                           class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="" class="layui-form-label">排序</label>
                <div class="layui-input-block">
                    <input type="number" name="order" value="{{old('order')}}" placeholder="请输入图片顺序" class="layui-input"
                           min="0">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="" class="layui-form-label">链接地址</label>
                <div class="layui-input-block">
                    <input type="text" name="link_url" value="{{old('link_url')}}" placeholder="跳转链接"
                           class="layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="" class="layui-form-label">是否启用</label>
                <div class="layui-input-block">
                    <select name="is_active">
                        <option value="0">否</option>
                        <option value="1">是</option>
                    </select>
                </div>
            </div>

            <div class="layui-form-item">
                <label for="" class="layui-form-label">描述</label>
                <div class="layui-input-block">
                    <input type="text" name="description" value="{{old('description')}}" placeholder="请输入描述"
                           class="layui-input">
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
    });

    var cupload = new Cupload({
        ele: "#media_url_mobile",
        name: 'media_url_mobile',
        num:1,
        maxWidth:375,
    });
</script>

@include('admin.banner._js')
@endsection
