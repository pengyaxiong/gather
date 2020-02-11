@extends('layouts.admin.partials.application')

@section('content')
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">新增员工</strong> /
                <small>Create User</small>
            </div>
        </div>

        @include('layouts.admin.partials._flash')
        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-12">
                <div class="am-tab-panel">
                    <form class="am-form " action="{{route('system.user.store')}}" method="post">
                        {{ csrf_field() }}

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                用户名
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="text" class="am-input-sm" name="name" value="{{ old('name') }}">
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                真实姓名
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="text" class="am-input-sm" name="real_name" value="{{ old('real_name') }}">
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                邮箱
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="text" class="am-input-sm" name="email" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                手机号
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="text" class="am-input-sm" name="phone" value="{{ old('phone') }}">
                            </div>
                        </div>
                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                QQ
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="text" class="am-input-sm" name="qq" value="{{ old('qq') }}">
                            </div>
                        </div>
                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                状态
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <label class="am-radio-inline">
                                    <input type="radio" value="1" name="state" checked> 正常
                                </label>
                                <label class="am-radio-inline">
                                    <input type="radio" value="0" name="state"> 冻结
                                </label>
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                密码
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="password" class="am-input-sm" name="password">
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                确认密码
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="password" class="am-input-sm" name="password_confirmation">
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                选择用户组
                            </div>
                            <div class="am-u-sm-8 am-u-md-9 am-u-end col-end">
                                @foreach ($roles as $role)
                                    <label class="am-checkbox-inline">
                                        <input type="checkbox" value="{{$role->id}}" name="role_id[]"
                                               @if(old('role_id') && in_array($role->id, old('role_id'))) checked @endif>
                                        {{$role->name}}
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="am-margin">
                            <button type="submit" class="am-btn am-btn-primary">保存修改</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(function () {
            var demo = $("input[name=only_code]");
            var code = Math.random().toString(36).substr(2);
            demo.val(code);
            $("#change_code").click(function () {
                var code_ = Math.random().toString(36).substr(2);
                demo.val(code_);
            })
        })
    </script>
@endsection