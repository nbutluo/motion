@extends('admin.base')

@section('content')
    <style>
        .layui-form-label {
            width: 100px;
        }
    </style>
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加seo</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.website_seo.store')}}" method="post">
                {{csrf_field()}}
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">keywords</label>
                    <div class="layui-input-inline">
                        <input type="text" name="seo_default_keywords" value="" lay-verify="required" placeholder="请输入keywords关键字" class="layui-input" >
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">title</label>
                    <div class="layui-input-inline">
                        <input type="text" name="seo_default_title" value="" lay-verify="required" placeholder="请输入title信息" class="layui-input" >
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">description</label>
                    <div class="layui-input-inline">
                        <input type="text" name="seo_default_description" value="" lay-verify="required" placeholder="请输入description信息" class="layui-input" >
                    </div>
                </div>
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">global class key</label>
                    <div class="layui-input-inline">
                        <input type="text" name="seo_default_globle" value="" placeholder="请输入全局clas前缀(可为空)" class="layui-input" >
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
                        <a  class="layui-btn" href="{{route('admin.website_seo')}}" >返 回</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        layui.use(['element','form'],function () {

        })
    </script>
@endsection
