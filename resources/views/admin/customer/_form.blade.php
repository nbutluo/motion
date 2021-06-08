{{csrf_field()}}

<div class="layui-form-item">
    <label for="" class="layui-form-label">用户名</label>
    <div class="layui-input-block">
        <input type="email" name="user_name" value="{{$user->username??old('username')}}" lay-verify="required" placeholder="请输入用户名" class="layui-input" @if (isset($user) && !empty($user)) disabled @endif>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">密码</label>
    <div class="layui-input-block">
        <input type="password" name="pass_word" value="{{$user->password??old('password')}}" lay-verify="required" placeholder="请输入密码" class="layui-input" @if (isset($user) && !empty($user)) disabled @endif>
    </div>
</div>

@if (isset($user) && !empty($user))
    <div class="layui-form-item">
        <label for="" class="layui-form-label">头像</label>
        <div class="layui-input-block">
            <img width="200" hright="200" src="/{{$user->avatar}}" alt="">
        </div>
    </div>
@endif

<div class="layui-form-item">
    <label for="" class="layui-form-label">昵称</label>
    <div class="layui-input-block">
        <input type="text" name="nickname" value="{{$user->nickname??old('nickname')}}" placeholder="请输入用户昵称" class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">性别</label>
    <div class="layui-input-block">
        <select name="sex">
            <option value="0" @if(isset($user->sex)&&$user->sex==0)selected @endif>女</option>
            <option value="1" @if(isset($user->sex)&&$user->sex==1)selected @endif>男</option>
        </select>
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">电话</label>
    <div class="layui-input-block">
        <input type="text" name="phone" value="{{$user->phone??old('phone')}}" placeholder="请输入用户电话" class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">公司网址</label>
    <div class="layui-input-block">
        <input type="text" name="company_url" value="{{$user->company_url??old('company_url')}}" placeholder="请输入用户公司网址" class="layui-input">
    </div>
</div>

<div class="layui-form-item">
    <label for="" class="layui-form-label">关联业务员</label>
    <div class="layui-input-inline">
        <select name="salesman" lay-verify="required" id="salesman">
            <option value="0">请选择业务员</option>
            @foreach($adminUsers as $adminUser)
                <option value="{{$adminUser->id}}" @if (isset($adminUser->id) && isset($user) && $adminUser->id==$user->salesman)
                selected
                    @endif>{{$adminUser->nickname}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="layui-form-item">
    <div class="layui-input-block">
        <button type="submit" class="layui-btn" lay-submit="" lay-filter="formDemo">确 认</button>
        <a class="layui-btn" href="{{route('admin.customer.index')}}" >返 回</a>
    </div>
</div>
