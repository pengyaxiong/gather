@extends('layouts.admin.partials.application')
@include('UEditor::head')
@section('content')
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">关于我们</strong> /
                <small>Company Info</small>
            </div>
        </div>

        @include('layouts.admin.partials._flash')
        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-12">

                <div class="am-tab-panel">

                    <form class="am-form " action="{{route('tool.about.update')}}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="am-form-group">
                            <label for="doc-ipt-email-1"> </label>
                            <script id="container" name="markdown_html_code"
                                    type="text/plain">{!! $about->markdown_html_code !!}</script>
                        </div>
                        <button type="submit" class="am-btn am-btn-primary">保存修改</button>
                    </form>
                </div>
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