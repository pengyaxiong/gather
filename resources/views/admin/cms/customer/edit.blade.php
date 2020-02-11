@extends('layouts.admin.partials.application')

@section('content')
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">编辑用户</strong> /
                <small>Edit Customer</small>
            </div>
        </div>

        @include('layouts.admin.partials._flash')
        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-12">

                <div class="am-tab-panel">

                    <form class="am-form " action="{{route('cms.customer.update', $customer->id)}}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                手机号
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="text" class="am-input-sm" name="phone"
                                       value="{{ old('phone') ? old('phone') : $customer->phone }}">
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                姓名
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="text" class="am-input-sm" name="name"
                                       value="{{ old('name') ? old('name') : $customer->name}}">
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                性别
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <label class="am-radio-inline">
                                    <input type="radio" value="1" name="sex" @if($customer->sex) checked @endif > 男
                                </label>
                                <label class="am-radio-inline">
                                    <input type="radio" value="0" name="sex" @if(!$customer->sex) checked @endif> 女
                                </label>
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                是否可用
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <label class="am-radio-inline">
                                    <input type="radio" value="1" name="state" @if($customer->state) checked @endif > 可用
                                </label>
                                <label class="am-radio-inline">
                                    <input type="radio" value="0" name="state" @if(!$customer->state) checked @endif> 冻结
                                </label>
                            </div>
                        </div>


                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                原始密码
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="password" class="am-input-sm" name="old_password">
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                新密码
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

        })
    </script>
@endsection