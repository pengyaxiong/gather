@extends('layouts.admin.partials.application')
@include('UEditor::head')
@section('css')
@endsection
@section('content')
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">编辑</strong> /
                <small>Edit Notice</small>
            </div>
        </div>

        @include('layouts.admin.partials._flash')

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-12">

                <form class="am-form" action="{{ route('tool.notice.update', $notice->id) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            标题
                        </div>
                        <div class="am-u-sm-8 am-u-md-4">
                            <input type="text" class="am-input-sm" name="title" value="{{$notice->title}}">
                        </div>
                        <div class="am-hide-sm-only am-u-md-6">*必填，不可重复</div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            描述信息
                        </div>
                        <div class="am-u-sm-8 am-u-md-10 am-u-end col-end">
                            <textarea rows="4" name="description">{{$notice->description}}</textarea>
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            内容
                        </div>
                        <div class="am-u-sm-8 am-u-md-10 am-u-end col-end">
                            <script id="container" name="markdown_html_code"
                                    type="text/plain">{!! $notice->markdown_html_code !!}</script>
                        </div>
                    </div>

                    <div class="am-margin">
                        <button type="submit" class="am-btn am-btn-primary am-radius">提交保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('js')
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('container', {
            //	 initialFrameWidth : 900,//文本框宽和高
            // initialFrameHeight: '100%',//文本框宽和高
            initialFrameHeight: 400,//文本框宽和高
            //scaleEnabled:true,
            textarea: 'content',//[默认值：'editorValue'] // 提交表单时，服务器获取编辑器提交内容的所用的参数，
        });
        ue.ready(function () {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
        });
    </script>
@endsection