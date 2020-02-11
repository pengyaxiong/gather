@extends('layouts.admin.partials.base')

@section('title', __('Login'))

@section('pageHeader', __('Login'))

@section('pageDesc', __('Login'))

@section('css')
    <style>
        .header {
            text-align: center;
        }

        .header h1 {
            font-size: 200%;
            color: #333;
            margin-top: 30px;
        }

        .header p {
            font-size: 14px;
        }

        body {
            font-family: Raleway, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #636b6f;
        }
    </style>
@endsection
@section('content')
    <div class="header">
        <div class="am-g">
            <h1>{{$config->company}}</h1>
            {{--<p>itcasts.net</p>--}}
        </div>
        <br>
    </div>
    <div class="am-g">
        <div class="am-u-lg-6 am-u-md-8 am-u-sm-centered">
            <h3>{{ __('Admin') }}{{ __('Login') }}</h3>
            <hr>
            @if (session('notice'))
                <div class="am-g">
                    <div class="am-u-md-12">
                        <div class="am-alert am-alert-danger" data-am-alert>
                            <button type="button" class="am-close">&times;</button>
                            {{ session('notice') }}
                        </div>
                    </div>
                </div>
            @endif
            <form method="post" class="am-form am-form-horizontal" action="{{ url('/login') }}">
                {!!  csrf_field()  !!}

                <div class="am-form-group{{ $errors->has('name') ? ' am-form-error' : '' }} am-form-icon am-form-feedback">
                    <label class="am-form-label"
                           for="doc-ipt-success">{{ __('Name') }}
                        : @if($errors->has('name')){{ $errors->first('name') }} @endif</label>
                    <input type="text" class="am-form-field" placeholder="输入你的用户名" name="name" value="{{ old('name') }}"
                           required autofocus>
                    @if ($errors->has('name'))
                        <span class="am-icon-warning">{{$errors->first('name')}}</span>
                    @endif
                </div>


                <div class="am-form-group{{ $errors->has('password') ? ' am-form-error' : '' }} am-form-icon am-form-feedback">
                    <label class="am-form-label"
                           for="doc-ipt-success">{{ __('Password') }}
                        : @if($errors->has('password')){{ $errors->first('password') }} @endif</label>
                    <input type="password" class="am-form-field" placeholder="输入你的密码" name="password" required>
                    @if ($errors->has('password'))
                        <span class="am-icon-warning"></span>
                    @endif
                </div>

                <br>
                <label for="remember-me">
                    <input id="remember-me" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                    {{ __('Remember Me') }}
                </label>
                <br/>
                <div class="am-cf">
                    <input type="submit" name="" value="{{ __('Login') }}"
                           class="am-btn am-btn-primary am-btn-sm am-fl">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="am-btn am-btn-default am-btn-sm am-fr"> {{ __('Forgot Your Password?') }} ^_^? </a>
                    @endif
                </div>
            </form>
            <br>
            @include('layouts.admin.partials._footer')
        </div>
    </div>
@endsection


@section('js')

@endsection

