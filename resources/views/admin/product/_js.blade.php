<script>
    layui.use(['transfer', 'layer', 'util'], function(){
        var $ = layui.$
            ,transfer = layui.transfer
            ,layer = layui.layer
            ,util = layui.util;
    });

    layui.use(['upload', 'layer', 'element', 'form','transfer', 'util'], function () {
        var $ = layui.jquery;
        var upload = layui.upload;
        var transfer = layui.transfer;
        var layer = layui.layer;
        var util = layui.util;
        // var data1 = [
        //     {"value": "1", "title": "李白"}
        //     ,{"value": "2", "title": "杜甫"}
        //     ,{"value": "4", "title": "李清照",'checked':'checked'}
        //     ,{"value": "5", "title": "鲁迅", "disabled": true}
        // ]
        var productData = getProductData();
        function getProductData(){
            var result = '';
            $.ajax({
                type:"post",
                dataType:"json",
                url:'{{route("admin.catalog.product.relate.list")}}',
                data:{"_token": "{{ csrf_token() }}",'product_id':{{(isset($product->id)) ? $product->id : 0}} },
                cache: false,
                async: false,
                success:function(data){
                    result = data;
                },
            });
            return result;
        }
        //关联产品
        transfer.render({
            elem: '#product-list'
            ,data: productData
            ,id: 'beSelect'
            ,title: ['产品列表', '已选产品']
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
                        $("#product-list").append('<input type="hidden" id="relate_id_'+n['value']+'" name="relate_id[]" value="'+n['value']+'">');
                    } else {
                        $("#relate_id_"+n['value']).remove();
                    }
                });
            }
        })


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

        //多图片上传
        upload.render({
            elem: '#images'
            ,url: '{{route('admin.upload')}}' //改成您自己的上传接口
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
                console.log(res);
                $('#images_show').append('<div onclick="delMultipleImgs(this)"><img width="220" height="220" style="float:left;" src="'+ res.url +'" id="'+res.url+'" alt="'+ res.url +'" class="layui-upload-img" title="单击删除"><input type="hidden" name="images[]" id="'+res.url+'" value="'+ res.url +'"></div>');
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
