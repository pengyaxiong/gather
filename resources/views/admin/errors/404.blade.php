@extends('layouts.admin.partials.base')

@section('title','404')

@section('pageHeader','错误')

@section('pageDesc','页面找不到')

@section('content')
    <div class="admin-content">
        <div class="admin-content-body">
            <div class="am-cf am-padding am-padding-bottom-0">
                <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">404</strong> / <small>That’s an error</small></div>
            </div>

            <hr>

            <div class="am-g">
                <div class="am-u-sm-12">
                    <h2 class="am-text-center am-text-xxxl am-margin-top-lg">404. Not Found</h2>
                    <p class="am-text-center">没有找到你要的页面</p>
                    <p class="am-text-center">你可以返回<a href="{{route('admin')}}"> 首页</a>，或者返回 <a href="{{$previousUrl}}"> 上一页</a>~</p>
                    <pre class="page-404">
          .----.
       _.'__    `.
   .--($)($$)---/#\
 .' @          /###\
 :         ,   #####
  `-..__.-' _.-\###/
        `;_:    `"'
      .'"""""`.
     /,  ya ,\\
    //  404!  \\
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


@section('js')

@endsection