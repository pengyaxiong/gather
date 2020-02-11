@extends('layouts.admin.partials.application')
@section('content')
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">清除缓存</strong> /
                <small>Clear Cache</small>
            </div>
        </div>
        <hr>

        @include('layouts.admin.partials._flash')

        <div class="am-g">

            <div class="am-g am-margin-top">

                <div class="am-u-md-8 am-u-md-offset-2">
                    <a href="{{route('system.cache.destroy')}}" data-method="delete" data-token="{{csrf_token()}}" class="am-btn am-btn-success am-radius am-btn-block">
                        <i class="am-icon-refresh am-icon-spin"></i>
                        清除缓存
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
