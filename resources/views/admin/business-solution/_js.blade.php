<script>
    layui.use(['upload', 'layer', 'element', 'form'], function () {
        var $ = layui.jquery;
        var upload = layui.upload;

        //普通图片上传
        $(".uploadMedia").each(function (index, elem) {
            upload.render({
                elem: $(elem)
                , url: '{{ route("admin.upload.media") }}'
                , multiple: false
                , data: {"_token": "{{ csrf_token() }}"}
                , done: function (res) {
                    //如果上传失败
                    if (res.code == 0) {
                        layer.msg(res.msg, {icon: 1}, function () {
                            $(elem).parent('.layui-upload').find('.layui-upload-box').html('<li id="layer-picture" onclick="delMultipleImgs(this)"><img src="' + res.url + '" /><p>上传成功(单击删除)</p></li>');
                            $(elem).parent('.layui-upload').find('.layui-upload-input').val(res.url);
                        })
                    } else {
                        layer.msg(res.msg, {icon: 2})
                    }
                }
            });
        })

    })
    // layer.photos({
    //     photos: '#layer-picture'
    //     ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
    // });
    //单图删除操作
    function delMultipleImgs(obj) {
        obj.remove();
        $('#hidden-media').attr('value','');
        // var value = $('#hidden-media').attr('value');
        // console.log(value);
    }
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
    var ue1 = UM.getEditor('parameters');
</script>
