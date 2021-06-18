{{--<link href="/editor/themes/default/css/umeditor.min.css" type="text/css" rel="stylesheet">--}}
{{--<script src="/editor/third-party/jquery.min.js"></script>--}}
{{--<!-- 配置文件 -->--}}
{{--<script type="text/javascript" src="/editor/umeditor.config.js"></script>--}}
{{--<!-- 编辑器源码文件 -->--}}
{{--<script type="text/javascript" src="/editor/umeditor.min.js"></script>--}}
{{--<!-- 实例化编辑器 -->--}}
{{--<script type="text/javascript">--}}
{{--    var ue = UM.getEditor('container');--}}
{{--</script>--}}

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
