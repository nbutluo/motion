# layui-tinymce

[在线预览](http://chick1993.gitee.io/layui-tinymce/) | [Layui论坛](https://fly.layui.com/jie/63668/) | [tinymce中文文档](http://tinymce.ax-z.cn/)
## 更新
2021.01.04 tinymce更新到5.6.2  
2020.11.06 tinymce更新到5.5.1，上传图片时支持自定义字段名、支持同时上传其他数据<br>
2020.08.24 tinymce更新到5.4.2
## 食用

食用方式可参考tinymce官方文档

### 引入编辑器
```
layui.extend({
    tinymce: '{/}./tinymce/tinymce'
}).use(['tinymce'], function () {
    var t = layui.tinymce
    // code ...
    // 后面无特殊说明，其它代码均写在此处
    // ...
})
```
### 基础方法
#### 创建 t.render(option，load_callback)
```
<textarea id="edit"></textarea>

t.render({
    elem: "#edit"  
    // 支持tinymce所有配置      
},(opt, edit)=>{
    // 加载完成后回调 opt 是传入的所有参数
    // edit是当前编辑器实例，等同于t.get返回值
});

```

#### 重载 t.reload(option，load_callback)
```
// 方式一
t.reload({
    elem:'#edit'
    // 除elem外，所有参数都可以重新设置
},(opt, edit) => {
    //重载完成后回调函数，会把所有参数回传，
    //重载仅仅重新渲染编辑器，不会清空textarea
})

// 方式二
t.reload('#edit',{
    // 除elem外，所有参数都可以重新设置
},(opt, edit) => {

})
```

#### 编辑器实例 t.get(id)
```
// 如果页面只有一个编辑器，等同于官方的tinymce.activeEditor
// 如果页面有多个编辑器，等同于官方tinymce.editors[id]
var edit = t.get('#edit')
```
#### 获取内容 edit.getContent(option)
```
// 获取编辑器HTML内容
edit.getContent()
// 获取编辑器文本内容
edit.getContent({format:'text'})
```

#### 插入内容 edit.insertContent(html)
```
edit.insertContent('<b>插入内容</b>')
```

#### 设置内容 edit.setContent(html)
```
edit.setContent('<b>设置内容</b>')

// 清空编辑器，将内容设置为空字符串即可
edit.setContent('')
```

#### 清空内容
```
edit.resetContent()
```

#### 销毁 edit.destroy() 
```
edit.destroy() 
```

### 图片上传
#### 配置上传接口
##### 全局修改 layui_exts\tinymce\tinymce.js
```
var settings = {
    images_upload_url:'http(s)://yoursite/apipath'
    // ...
}
```
##### 初始化时传入
``` 
t.render({
    images_upload_url:'http(s)://yoursite/apipath'
    // ...
})
```
#### 默认上传
```
// 上传配置
t.render({
    elem: "#edit"  
    ,images_upload_url:'http(s)://yoursite/apipath'//配置上传接口
    ,form:{
        name:'avatar'//配置上传文件的字段名称
        ,data:{ key:'value', ... } //其他需要一起上传的数据
    }
});

// 如果没有做任何修改，
// layui-admin中以admin设置为准；单独引用默认的后端返回数据格式需要如下
// {"code": 0, "msg": "success", "data": "/demo/demo.jpg"}，
// code-等于0表示成功，msg-返回的消息，data-返回给前端的图片地址
```

#### 自定义上传
```
// 回调函数 参数1：上传的文件数据，参数2：上传成功回调，参数3：上传异常回调
t.render({
    elem: "#edit"  
    ,images_upload_handler:function(blobInfo, succFun, failFun){
        // 你的代码 ...
    }
})
```
### 高级
#### 事件监听
查看[原版文档](https://www.tiny.cloud/docs-4x/advanced/events/)
```
t.render({
    elem: "#edit"
    , height: 200
    , init_instance_callback : function(ed) {
        ed.on('Click', function (e) { 
            // 监听编辑器内部的点击事件
        });
    }

});
```
##### 原生事件(区分大小写)
| 事件 | 描述 |
| --- | --- | 
| Click | 单击编辑器时触发 |
| DblClick | 双击编辑器时触发 |  
| MouseDown | 在编辑器中按下鼠标按钮时触发 |  
| MouseUp | 在编辑器中释放鼠标按钮时触发 |  
| MouseMove | 在编辑器中移动鼠标时触发 |  
| MouseOver | 鼠标移入时触发 |  
| MouseOut | 鼠标移出时触发 |  
| MouseEnter | 当鼠标进入编辑器时触发 |  
| MouseLeave | 当鼠标离开编辑器时触发 |  
| KeyDown | 在编辑器中按某个键时触发 |  
| KeyPress | 在编辑器中按下某个键时触发 |  
| KeyUp | 在编辑器中释放键时触发 |  
| ContextMenu | 在编辑器中调用上下文菜单时触发 |  
| Paste | 在编辑器中完成粘贴时触发 |  

##### 编辑器事件(区分大小写)
| 事件 | 描述 |
| --- | --- | 
| Init | 在编辑器初始化时触发 |
| Focus | 当编辑器聚焦时触发 |
| Blur | 编辑器失去焦点时触发 |
| BeforeSetContent | 在内容设置之前触发 |
| SetContent | 在内容设置时触发 |
| GetContent | 在获取内容时触发 |
| PreProcess | 在序列化编辑器中的内容时触发 |
| PostProcess | 在提交编辑器中的内容时触发 |
| NodeChange | 更改编辑器中的选择时触发 |
| Undo | 当内容恢复到以前的状态时触发 |
| Redo | 还原撤消事件时触发 |
| Change | 内容改变时触发 |
| Dirty | Fires when editor contents are being considered dirty |
| Remove | 删除编辑器时触发 |
| ExecCommand | 在执行命令后触发 |

### 更多配置  
> [中文配置文档](http://tinymce.ax-z.cn/configure/integration-and-setup.php)  
> [官方文档(英语)](https://www.tiny.cloud/docs/)

### 常见问题
##### Q1. 在弹窗里面使用时，菜单定位在弹窗下面怎么办
> layui_exts\tinymce\tinymce\skins\ui\oxide\skin.min.css 这个文件里的所有大于1的z-index后面加五个0
