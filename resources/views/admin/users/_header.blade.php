<form action="{{ route('user.index') }}" method="get">
    @csrf
    <div class="col-md-2">
        <div class="form-group">
            <label>用户等级</label>
            <select class="form-control" style="width: 70%;" tabindex="-1" aria-hidden="true" name="level">
                <option value="">-请选择-</option>
                @foreach($levels as $level)
                <option value="{{ $level->value }}">{{ $level->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group">
            <label>授权申请</label>
            <select class="form-control" style="width: 80%;" data-select2-id="1" tabindex="-1" aria-hidden="true" name="apply_status">
                <option value="">-请选择-</option>
                <option value="0">未申请</option>
                <option value="1">申请中</option>
                <option value="2">最高等级</option>
            </select>
        </div>
    </div>

    <div class="col-md-1">
        <label style="color: #fff;">搜索按钮</label>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">搜索</button>
        </div>
    </div>
</form>
