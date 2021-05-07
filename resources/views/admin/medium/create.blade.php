@extends('admin.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <h2>添加媒体资源</h2>
        </div>
        <div class="layui-card-body">
            <form class="layui-form" action="{{route('admin.medium.source.store')}}" method="post" >
                @include('admin.medium._form')
            </form>
        </div>
    </div>
@endsection

{{-- 必须这个位置，DOM元素预先加载进缓存才能调用方法 --}}
<script>
    function goBack(){
        window.history.back()
    }
</script>

@section('script')
    @include('admin.medium._js')
@endsection
