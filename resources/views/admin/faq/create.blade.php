@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加答疑</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.faq.add')}}" method="post" >
                @include('admin.faq._form')
            </form>
        </div>
    </div>
@endsection

@section('script')
    @include('admin.faq._js')

{{--    <script language="javascript" runat="server">--}}
{{--        layui.use(['table','form','element'],function () {--}}
{{--            var $ = layui.$, form = layui.form, table = layui.table;--}}
{{--            form.on("radio(questiontype)",function (data) {--}}
{{--                var type = data.value;--}}
{{--                if(type == 0) {--}}

{{--                } else if (type == 1) {--}}
{{--                    $.post("{{route('admin.faq.getData')}}",headers: {'XSRF-TOKEN': $('meta[name="_token"]').attr('content')},function (msg) {--}}

{{--                        var optionstring = '';--}}
{{--                        $.each(msg,function (i,item) {--}}
{{--                            optionstring += "<option value=\"" + item.id + "\">" + item.name + "</option>"--}}
{{--                        });--}}
{{--                        $("#goal").html('<option value=""></option>' + optionstring);--}}
{{--                        form.render(select);--}}
{{--                    });--}}
{{--                } else if (type == 2) {--}}

{{--                }--}}
{{--            })--}}
{{--        })--}}
{{--    </script>--}}

@endsection
