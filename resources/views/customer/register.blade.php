@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Customer_register') }}</div>

                    <div class="card-body">
                        {{--<form method="POST" action="{{ route('customer.register') }}">--}}
                        <form>
                            @csrf
                            <input type="hidden" id="smsId" name="sms_id" value=" ">
                            <div class="form-group row">
                                <label for="phone"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text" placeholder="请输入正确的手机号格式"
                                           class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                                           name="phone" value="{{ old('phone') }}" required autofocus>

                                    @if ($errors->has('phone'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="code"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Code') }}</label>

                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input id="code" type="text" placeholder="请输入正确的验证码"
                                               class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}"
                                               name="code" value="{{ old('code') }}" required>
                                        <div class="input-group-addon">
                                            <button type="button"
                                                    class="btn btn-default provingButton">{{ __('Send') }}</button>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" placeholder="请输入密码"
                                           class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                           name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                           placeholder="请再次输入密码"
                                           name="password_confirmation" required>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="button" class="btn btn-primary regbutton">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        // 验证手机号
        function isPhoneNo(phone) {
            var pattern = /^1[34578]\d{9}$/;
            return pattern.test(phone);
        };
        $(function () {
            $('.provingButton').click(function () {
                pho = $.trim($("#phone").val())
                if (pho == 0) {
                    swal("错误!", "请输入手机号!", "error");
                    return false;
                } else if (isPhoneNo(pho) == false) {
                    swal("错误!", "请输入正确的手机号!", "error");
                    return false;
                }
                $.post("{{route('api.customer.sms')}}", {
                    "phone": pho,
                    "request_type": "send_sms"
                }, function (data) {
                    if (data.status) {
                        swal("成功!", data.msg, "success");
                        console.log(data);
                        $("#smsId").val(data.datas.smsId);

                        var n = 59;
                        var t = setInterval(function () {
                            if (n <= 0) {
                                $('.provingButton').text('点击获取');
                                clearInterval(t);
                                $('.provingButton').next().hide();
                            } else {
                                $('.provingButton').text(n-- + 's');
                            }
                        }, 1000);
                    } else {
                        swal("错误!", data.msg, "error");
                    }
                }, 'json');


            });
            var pho = '', code = '', passwd = '', repeat = true;
            $(".regbutton").click(function () {
                var pho = $.trim($("#phone").val()),
                    code = $.trim($("#code").val()),
                    sms_id = $.trim($("#smsId").val()),
                    passwd = $.trim($("#password").val()),
                    password_confirmation = $.trim($("#password-confirm").val());
                if (pho == 0) {
                    swal("错误!", "请输入手机号!", "error");
                    return false;
                } else if (isPhoneNo(pho) == false) {
                    swal("错误!", "请输入正确的手机号!", "error");
                    return false;
                } else if (code == '') {
                    swal("错误!", "请输入验证码!", "error");
                    return false;
                } else if (passwd == '') {
                    swal("错误!", "请设定您的密码!", "error");
                    return false;
                }
                if (repeat) {
                    $.post("{{route('api.customer.register')}}", {
                        "phone": pho,
                        "code": code,
                        "password": passwd,
                        "sms_id": sms_id,
                        "password_confirmation": password_confirmation,
                    }, function (data) {
                        if (data.status) {
                            repeat = false;
                            console.log(data);
                            swal("成功!", data.msg, "success").then(function (value) {
                                window.location.href = "/";
                             });
                        } else {
                            swal("错误!", data.msg, "error");
                        }
                    }, 'json');
                }
            })
        })
    </script>
@endsection