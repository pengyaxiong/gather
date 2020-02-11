@extends('layouts.app')

@section('css')

@endsection
@section('content')
    <div class="container">
        <div class="jumbotron">
            <h1>Hello, world!</h1>
            <p>{{$config->company}}</p>
            <p><a class="btn btn-primary btn-lg" href="#" role="button">{{__('Learn more')}}</a></p>
        </div>
    </div>
@endsection


@section('js')

@endsection



