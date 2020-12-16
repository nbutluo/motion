@extends('admin.layouts.app')

@section('title','用户列表')

@section('header-title','用户列表')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <!-- 用户列表首页 -->
                <div class="row" style="margin-bottom:20px;">
                    @include('admin.users._header',['levels'=>$levels])
                </div>

                <!-- 用户数据 -->
                <div class="row">
                    @include('admin.users._table_list',['users'=>$users])
                </div>

                <!-- 统计数据列表 -->
                <div class="row">
                    @include('admin.users._data_list',['counts'=>$counts,'activateds'=>$activateds,'inactivateds'=>$inactivateds])
                </div>

                <!-- 分页 -->
                <div class="row">
                    <div class="col-sm-12 text-center">
                        {!! $users->appends(Request::except('page'))->render() !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
