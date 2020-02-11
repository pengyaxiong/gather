@extends('layouts.admin.partials.application')
@section('css')
    <link rel="stylesheet" href="/vendor/markdown/css/editormd.min.css"/>
@endsection

@section('content')

    <div class="admin-content">
        <div class="admin-content-body">
            <div class="am-cf am-padding">
                <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">文件编辑</strong> /
                    <small>File edit</small>
                </div>
            </div>
            @include("layouts.admin.partials._flash")
            <div class="am-g">
                <div class="am-u-sm-12">
                    <form class="am-form"  action="{{route('system.photo.update_file')}}" method="post" >
                        {{ csrf_field() }}
                        <div class="am-form-group">
                            <label for="name">
                                文件名称 <span class="am-badge am-badge-primary am-round">name</span>
                            </label>
                            <input type="text" name="name" id="name"value="{{$name}}">
                            <input type="hidden" name="old_name" value="{{$name}}">
                        </div>

                        <div class="am-form-group">
                            <label for="contents">
                                文件内容 <span class="am-badge am-badge-primary am-round">contents</span>
                            </label>
                            <div id="markdown">
                                <textarea rows="10" id="contents" name="contents">{{ $contents }} </textarea>
                            </div>
                        </div>

                        <div class="am-margin">
                            <a href="javascript:history.back(-1)" class="am-btn am-btn-default">返回</a>
                            <button type="submit" class="am-btn am-btn-primary">保存修改</button>
                        </div>

                    </form>
                </div>

            </div>

        </div>
        @include('layouts.admin.partials._footer')
    </div>
@endsection

@section('js')
    <script src="/vendor/markdown/editormd.min.js"></script>
    <script src="/js/editormd_config.js"></script>
    <script src="/js/jquery.html5-fileupload.js"></script>
    <script>
        $(function () {

        })
    </script>
@endsection