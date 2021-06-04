<script>
    layui.use(['upload', 'layer', 'element', 'form'], function () {
        var $ = layui.jquery;
        var upload = layui.upload;

        //普通图片上传
        $(".uploadPic").each(function (index, elem) {
            upload.render({
                elem: $(elem)
                , url: '{{ route("admin.upload.media") }}'
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
        //多图片上传
        upload.render({
            elem: '#images'
            ,url: '{{route('admin.upload.media')}}' //改成您自己的上传接口
            ,multiple: true
            , data: {"_token": "{{ csrf_token() }}"}
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    // $('#images_show').append('<img src="'+ result +'" alt="'+ file.name +'" class="layui-upload-img" title="单击删除" onclick="delMultipleImgs(this)">');
                });
            }
            ,done: function(res){
                //上传完毕
                // console.log(res);
                $('#images_show').append('<div onclick="delMultipleImgs(this)"><img style="float:left;" src="'+ res.url +'" id="'+res.url+'" alt="'+ res.url +'" class="layui-upload-img" title="单击删除"><input type="hidden" name="media_url[]" id="'+res.url+'" value="'+ res.url +'"></div>');
            }
        });
    })
    /**
     * 多图清除按钮点击事件
     */
    $("#btn_image_clear").click(function () {
        $('#images_show').html("");
        $(".upload_image_url").val('');
    });
    //单图删除操作
    function delMultipleImgs(obj) {
        obj.remove();
    }
    layer.photos({
        photos: '#layer-picture'
        ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
    });
</script>
