<script>
    layui.use(['upload', 'layer', 'element', 'form'], function () {
        var $ = layui.jquery;
        var upload = layui.upload;

        //普通图片上传
        $(".uploadMedia").each(function (index, elem) {
            upload.render({
                elem: $(elem)
                , url: '{{ route("admin.upload.media") }}'
                , accept: 'file'  // 视频等文件需要增加该参数
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
    }
</script>

<script>
    layui.extend({
        tinymce: '/layui-tinymce/layui_exts/tinymce/tinymce'
    }).use(['tinymce', 'util', 'layer'], function () {
        var tinymce = layui.tinymce
        var edit = tinymce.render({
            elem: "#container"
            , height: 600
            , width:'100%',
            convert_urls: false,
            images_upload_handler: function (blobInfo, success, failure, progress) {
                var xhr, formData;
                xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '{{route('admin.upload.blogImage')}}');
                xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                xhr.upload.onprogress = function(e){
                    progress(e.loaded / e.total * 100);
                }

                xhr.onload = function() {
                    var json;
                    if (xhr.status == 403) {
                        failure('HTTP Error: ' + xhr.status, { remove: true });
                        return;
                    }
                    if (xhr.status < 200 || xhr.status >= 300 ) {
                        failure('HTTP Error: ' + xhr.status);
                        return;
                    }
                    json = JSON.parse(xhr.responseText);
                    if (!json || typeof json.location != 'string') {
                        failure('Invalid JSON: ' + xhr.responseText);
                        return;
                    }
                    success(json.location);
                };

                xhr.onerror = function () {
                    failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
                }

                formData = new FormData();
                formData.append('edit', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
            }
        });
    });
</script>
