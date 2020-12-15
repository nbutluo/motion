@extends('admin.layouts.app')

@section('title','用户列表')

@section('header-title','用户列表')

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-body">
                <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row" style="margin-bottom:20px;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>用户等级</label>
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                    @foreach($levels as $level)
                                    <option value="{{ $level->value }}">{{ $level->name }}</option>
                                    @endforeach
                                </select><span class=" select2 select2-container select2-container--default select2-container--focus" dir="ltr" data-select2-id="2" style="width: 100%;"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>授权申请</label>
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                    <option>未申请</option>
                                    <option>申请中</option>
                                    <option>最高等级</option>
                                </select><span class="select2 select2-container select2-container--default select2-container--focus" dir="ltr" data-select2-id="2" style="width: 100%;"></span>
                            </div>
                        </div>
                        <!-- /.form-group -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <th>序号</th>
                                            <th>用户名</th>
                                            <th>邮箱</th>
                                            <th>等级</th>
                                            <th>授权申请</th>
                                            <th>账号状态</th>
                                            <th>阅读图文详情</th>
                                            <th>视频播放详情</th>
                                            <th>操作</th>
                                        </tr>
                                        @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td><a href="mailto:{{ $user->email }}"><i class="fa fa-envelope"></i>&nbsp;{{ $user->email }}</a></p>
                                            </td>
                                            <td>{{ $user->level_name($user->level) }}</td>
                                            <td><span class="label label-success">最高等级</span></td>
                                            <td>
                                                <span class="{{ $user->email_verified_at  ? 'label label-success' : 'label label-danger' }}">
                                                    {{ $user->status($user->email_verified_at) }}
                                                </span>
                                            </td>
                                            <td><a href=" https:/www.baidu.com" target="_blank">查看详情</a> </td>
                                            <td><a href="https:/www.baidu.com" target="_blank">查看详情</a> </td>
                                            <td>
                                                <a href="">
                                                    <i class="fa fa-edit"></i>编辑
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-1">
                        <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">注册总人数：{{ $user->count() }}</div>
                    </div>
                    <div class="col-sm-1">
                        <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">已认证人数：{{ $user->activateds() }}</div>
                    </div>
                    <div class="col-sm-1">
                        <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">未认证人数：{{ $user->inactivateds()}}</div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    {!! $users->appends(Request::except('page'))->render() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>
</div>
</div>
@endsection
