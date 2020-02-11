@extends('layouts.admin.partials.application')
@section('css')
    <link rel="stylesheet" href="/vendor/daterangepicker/daterangepicker.css">
@endsection

@section('content')

    <div class="admin-content">
        <div class="admin-content-body">
            <div class="am-cf am-padding">
                <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">文件管理</strong> /
                    <small>File manage</small>
                </div>
            </div>
            @include("layouts.admin.partials._flash")
            <div class="am-g">
                <div class="am-u-sm-12 am-u-md-3">
                    <div class="am-btn-toolbar">
                        <div class="am-btn-group am-btn-group-xs">
                            <button type="button" class="am-btn am-btn-default  am-btn-sm am-form-file">
                                <i class="am-icon-cloud-upload" id="loading"></i> 上传文件
                                <input type="file" id="file_upload">
                            </button>
                        </div>
                    </div>
                </div>

                <div class="am-u-sm-12 am-u-md-8 am-u-sm-offset-1">
                    <form class="am-form-inline" role="form" method="get">
                        <div class="am-form-group">
                            <input type="text" name="name" id="name" class="am-form-field am-input-sm"
                                   placeholder="名称"
                                   value="{{ Request::input('name') }}">
                        </div>

                        <div class="am-form-group">
                            <input type="text" id="created_at" placeholder="修改时间" name="created_at"
                                   value="{{ Request::input('created_at') }}" class="am-form-field am-input-sm"/>
                        </div>

                        <div class="am-form-group">
                            <select data-am-selected="{btnWidth: '100%',  btnStyle: 'secondary', btnSize: 'sm', maxHeight: 360, searchBox: 1}"
                                    name="file_type" id="file_type">
                                <option value="-1">文件类型</option>
                                @foreach ($file_type as $type)
                                    <option value="{{$type}}"
                                            @if($type == Request::input('file_type')) selected @endif>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="am-btn am-btn-default am-btn-sm">查询</button>
                    </form>
                </div>

            </div>
            <div class="am-g">
                <div class="am-u-sm-12">
                    <form class="am-form" id="form">
                        <table class="am-table am-table-striped am-table-hover table-main">
                            <thead>
                            <tr>
                                <th class="table-id">序号</th>
                                <th class="table-name">名称</th>
                                <th>大小</th>
                                <th>类型</th>
                                <th>时间</th>
                                <th class="table-set">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($files as $k=>$file)
                                <tr>
                                    <th scope="row">{{$k+1}}</th>
                                    <td class="name">{{$file['name']}}</td>
                                    <td>{{$file['size']}}</td>
                                    <td>{{$file['type']}}</td>
                                    <td>{{$file['date']}}</td>
                                    <td>
                                        <div class="btn-group-xs" role="group" aria-label="...">
                                            @if($file['type']=="目录文件")
                                                <a class="am-btn am-btn-default am-btn-xs am-text-secondary"
                                                   href="javascript:void(0)">
                                                    <span class="am-icon-folder-open"></span>查看
                                                </a>
                                            @endif
                                            @if($file['type']=="普通文件"and $file['is_image']==false)
                                                <a class="edit_model am-btn am-btn-default am-btn-xs am-text-secondary"
                                                   href="{{route('system.photo.get_contents',$file['name'])}}">
                                                    <span class="am-icon-pencil-square-o"></span> 编辑
                                                </a>
                                            @endif
                                            @if($file['is_image']!=false)
                                                <a class="img_show am-btn am-btn-default am-btn-xs am-text-secondary"
                                                   href="javascript:void(0)" data-url="{{'/'.$file['name']}}"
                                                   data-am-modal="{target: '#img_show', closeViaDimmer: 0, width: 450, height: 275}">
                                                    <span class="am-icon-eye-slash"></span>预览
                                                </a>
                                            @endif
                                            <a class="am-btn am-btn-default am-btn-xs am-text-danger "
                                               href="{{route('system.photo.destroy_file',$file['name'])}}"
                                               data-method="delete"
                                               data-token="{{csrf_token()}}" data-confirm="确定要删除该文件?">
                                                <span class="am-icon-trash-o"></span> 删除
                                            </a>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        共 {{$files->total()}} 条记录

                        <div class="am-cf">
                            <div class="am-fr">
                                {{ $files->links()}}
                            </div>
                        </div>
                    </form>
                </div>

            </div>

        </div>
        @include('layouts.admin.partials._footer')
    </div>

    {{--img--}}
    <!-- Modal -->

    <div class="am-modal am-modal-no-btn" tabindex="-1" id="img_show" style=" top:40%;">
        <div class="am-modal-dialog">
            <div class="am-modal-hd">
                <a href="javascript: void(0)" class="am-close am-close-spin" data-am-modal-close>&times;</a>
            </div>
            <div class="am-modal-bd">
                <img src="" alt="" style=" width: 400px;height: 225px;">
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="/vendor/daterangepicker/moment.js"></script>
    <script src="/vendor/moment/locale/zh-cn.js"></script>
    <script src="/vendor/daterangepicker/daterangepicker.js"></script>
    <script src="/js/daterange_config.js"></script>
    <script src="/js/jquery.html5-fileupload.js"></script>
    <script>
        $(function () {
            //文件上传
            var opts = {
                url: "/system/photo/upload_public",
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
                    alert('上传成功');
                    location.href = location.href;
                },
                error: function (result, status, errorThrown) {
                    alert('文件上传失败');
                }
            }
            $('#file_upload').fileUpload(opts);

            $(document).on("click", ".img_show", function () {
                var url = $(this).data('url');
                $("#img_show img").attr('src', url);
            });
        })
    </script>
@endsection