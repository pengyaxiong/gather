@extends('layouts.app')

@section('css')

@endsection
@section('content')
    <div class="container">
        <div class="jumbotron">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <form method="POST" action="{{ url('/customer/torrent') }}">
                        {{ csrf_field() }}
                        <div class="form-group form-group-lg">
                            <input type="text" class="form-control {{ $errors->has('keyword') ? ' is-invalid' : '' }}"
                                   name="keyword"
                                   value="{{ old('keyword') }}" placeholder="你想要的都有~">
                            @if ($errors->has('keyword'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>错误：{{ $errors->first('keyword') }}</strong>
                                </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                    </form>
                    @if (session('detail'))
                        @foreach(session('detail') as $detail)
                            {{$detail['name']}}<br>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')

@endsection



