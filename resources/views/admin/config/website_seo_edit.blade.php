@extends('admin.base')

@section('content')
    <style>
        .layui-form-label {
            width: 150px;
        }
    </style>
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>编辑seo</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.website_seo.update',['id'=>$seo->id])}}" method="post">
                {{csrf_field()}}
                {{method_field('put')}}
                <input type="hidden" name="id" value="{{$seo->id}}">
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">{{$seo->identifier}}</label>
                    <div class="layui-input-inline">
                        <input class="layui-input" type="text" name="value" lay-verify="required" value="{{$seo->value??old('value')}}">
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
