@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>更新文章</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" method="post">
                {{csrf_field()}}
                <div class="layui-form-item">
                    <label for="" class="layui-form-label">编号ID</label>
                    <div class="layui-input-block">
                        <input type="text" name="id" value="{{$contact->id??old('id')}}" class="layui-input layui-disabled" disabled>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="" class="layui-form-label">名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="name" value="{{$contact->name??old('name')}}" class="layui-input" disabled>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="" class="layui-form-label">邮箱</label>
                    <div class="layui-input-block">
                        <input type="text" name="email" value="{{$contact->email??old('email')}}" class="layui-input" disabled>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="" class="layui-form-label">身份</label>
                    <div class="layui-input-block">
                        <select name="identity">
{{--                            <option value="0" @if(isset($post->show_in_home)&&$post->show_in_home==0)selected @endif>否</option>--}}
{{--                            <option value="1" @if(isset($post->show_in_home)&&$post->show_in_home==1)selected @endif>是</option>--}}
                        </select>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="" class="layui-form-label">大陆，州</label>
                    <div class="layui-input-block">
                        <input type="text" name="continent" value="{{$contact->continent??old('continent')}}" class="layui-input" disabled>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="" class="layui-form-label">联系意向</label>
                    <div class="layui-input-block">
                        <select name="remark_option" disabled>
                            <option value="0" @if(isset($contact->remark_option)&&$contact->remark_option==0)selected @endif>未选择</option>
                            <option value="1" @if(isset($contact->remark_option)&&$contact->remark_option==1)selected @endif>其他</option>
                            <option value="2" @if(isset($contact->remark_option)&&$contact->remark_option==2)selected @endif>我想了解产品</option>
                            <option value="3" @if(isset($contact->remark_option)&&$contact->remark_option==3)selected @endif>成为代理合作伙伴</option>
                            <option value="4" @if(isset($contact->remark_option)&&$contact->remark_option==4)selected @endif>项目合作</option>
                        </select>
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="" class="layui-form-label">留言备注</label>
                    <div class="layui-input-block">
                        <textarea type="text" name="remark" class="layui-textarea" disabled>{!! $contact->remark??old('remark') !!}</textarea>
                    </div>
                </div>

                <div class="layui-form-item">
                    <div class="layui-input-block">
{{--                        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>--}}
                        <a class="layui-btn" {{--href="{{route('admin.contact')}}"--}} onclick="goBack()">返 回</a>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection

<script>
    function goBack(){
        window.history.back()
    }
</script>
