<div class="col-md-2">
    <div class="form-group">
        <label>用户等级</label>
        <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
            @foreach($levels as $level)
            <option value="{{ $level->value }}">{{ $level->name }}</option>
            @endforeach
        </select><span class=" select2 select2-container select2-container--default select2-container--focus" dir="ltr" data-select2-id="2" style="width: 100%;"></span>
    </div>
</div>
<div class="col-md-2">
    <div class="form-group">
        <label>授权申请</label>
        <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
            <option>未申请</option>
            <option>申请中</option>
            <option>最高等级</option>
        </select><span class="select2 select2-container select2-container--default select2-container--focus" dir="ltr" data-select2-id="2" style="width: 100%;"></span>
    </div>
</div>
