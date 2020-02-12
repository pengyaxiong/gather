@extends('layouts.admin.partials.application')

@section('content')
    <div class="admin-content">
        <div class="admin-content-body">
            {{--<div class="am-cf am-padding am-padding-bottom-0">--}}
                {{--<div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">403</strong> / <small>没有权限</small></div>--}}
            {{--</div>--}}

            {{--<hr>--}}

            <div class="am-g">
                <div class="am-u-sm-12">
                    <h2 class="am-text-center am-text-xxxl am-margin-top-lg">您没有权限访问此页面。</h2>
                    <p class="am-text-center">你可以返回<a href="{{route('admin')}}"> 首页</a>，或者返回 <a href="{{$previousUrl}}"> 上一页</a>~</p>
                    <pre class="page-403">
          .----.
       _.'__    `.
   .--($)($$)---/#\
 .' @          /###\
 :         ,   #####
  `-..__.-' _.-\###/
        `;_:    `"'
      .'"""""`.
     /,  ya ,\\
    //  403!  \\
    `-._______.-'
    ___`. | .'___
   (______|______)
        </pre>
                </div>
            </div>
        </div>

        @include('layouts.admin.partials._footer')
    </div>

@endsection