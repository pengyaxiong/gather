@extends('layouts.app')

@section('css')

@endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                <div class="card-header">{{ __('Customer_login') }}</div>

                <div class="card-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/customer/login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <label for="phone" class="col-md-4 control-label">{{ __('Phone') }}</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control" name="phone"
                                       value="{{ old('phone') }}" required autofocus>

                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : ''}}>
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                                @if (Route::has('customer.password.request'))
                                    <a class="btn btn-link" href="{{ url('/customer/password/reset') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>


            </div>
        </div>
    </div>
@endsection


@section('js')

@endsection

