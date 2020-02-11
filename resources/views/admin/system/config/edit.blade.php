@extends('layouts.admin.partials.application')
@section('content')
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">系统设置</strong> /
                <small>System Config</small>
            </div>
        </div>

        @include('layouts.admin.partials._flash')
        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-12">

                <div class="am-tab-panel">

                    <form class="am-form " action="{{route('system.config.update')}}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                网站名称 <span class="am-badge am-badge-success am-round">title</span>
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <textarea rows="2" name="title">{{$config->title}}</textarea>
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                关键词 <span class="am-badge am-badge-warning am-round">keyword</span>
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <textarea rows="3" name="keyword">{{$config->keyword}}</textarea>
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                描述信息 <span class="am-badge am-badge-primary am-round">description</span>
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <textarea rows="4" name="description">{{$config->description}}</textarea>
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                网站图标 <span class="am-badge am-badge-secondary am-round">shortcut icon</span>
                            </div>

                            <div class="am-u-sm-4 am-u-md-3">

                                <div class="am-form-group am-form-file">
                                    <button type="button" class="am-btn am-btn-success am-btn-sm">
                                        <i class="am-icon-cloud-upload" id="loading"></i> 选择要上传的图标
                                    </button>
                                    <input type="file" id="image_upload">
                                </div>
                            </div>

                            <div class="am-u-sm-4 am-u-md-6">
                                <img src="/favicon.ico?{!! get_millisecond() !!}" id="img_show" style="max-height: 50px;">
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                ICP备案号
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="text" class="am-input-sm" name="icp" value="{{$config->icp}}">
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                版权信息
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="text" class="am-input-sm" name="copyright" value="{{$config->copyright}}">
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                管理员
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="text" class="am-input-sm" name="author" value="{{$config->author}}">
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                公司名
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="text" class="am-input-sm" name="company" value="{{$config->company}}">
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                QQ
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="text" class="am-input-sm" name="qq" value="{{$config->qq}}">
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                电子邮件
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="text" class="am-input-sm" name="email" value="{{$config->email}}">
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                手机
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="text" class="am-input-sm" name="mobile"
                                       value="{{$config->mobile}}">
                            </div>
                        </div>

                        <div class="am-g am-margin-top">
                            <div class="am-u-sm-4 am-u-md-3 am-text-right">
                                固定电话
                            </div>
                            <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                                <input type="text" class="am-input-sm" name="telephone" value="{{$config->telephone}}">
                            </div>
                        </div>
                        <div class="am-margin">
                            <button type="submit" class="am-btn am-btn-primary">保存修改</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="/js/jquery.html5-fileupload.js"></script>
    <script>
        //文件上传
        var opts = {
            url: "/system/photo/upload_icon",
            type: "POST",
            beforeSend: function () {
                $("#loading").attr("class", "am-icon-spinner am-icon-pulse");
            },
            success: function (result, status, xhr) {
                if (result.status == "0") {
                    alert(result.msg);
                    $("#loading").attr("class", "am-icon-cloud-upload");
                    return false;
                }

                $("#loading").attr("class", "am-icon-cloud-upload");
                var src = '/favicon.ico?' + Math.random();
                $("#img_show").attr('src', src);
            },
            error: function (result, status, errorThrown) {
                alert('文件上传失败');
            }
        }
        $('#image_upload').fileUpload(opts);
    </script>
@endsection