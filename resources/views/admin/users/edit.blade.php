@extends('admin.layouts.app')

@section('title',$user->name)

@section('header-title','用户编辑')
@section('content')
<div class="row">
    <div class="col-xs-5">
        <form method="POST" action="{{route('user.update',$user->id)}}">
            @csrf
            @method('PATCH')
            <input type="text" name="apply_id" value="{{$user->apply_id}}" hidden>
            <div class="form-group">
                <label for="recipient-name" class="control-label">用户名</label>
                <input type="text" name="name" class="form-control" value="{{$user->name}}" disabled>
            </div>
            <div class="form-group">
                <label for="recipient-name" class="control-label">邮箱:</label>
                <input type="email" name="email" value="{{$user->email}}" class="form-control" id="recipient-email" disabled>
            </div>
            <div class="form-group">
                <label for="recipient-name" class="control-label">用户等级:</label>
                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="level">
                    @foreach($user->levels() as $level)
                    <option value="{{ $level->value }}" {{ $user->level== $level->value ?"selected":""}}>{{ $level->name }}</option>
                    @endforeach
                </select><span class=" select2 select2-container select2-container--default select2-container--focus" dir="ltr" data-select2-id="2" style="width: 100%;"></span>
            </div>

            <!-- 用户的申请信息 -->
            @if($user->apply_code)
            <div class="apply-info">
                <div class="form-group">
                    <label for="message-text" class="control-label">申请理由:</label>
                    <textarea class="form-control" id="recipient-reason" name="apply_reason" disabled>{{$user->apply_reason}}</textarea>
                </div>
            </div>
            @endif
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="submit" class="btn btn-primary" onclick="confirm('确认保存吗')">保存</button>
            </div>
        </form>
    </div>
</div>
@endsection
