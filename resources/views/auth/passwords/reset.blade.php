@extends('layouts.admin.partials.application')

@section('content')
    <div class="admin-content">
        <br>
        @if (session('status'))
            <div class="am-g">
                <div class="am-u-md-12">
                    <div class="am-alert am-alert-warning" data-am-alert>
                        <button type="button" class="am-close">&times;</button>
                        {{ session('status') }}
                    </div>
                </div>
            </div>
        @endif

        <div class="am-g">
            <div class="am-u-lg-8 am-u-md-8 am-u-sm-centered">
                <div class="am-panel am-panel-default">
                    <div class="am-panel-hd">{{ __('Reset Password') }}</div>
                    <div class="am-panel-bd">
                        <form method="POST" class="am-form am-form-horizontal"  action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="am-form-group{{ $errors->has('email') ? ' am-form-error' : '' }} am-form-icon am-form-feedback">
                                <label class="am-form-label"
                                       for="doc-ipt-success">{{ __('E-Mail Address') }}
                                    : @if($errors->has('email')){{ $errors->first('email') }} @endif</label>
                                <input type="text" class="am-form-field" name="email" value="{{ old('email') }}"
                                       required autofocus>
                                @if ($errors->has('email'))
                                    <span class="am-icon-warning">{{$errors->first('email')}}</span>
                                @endif
                            </div>

                            <div class="am-form-group{{ $errors->has('password') ? ' am-form-error' : '' }} am-form-icon am-form-feedback">
                                <label class="am-form-label"
                                       for="doc-ipt-success">{{ __('Password') }}
                                    : @if($errors->has('password')){{ $errors->first('password') }} @endif</label>
                                <input type="password" class="am-form-field" name="password" value="{{ old('password') }}"
                                       required autofocus>
                                @if ($errors->has('password'))
                                    <span class="am-icon-warning">{{$errors->first('password')}}</span>
                                @endif
                            </div>

                            <div class="am-form-group{{ $errors->has('email') ? ' am-form-error' : '' }} am-form-icon am-form-feedback">
                                <label class="am-form-label"
                                       for="doc-ipt-success">{{ __('Confirm Password') }}
                                    : @if($errors->has('password')){{ $errors->first('password') }} @endif</label>
                                <input type="password" class="am-form-field" name="password_confirmation" value="{{ old('password_confirmation') }}"
                                       required autofocus>

                            </div>

                            <p><button type="submit" class="am-btn am-btn-default">{{ __('Reset Password') }}</button></p>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
