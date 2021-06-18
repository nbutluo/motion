
<script>
    layui.use(['upload','layer','element','form','transfer', 'util'],function () {
        var $ = layui.jquery;
        var upload = layui.upload;
        var transfer = layui.transfer;
        var layer = layui.layer;
        var util = layui.util;

        //获取blog数据列表
        var blogData = getBlogData();
        function getBlogData(){
            var result = '';
            $.ajax({
                type:"post",
                dataType:"json",
                url:'{{route("admin.blog.relate.list")}}',
                data:{"_token": "{{ csrf_token() }}",'blog_id':{{(isset($post->post_id)) ? $post->post_id : 0}} },
                cache: false,
                async: false,
                success:function(data){
                    result = data;
                },
            });
            return result;
        }
        //关联blog
        transfer.render({
            elem: '#blog-list'
            ,data: blogData
            ,id: 'beSelect'
            ,title: ['blog列表', '已选blog']
            ,showSearch: true,
            parseData :function (productData) {
                return {
                    'value':productData.value,
                    'title':productData.title,
                    'checked':productData.checked,
                    'disabled':productData.disabled,
                }
            },
            onchange:function (productData,index) {
                console.log(productData);
                console.log(index);
                $.each(productData,function (i,n) {
                    if (index == 0) {
                        $("#blog-list").append('<input type="hidden" id="relate_id_'+n['value']+'" name="relate_id[]" value="'+n['value']+'">');
                    } else {
                        $("#relate_id_"+n['value']).remove();
                    }
                });
            }
        })

        //普通图片上传
        $(".uploadPic").each(function (index,elem) {
            upload.render({
                elem: $(elem)
                ,url: '{{ route("admin.upload") }}'
                ,multiple: false
                ,data:{"_token":"{{ csrf_token() }}"}
                ,done: function(res){
                    //如果上传失败
                    if(res.code == 0){
                        layer.msg(res.msg,{icon:1},function () {
                            $(elem).parent('.layui-upload').find('.layui-upload-box').html('<li><img src="'+res.url+'" /><p>上传成功</p></li>');
                            $(elem).parent('.layui-upload').find('.layui-upload-input').val(res.url);
                        })
                    }else {
                        layer.msg(res.msg,{icon:2})
                    }
                }
            });
        })

    })
</script>
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
