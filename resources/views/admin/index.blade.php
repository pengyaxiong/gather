@extends('layouts.admin.partials.application')
@section('css')
    {{--<link rel="stylesheet" media="screen" href="/vendor/particles/css/style.css">--}}
    <style>

    </style>
@endsection
@section('content')
    <div class="admin-content">
        <div class="admin-content-body">

            <div class="am-cf am-padding">
                <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">首页</strong> /
                    <small>{{Auth::id()==1?'数据统计':'欢迎'}}</small>
                </div>
            </div>

            @include("layouts.admin.partials._flash")

            @if (Auth::id()==1)

                <ul class="am-avg-sm-1 am-avg-md-4 am-margin am-padding am-text-center admin-content-list ">
                    <li><a href="javascript:void (0)" class="am-text-success"><span class="am-icon-btn am-icon-file-text"></span><br>推文访问<br>{!! see_num('article') !!}</a></li>
                    <li><a href="javascript:void (0)" class="am-text-warning"><span class="am-icon-btn am-icon-money"></span><br>贷超有效流量<br>{!! see_num('supermarket') !!}</a></li>
                    <li><a href="javascript:void (0)" class="am-text-warning"><span class="am-icon-btn am-icon-credit-card"></span><br>信用卡有效流量<br>{!! see_num('product') !!}</a></li>
                    <li><a href="javascript:void (0)" class="am-text-danger"><span class="am-icon-btn am-icon-recycle"></span><br>总访问量<br>{!! uv() !!}</a></li>
                    {{--<li><a href="javascript:void (0)" class="am-text-secondary"><span class="am-icon-btn am-icon-user-md"></span><br>注册用户<br>{{\App\Models\Cms\Customer::count()}}</a></li>--}}
                </ul>
                <div class="am-g">
                    <div class="am-u-sm-12">

                        <div id="statistics_supermarket" style="width: 100%;height:400px;"></div>

                    </div>
                </div>

                <hr data-am-widget="divider" style="" class="am-divider am-divider-default"/>

                <div class="am-g">
                    <div class="am-u-sm-12">

                        <div id="statistics_product" style="width: 100%;height:400px;"></div>

                    </div>
                </div>

                <hr data-am-widget="divider" style="" class="am-divider am-divider-default"/>

                <div class="am-g">
                    <div class="am-u-sm-12">

                        <div id="statistics_customer" style="width: 100%;height:600px;"></div>

                    </div>
                </div>
            @else
                <div class="am-g">
                    <div class="am-u-sm-12">
                        {{--<div id="particles-js">--}}
                            {{--<p>--}}
                                {{--{{$bibel['cn']}}--}}
                                {{--<br/>--}}
                                {{--{{$bibel['en']}}--}}
                            {{--</p>--}}
                        {{--</div>--}}

                        <form class="am-form " action="{{route('admin.update', $user->id)}}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                            <div class="am-g am-margin-top">
                                <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                    用户名
                                </div>
                                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                    <input type="text" class="am-input-sm" name="name" value="{{ old('name') ? old('name') : $user->name }}">
                                </div>
                            </div>

                            <div class="am-g am-margin-top">
                                <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                    真实姓名
                                </div>
                                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                    {{$user->real_name}}
                                </div>
                            </div>

                            <div class="am-g am-margin-top">
                                <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                    手机号
                                </div>
                                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                    <input type="text" class="am-input-sm" name="phone" value="{{ old('phone') ? old('phone') : $user->phone}}">
                                </div>
                            </div>

                            <div class="am-g am-margin-top">
                                <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                    二维码
                                </div>
                            </div>

                            <div class="am-g">
                                <div class="am-u-sm-4 am-u-md-3 am-text-right">&nbsp;</div>
                                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                    <div id="doc-qrcode" class="am-text-center"></div>
                                </div>
                            </div>

                            <div class="am-g am-margin-top">
                                <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                    邀请链接
                                </div>

                                <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                    <div class="am-input-group">
                                          <span class="am-input-group-btn">
                                            <button class="am-btn am-btn-secondary add_admin_link" type="button">
                                              <i class="am-icon-link"></i> 点击生成链接
                                            </button>
                                          </span>
                                        <input type="text" class="am-form-field" id="admin_link">
                                        <span class="am-input-group-btn"  data-am-popover="{theme: 'default',content: '点击复制链接', trigger: 'hover focus'}">
                                            <button class="am-btn am-btn-default copy_admin_link" type="button"  data-clipboard-target="#admin_link">
                                              <i class="am-icon-copy"></i> Copy
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{--<div class="am-g am-margin-top">--}}
                            {{--<div class="am-u-sm-4 am-u-md-3 am-text-right">--}}
                            {{--原始密码--}}
                            {{--</div>--}}
                            {{--<div class="am-u-sm-8 am-u-md-4 am-u-end col-end">--}}
                            {{--<input type="password" class="am-input-sm" name="old_password">--}}
                            {{--</div>--}}
                            {{--</div>--}}

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

                            <div class="am-g am-margin-top">
                                <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                    所属用户组
                                </div>
                                <div class="am-u-sm-8 am-u-md-9 am-u-end col-end">
                                    @foreach ($user_roles as $role)
                                        {{$role}}&nbsp;|&nbsp;
                                    @endforeach
                                </div>
                            </div>

                            <div class="am-margin">
                                <button type="submit" class="am-btn am-btn-primary">保存修改</button>
                            </div>
                        </form>
                    </div>
                </div>

                {{--<div class="am-g">--}}
                    {{--<div class="am-u-sm-12">--}}
                        {{--<table class="am-table am-table-bd am-table-striped admin-content-table">--}}
                            {{--<thead>--}}
                            {{--<tr>--}}
                                {{--<th>ID</th><th>用户名</th><th>最后成交任务</th><th>成交订单</th><th>管理</th>--}}
                            {{--</tr>--}}
                            {{--</thead>--}}
                            {{--<tbody>--}}
                            {{--<tr><td>1</td><td>John Clark</td><td><a href="#">Business management</a></td> <td><span class="am-badge am-badge-success">+20</span></td>--}}
                                {{--<td>--}}
                                    {{--<div class="am-dropdown" data-am-dropdown="">--}}
                                        {{--<button class="am-btn am-btn-default am-btn-xs am-dropdown-toggle" data-am-dropdown-toggle=""><span class="am-icon-cog"></span> <span class="am-icon-caret-down"></span></button>--}}
                                        {{--<ul class="am-dropdown-content">--}}
                                            {{--<li><a href="#">1. 编辑</a></li>--}}
                                            {{--<li><a href="#">2. 下载</a></li>--}}
                                            {{--<li><a href="#">3. 删除</a></li>--}}
                                        {{--</ul>--}}
                                    {{--</div>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr><td>2</td><td>风清扬</td><td><a href="#">公司LOGO设计</a> </td><td><span class="am-badge am-badge-danger">+2</span></td>--}}
                                {{--<td>--}}
                                    {{--<div class="am-dropdown" data-am-dropdown="">--}}
                                        {{--<button class="am-btn am-btn-default am-btn-xs am-dropdown-toggle" data-am-dropdown-toggle=""><span class="am-icon-cog"></span> <span class="am-icon-caret-down"></span></button>--}}
                                        {{--<ul class="am-dropdown-content">--}}
                                            {{--<li><a href="#">1. 编辑</a></li>--}}
                                            {{--<li><a href="#">2. 下载</a></li>--}}
                                            {{--<li><a href="#">3. 删除</a></li>--}}
                                        {{--</ul>--}}
                                    {{--</div>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr><td>3</td><td>詹姆斯</td><td><a href="#">开发一款业务数据软件</a></td><td><span class="am-badge am-badge-warning">+10</span></td>--}}
                                {{--<td>--}}
                                    {{--<div class="am-dropdown" data-am-dropdown="">--}}
                                        {{--<button class="am-btn am-btn-default am-btn-xs am-dropdown-toggle" data-am-dropdown-toggle=""><span class="am-icon-cog"></span> <span class="am-icon-caret-down"></span></button>--}}
                                        {{--<ul class="am-dropdown-content">--}}
                                            {{--<li><a href="#">1. 编辑</a></li>--}}
                                            {{--<li><a href="#">2. 下载</a></li>--}}
                                            {{--<li><a href="#">3. 删除</a></li>--}}
                                        {{--</ul>--}}
                                    {{--</div>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                            {{--<tr><td>4</td><td>云适配</td><td><a href="#">适配所有网站</a></td><td><span class="am-badge am-badge-secondary">+50</span></td>--}}
                                {{--<td>--}}
                                    {{--<div class="am-dropdown" data-am-dropdown="">--}}
                                        {{--<button class="am-btn am-btn-default am-btn-xs am-dropdown-toggle" data-am-dropdown-toggle=""><span class="am-icon-cog"></span> <span class="am-icon-caret-down"></span></button>--}}
                                        {{--<ul class="am-dropdown-content">--}}
                                            {{--<li><a href="#">1. 编辑</a></li>--}}
                                            {{--<li><a href="#">2. 下载</a></li>--}}
                                            {{--<li><a href="#">3. 删除</a></li>--}}
                                        {{--</ul>--}}
                                    {{--</div>--}}
                                {{--</td>--}}
                            {{--</tr>--}}

                            {{--<tr>--}}
                                {{--<td>5</td><td>呵呵呵</td>--}}
                                {{--<td><a href="#">基兰会获得BUFF</a></td>--}}
                                {{--<td><span class="am-badge">+22</span></td>--}}
                                {{--<td>--}}
                                    {{--<div class="am-dropdown" data-am-dropdown="">--}}
                                        {{--<button class="am-btn am-btn-default am-btn-xs am-dropdown-toggle" data-am-dropdown-toggle=""><span class="am-icon-cog"></span> <span class="am-icon-caret-down"></span></button>--}}
                                        {{--<ul class="am-dropdown-content">--}}
                                            {{--<li><a href="#">1. 编辑</a></li>--}}
                                            {{--<li><a href="#">2. 下载</a></li>--}}
                                            {{--<li><a href="#">3. 删除</a></li>--}}
                                        {{--</ul>--}}
                                    {{--</div>--}}
                                {{--</td>--}}
                            {{--</tr>--}}
                            {{--</tbody>--}}
                        {{--</table>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="am-g">--}}
                    {{--<div class="am-u-md-6">--}}
                        {{--<div class="am-panel am-panel-default">--}}
                            {{--<div class="am-panel-hd am-cf" data-am-collapse="{target: '#collapse-panel-1'}">文件上传<span class="am-icon-chevron-down am-fr"></span></div>--}}
                            {{--<div class="am-panel-bd am-collapse am-in" id="collapse-panel-1">--}}
                                {{--<ul class="am-list admin-content-file">--}}
                                    {{--<li>--}}
                                        {{--<strong><span class="am-icon-upload"></span> Kong-cetian.Mp3</strong>--}}
                                        {{--<p>3.3 of 5MB - 5 mins - 1MB/Sec</p>--}}
                                        {{--<div class="am-progress am-progress-striped am-progress-sm am-active">--}}
                                            {{--<div class="am-progress-bar am-progress-bar-success" style="width: 82%">82%</div>--}}
                                        {{--</div>--}}
                                    {{--</li>--}}
                                    {{--<li>--}}
                                        {{--<strong><span class="am-icon-check"></span> 好人-cetian.Mp3</strong>--}}
                                        {{--<p>3.3 of 5MB - 5 mins - 3MB/Sec</p>--}}
                                    {{--</li>--}}
                                    {{--<li>--}}
                                        {{--<strong><span class="am-icon-check"></span> 其实都没有.Mp3</strong>--}}
                                        {{--<p>3.3 of 5MB - 5 mins - 3MB/Sec</p>--}}
                                    {{--</li>--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="am-panel am-panel-default">--}}
                            {{--<div class="am-panel-hd am-cf" data-am-collapse="{target: '#collapse-panel-2'}">浏览器统计<span class="am-icon-chevron-down am-fr"></span></div>--}}
                            {{--<div id="collapse-panel-2" class="am-in">--}}
                                {{--<table class="am-table am-table-bd am-table-bdrs am-table-striped am-table-hover">--}}
                                    {{--<tbody>--}}
                                    {{--<tr>--}}
                                        {{--<th class="am-text-center">#</th>--}}
                                        {{--<th>浏览器</th>--}}
                                        {{--<th>访问量</th>--}}
                                    {{--</tr>--}}
                                    {{--<tr>--}}
                                        {{--<td class="am-text-center"><img src="/i/examples/admin-chrome.png" alt=""></td>--}}
                                        {{--<td>Google Chrome</td>--}}
                                        {{--<td>3,005</td>--}}
                                    {{--</tr>--}}
                                    {{--<tr>--}}
                                        {{--<td class="am-text-center"><img src="/i/examples/admin-firefox.png" alt=""></td>--}}
                                        {{--<td>Mozilla Firefox</td>--}}
                                        {{--<td>2,505</td>--}}
                                    {{--</tr>--}}
                                    {{--<tr>--}}
                                        {{--<td class="am-text-center"><img src="/i/examples/admin-ie.png" alt=""></td>--}}
                                        {{--<td>Internet Explorer</td>--}}
                                        {{--<td>1,405</td>--}}
                                    {{--</tr>--}}
                                    {{--<tr>--}}
                                        {{--<td class="am-text-center"><img src="/i/examples/admin-opera.png" alt=""></td>--}}
                                        {{--<td>Opera</td>--}}
                                        {{--<td>4,005</td>--}}
                                    {{--</tr>--}}
                                    {{--<tr>--}}
                                        {{--<td class="am-text-center"><img src="/i/examples/admin-safari.png" alt=""></td>--}}
                                        {{--<td>Safari</td>--}}
                                        {{--<td>505</td>--}}
                                    {{--</tr>--}}
                                    {{--</tbody>--}}
                                {{--</table>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="am-u-md-6">--}}
                        {{--<div class="am-panel am-panel-default">--}}
                            {{--<div class="am-panel-hd am-cf" data-am-collapse="{target: '#collapse-panel-4'}">任务 task<span class="am-icon-chevron-down am-fr"></span></div>--}}
                            {{--<div id="collapse-panel-4" class="am-panel-bd am-collapse am-in">--}}
                                {{--<ul class="am-list admin-content-task">--}}
                                    {{--<li>--}}
                                        {{--<div class="admin-task-meta"> Posted on 25/1/2120 by John Clark</div>--}}
                                        {{--<div class="admin-task-bd">--}}
                                            {{--The starting place for exploring business management; helping new managers get started and experienced managers get better.--}}
                                        {{--</div>--}}
                                        {{--<div class="am-cf">--}}
                                            {{--<div class="am-btn-toolbar am-fl">--}}
                                                {{--<div class="am-btn-group am-btn-group-xs">--}}
                                                    {{--<button type="button" class="am-btn am-btn-default"><span class="am-icon-check"></span></button>--}}
                                                    {{--<button type="button" class="am-btn am-btn-default"><span class="am-icon-pencil"></span></button>--}}
                                                    {{--<button type="button" class="am-btn am-btn-default"><span class="am-icon-times"></span></button>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="am-fr">--}}
                                                {{--<button type="button" class="am-btn am-btn-default am-btn-xs">删除</button>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</li>--}}
                                    {{--<li>--}}
                                        {{--<div class="admin-task-meta"> Posted on 25/1/2120 by 呵呵呵</div>--}}
                                        {{--<div class="admin-task-bd">--}}
                                            {{--基兰和狗熊出现在不同阵营时。基兰会获得BUFF，“装甲熊憎恨者”。狗熊会获得BUFF，“时光老人憎恨者”。--}}
                                        {{--</div>--}}
                                        {{--<div class="am-cf">--}}
                                            {{--<div class="am-btn-toolbar am-fl">--}}
                                                {{--<div class="am-btn-group am-btn-group-xs">--}}
                                                    {{--<button type="button" class="am-btn am-btn-default"><span class="am-icon-check"></span></button>--}}
                                                    {{--<button type="button" class="am-btn am-btn-default"><span class="am-icon-pencil"></span></button>--}}
                                                    {{--<button type="button" class="am-btn am-btn-default"><span class="am-icon-times"></span></button>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                            {{--<div class="am-fr">--}}
                                                {{--<button type="button" class="am-btn am-btn-default am-btn-xs">删除</button>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</li>--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<div class="am-panel am-panel-default">--}}
                            {{--<div class="am-panel-hd am-cf" data-am-collapse="{target: '#collapse-panel-3'}">最近留言<span class="am-icon-chevron-down am-fr"></span></div>--}}
                            {{--<div class="am-panel-bd am-collapse am-in am-cf" id="collapse-panel-3">--}}
                                {{--<ul class="am-comments-list admin-content-comment">--}}
                                    {{--<li class="am-comment">--}}
                                        {{--<a href="#"><img src="http://s.amazeui.org/media/i/demos/bw-2014-06-19.jpg?imageView/1/w/96/h/96" alt="" class="am-comment-avatar" width="48" height="48"></a>--}}
                                        {{--<div class="am-comment-main">--}}
                                            {{--<header class="am-comment-hd">--}}
                                                {{--<div class="am-comment-meta"><a href="#" class="am-comment-author">某人</a> 评论于 <time>2014-7-12 15:30</time></div>--}}
                                            {{--</header>--}}
                                            {{--<div class="am-comment-bd"><p>遵循 “移动优先（Mobile First）”、“渐进增强（Progressive enhancement）”的理念，可先从移动设备开始开发网站，逐步在扩展的更大屏幕的设备上，专注于最重要的内容和交互，很好。</p>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</li>--}}

                                    {{--<li class="am-comment">--}}
                                        {{--<a href="#"><img src="http://s.amazeui.org/media/i/demos/bw-2014-06-19.jpg?imageView/1/w/96/h/96" alt="" class="am-comment-avatar" width="48" height="48"></a>--}}
                                        {{--<div class="am-comment-main">--}}
                                            {{--<header class="am-comment-hd">--}}
                                                {{--<div class="am-comment-meta"><a href="#" class="am-comment-author">某人</a> 评论于 <time>2014-7-12 15:30</time></div>--}}
                                            {{--</header>--}}
                                            {{--<div class="am-comment-bd"><p>有效减少为兼容旧浏览器的臃肿代码；基于 CSS3 的交互效果，平滑、高效。AMUI专注于现代浏览器（支持HTML5），不再为过时的浏览器耗费资源，为更有价值的用户提高更好的体验。</p>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</li>--}}

                                {{--</ul>--}}
                                {{--<ul class="am-pagination am-fr admin-content-pagination">--}}
                                    {{--<li class="am-disabled"><a href="#">«</a></li>--}}
                                    {{--<li class="am-active"><a href="#">1</a></li>--}}
                                    {{--<li><a href="#">2</a></li>--}}
                                    {{--<li><a href="#">3</a></li>--}}
                                    {{--<li><a href="#">4</a></li>--}}
                                    {{--<li><a href="#">5</a></li>--}}
                                    {{--<li><a href="#">»</a></li>--}}
                                {{--</ul>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            @endif
            @include('layouts.admin.partials._footer')
        </div>
    </div>
@endsection
@section('js')
    <script src="/vendor/echarts/echarts.min.js"></script>
    <script src="/vendor/echarts/macarons.js"></script>

    <script src="/js/visualization/statistics_customer.js"></script>
    <script src="/js/visualization/statistics_product.js"></script>
    <script src="/js/visualization/statistics_supermarket.js"></script>
    {{--<script src="/vendor/particles/js/particles.js"></script>--}}
    {{--<script src="/vendor/particles/js/app.js"></script>--}}
    <script>
        //二维码

        $(function () {

            var clipboard = new ClipboardJS('.copy_admin_link');

            clipboard.on('success', function(e) {
                alert("复制成功");
                console.log(e);
            });

            clipboard.on('error', function(e) {
                console.log(e);
            });

            var _qr = $('#doc-qrcode');

            function makeCode(text) {
                _qr.empty().qrcode(text);
            }

           // makeCode('{!! $_SERVER['HTTP_HOST'] !!}/register.html?id={!! $user->id !!}');
            makeCode('{!! route('customer.register',['user_id'=>$user->id]) !!}');



            //邀请链接
            $(".add_admin_link").click(function () {
                $.ajax({
                    url: '{{route('admin.link')}}',
                    type: 'GET',
                    success: function (data) {
                        console.log(data);
                        if (data.err) {
                            alert(data.err)
                        }else{
                            var ShortUrl=data.url;
                            console.log(ShortUrl);
                            $("#admin_link").val(ShortUrl);
                        }
                    }
                });
            });
        });
    </script>
@endsection

