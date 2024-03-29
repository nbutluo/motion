<script>
    layui.use(['upload', 'layer', 'element', 'form'], function () {
        var $ = layui.jquery;
        var upload = layui.upload;

        //普通图片上传
        $(".uploadPic").each(function (index, elem) {
            upload.render({
                elem: $(elem)
                , url: '{{ route("admin.upload") }}'
                , multiple: false
                , data: {"_token": "{{ csrf_token() }}"}
                , done: function (res) {
                    //如果上传失败
                    if (res.code == 0) {
                        layer.msg(res.msg, {icon: 1}, function () {
                            $(elem).parent('.layui-upload').find('.layui-upload-box').html('<li><img src="' + res.url + '" /><p>上传成功</p></li>');
                            $(elem).parent('.layui-upload').find('.layui-upload-input').val(res.url);
                        })
                    } else {
                        layer.msg(res.msg, {icon: 2})
                    }
                }
            });
        })

    })
    layui.use('colorpicker',function () {
        var $ = layui.$
            ,colorpicker = layui.colorpicker;
        //表单赋值
        colorpicker.render({
            elem: '#test-form'
            ,color: '#1c97f5'
            ,done: function(color){
                $('#test-form-input').val(color);
            }
        });
    });
</script>
<link href="/editor/themes/default/css/umeditor.min.css" type="text/css" rel="stylesheet">
<script src="/editor/third-party/jquery.min.js"></script>
<!-- 配置文件 -->
<script type="text/javascript" src="/editor/umeditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="/editor/umeditor.min.js"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
    var ue = UM.getEditor('container');
    // var ue1 = UM.getEditor('container1');
</script>
