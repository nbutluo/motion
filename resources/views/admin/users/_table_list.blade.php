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
                        <td>
                            <a href="mailto:{{ $user->email }}"><i class="fa fa-envelope"></i>&nbsp;{{ $user->email }}</a>
                        </td>
                        <td>{{ $user->level_name($user->level) }}</td>
                        <td>
                            @if($user->apply_status == 1)
                            <span class="label label-warning"> 申请中</span>
                            @elseif($user->apply_status == 2)
                            <span class="label label-success"> 最高等级</span>
                            @else
                            <span class="label label-info"> 未申请</span>
                            @endif
                        </td>
                        <td>
                            <span class="{{ $user->email_verified_at  ? 'label label-success' : 'label label-danger' }}">
                                {{ $user->status($user->email_verified_at) }}
                            </span>
                        </td>
                        <td><a href=" https:/www.baidu.com" target="_blank">查看详情</a> </td>
                        <td><a href="https:/www.baidu.com" target="_blank">查看详情</a> </td>
                        <td>
                            <a href="{{ route('user.edit', $user->id) }}">
                                <button type="button" class="btn btn-primary btn-sm">
                                    <i class="fa fa-edit"></i> 编辑
                                </button>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
