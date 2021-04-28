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
                    <label for="" class="layui-form-label">配置类型</label>
                    <div class="layui-input-inline">
                        <select name="system_name">
                            <option value="">---请选择---</option>
                                <option value="seo_default_keywords">seo_default_keywords</option>
                                <option value="seo_default_title">seo_default_title</option>
                                <option value="seo_default_description">seo_default_description</option>
                                <option value="seo_default_globle">seo_default_globle</option>
                                <option value="footer_phone">footer_phone</option>
                                <option value="footer_fax">footer_fax</option>
                                <option value="contact_us_email">contact_us_email</option>
                                <option value="contact_us_telephone">contact_us_telephone</option>
                                <option value="contact_us_base_infomation">contact_us_base_infomation</option>
                        </select>
                    </div>
                </div>

{{--                <div class="layui-form-item">--}}
{{--                    <label for="" class="layui-form-label">keywords</label>--}}
{{--                    <div class="layui-input-inline">--}}
{{--                        <input type="text" name="seo_default_keywords" value="" lay-verify="required" placeholder="请输入keywords关键字" class="layui-input" >--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="layui-form-item">--}}
{{--                    <label for="" class="layui-form-label">title</label>--}}
{{--                    <div class="layui-input-inline">--}}
{{--                        <input type="text" name="seo_default_title" value="" lay-verify="required" placeholder="请输入title信息" class="layui-input" >--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="layui-form-item">--}}
{{--                    <label for="" class="layui-form-label">description</label>--}}
{{--                    <div class="layui-input-inline">--}}
{{--                        <input type="text" name="seo_default_description" value="" lay-verify="required" placeholder="请输入description信息" class="layui-input" >--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div class="layui-form-item">
                    <label for="" class="layui-form-label"></label>
                    <div class="layui-input-inline">
                        <input type="text" name="value" required value="" placeholder="请输入数据" class="layui-input" >
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
