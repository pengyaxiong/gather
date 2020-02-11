<!doctype html>
<html class="no-js fixed-layout">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$config->title}}</title>
    <meta name="description" content="{{$config->description}}">
    <meta name="keywords" content="{{$config->keyword}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <link rel="icon" type="image/png" href="/favicon.ico">
    <link rel="apple-touch-icon-precomposed" href="/vendor/amazeui/i/app-icon72x72@2x.png">
    <meta name="apple-mobile-web-app-title" content="Amaze UI"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    <link rel="stylesheet" href="/vendor/amazeui/css/amazeui.min.css"/>
    <link rel="stylesheet" href="/vendor/amazeui/css/admin.css">
    <link rel="stylesheet" href="/css/admin.css">
    <link rel='stylesheet' href='/vendor/nprogress/nprogress.css'/>


    @yield('css')
</head>
<body>
<!--[if lte IE 9]>
<p class="browsehappy">你正在使用<strong>过时</strong>的浏览器，{{$config->title}}管理系统 暂不支持。 请 <a href="http://browsehappy.com/"
                                                                                      target="_blank">升级浏览器</a>
    以获得更好的体验！</p>
<![endif]-->

<header class="am-topbar am-topbar-admin admin-header">
    <div class="am-topbar-brand">
        <strong>{{$config->title}}</strong>
        <small></small>
    </div>

    <button class="am-topbar-btn am-topbar-toggle am-btn am-btn-sm am-btn-success am-show-sm-only"
            data-am-collapse="{target: '#topbar-collapse'}">
        <span class="am-sr-only">导航切换</span> <span class="am-icon-bars"></span></button>

    <div class="am-collapse am-topbar-collapse" id="topbar-collapse">

        <ul class="am-nav am-nav-pills am-topbar-nav am-topbar-right admin-header-list">

            <li class="am-dropdown" data-am-dropdown>
                <a class="am-dropdown-toggle" data-am-dropdown-toggle href="javascript:;">
                    <span class="am-icon-users"></span> {{ucfirst(Auth::user()->name)}}
                    {{Auth::user()->roles[0]['name']}}
                    <span class="am-icon-caret-down"></span>
                </a>
                <ul class="am-dropdown-content">
                    <li>
                        <a href="{{route('system.cache.destroy')}}" data-method="delete" data-token="{{csrf_token()}}">
                            <span class="am-icon-refresh am-icon-spin"></span>
                            清除缓存
                        </a>
                    </li>
                    <li><a href="{{route('system.user.edit', Auth::user()->id)}}"><span class="am-icon-cog"></span>
                            设置</a></li>
                    <li>
                        <a href="{{ url('/logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <span class="am-icon-power-off"></span> 退出
                        </a>

                        <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                              style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>
            <li class="am-hide-sm-only">
                <a href="javascript:;" id="admin-fullscreen"><span class="am-icon-arrows-alt"></span>
                    <span class="admin-fullText">开启全屏</span></a></li>
        </ul>
    </div>
</header>

<div class="am-cf admin-main">

    <!-- sidebar start -->
@include("layouts.admin.partials._sidebar")
    <!-- sidebar end -->

    <!-- content start -->
@yield('content')
    <!-- content end -->
</div>


<a href="#" class="am-icon-btn am-icon-th-list am-show-sm-only admin-menu"
   data-am-offcanvas="{target: '#admin-offcanvas'}"></a>

<!--[if lt IE 9]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<script src="http://cdn.staticfile.org/modernizr/2.8.3/modernizr.js"></script>
<script src="/vendor/amazeui/js/vendor/amazeui.ie8polyfill.min.js"></script>
<![endif]-->

<!--[if (gte IE 9)|!(IE)]><!-->
<script src="/js/jquery-3.1.0.min.js"></script>
<!--<![endif]-->
<script src="/vendor/amazeui/js/amazeui.min.js"></script>


<script src='/vendor/nprogress/nprogress.js'></script>

<script src="/js/admin.js"></script>
<script src="/js/destroy.js"></script>
<script src="/js/clipboard.js"></script>

{{--<script src="/js/app.js"></script>--}}

@yield('js')
</body>
</html>
