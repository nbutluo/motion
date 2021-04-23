<script>
    $(function(){
        // 查看: 图片
        $(document).on('click', '.chris-pic-check',function(){
            var url = $(this).attr('src');
            var info = '<img class="photo-move" src="'+ url +'" alt="" height="600px">';
            top.layer.open({
                type: 1,
                area: ['auto','auto'],
                anim: 5,
                closeBtn: 2,
                move: '.photo-move',
                shade: [0.2, '#000'],
                content: info,
                shadeClose: true,
                title: false,
                id: 101,
                success:function(){//细节处理
                    // $('.layui-layer-page').css({
                    //     "box-shadow":"0 0 0",
                    //     "background":"transparent",
                    // });
                    // $('.layui-layer-content').css({
                    //     "height":"auto",
                    //     'padding':'10px'
                    // })
                }
            });
        });
    })
</script>
