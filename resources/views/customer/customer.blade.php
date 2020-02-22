@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="/vendor/loading/css/animate.css">
    <link rel="stylesheet" href="/vendor/loading/css/global.css">
    <link rel="stylesheet" href="/vendor/loading/css/loading.css">
@endsection
@section('content')
    <div id="loader"></div>
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
                        <button type="submit" class="btn btn-primary" onclick="loader()">{{ __('Search') }}</button>
                    </form>

                    <br>
                    @if (session('detail'))
                        <script>close()</script>
                        @foreach(session('detail') as $detail)
                            <div class="alert alert-danger" role="alert">
                                <div class="row">
                                    <div class="col-md-10">
                                        <strong>{{$detail['name']}}</strong>--更新时间：{{$detail['date']}}
                                    </div>
                                    <div class="col-md-2 col-md-offset-2">
                                        <button type="button" class="btn btn-success btn-xs copy_link"
                                                data-clipboard-text="{{$detail['content']}}">
                                            点击复制
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <script src="https://cdn.bootcss.com/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="/js/clipboard.js"></script>
    <script src="/vendor/loading/js/loading.js"></script>
    <script>
        function loader() {
            $('#loader').loading({
                loadingWidth: 240,
                title: '请稍等!',
                name: 'test',
                discription: '正在玩命加载。。。',
                direction: 'column',
                type: 'origin',
                // originBg:'#71EA71',
                originDivWidth: 40,
                originDivHeight: 40,
                originWidth: 6,
                originHeight: 6,
                smallLoading: false,
                loadingMaskBg:'rgba(0,0,0,0.2)'
            });
        }
        function close() {
            removeLoading('test');
        }
        $(function () {
            var clipboard = new ClipboardJS('.copy_link');

            clipboard.on('success', function (e) {
                console.info('Action:', e.action);
                console.info('Text:', e.text);
                console.info('Trigger:', e.trigger);

                e.clearSelection();
                swal("复制成功!", "打开迅雷即可下载", "success");
            });

            clipboard.on('error', function (e) {
                console.error('Action:', e.action);
                console.error('Trigger:', e.trigger);
            });
        });
    </script>
@endsection



