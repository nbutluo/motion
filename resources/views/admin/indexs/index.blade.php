@extends('admin.layouts.app')

@section('title','后台首页')

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
                                    <option data-select2-id="3">普通用户</option>
                                    <option>一级授权</option>
                                    <option>二级授权</option>
                                </select><span class="select2 select2-container select2-container--default select2-container--focus" dir="ltr" data-select2-id="2" style="width: 100%;"></span>
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
                                        <tr>
                                            <td>183</td>
                                            <td>John Doe</td>
                                            <td><a href="mailto:nbutluo@163.com"><i class="fa fa-envelope"></i>&nbsp;nbutluo@163.com</a></p>
                                            </td>
                                            <td>一级授权</td>
                                            <td><span class="label label-success">最高等级</span></td>
                                            <td><span class="label label-danger">未认证</span></td>
                                            <td><a href="https:/www.baidu.com" target="_blank">查看详情</a> </td>
                                            <td><a href="https:/www.baidu.com" target="_blank">查看详情</a> </td>
                                            <td>
                                                <a href="">
                                                    <i class="fa fa-edit"></i>编辑
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5">
                        <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div>
                    </div>
                    <div class="col-sm-7">
                        <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                            <ul class="pagination">
                                <li class="paginate_button previous disabled" id="example2_previous"><a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0">Previous</a></li>
                                <li class="paginate_button active"><a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0">1</a></li>
                                <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="2" tabindex="0">2</a></li>
                                <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="3" tabindex="0">3</a></li>
                                <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="4" tabindex="0">4</a></li>
                                <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="5" tabindex="0">5</a></li>
                                <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="6" tabindex="0">6</a></li>
                                <li class="paginate_button next" id="example2_next"><a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0">Next</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
</div>
</div>
@endsection
