@extends('layouts.admin.partials.application')
@section('content')
    <div class="admin-content">
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">广告回收站</strong> /
                <small>Ad Trash</small>
            </div>
        </div>
        @include('layouts.admin.partials._flash')

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <button type="button" class="am-btn am-btn-default" id="force_destroy_checked">
                            <span class="am-icon-trash-o"></span> 删除
                        </button>
                        <button type="button" class="am-btn am-btn-success" id="restore_checked">
                            <span class="am-icon-reply"></span> 还原
                        </button>
                    </div>
                </div>
            </div>
            <div class="am-u-sm-12 am-u-md-3">
                <form method="get">
                    <div class="am-input-group am-input-group-sm">
                        <input type="text" class="am-form-field" name="keyword" value="{{Request::input('keyword')}}">
                        <span class="am-input-group-btn">
                            <button class="am-btn am-btn-default" type="submit">搜索</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>

        <div class="am-g">
            <div class="am-u-sm-12">
                <form class="am-form">
                    <table class="am-table am-table-striped am-table-hover table-main">
                        <thead>
                        <tr>
                            <th class="table-check"><input type="checkbox" id="checked"/></th>
                            <th class="table-id">编号</th>
                            <th class="table-title">缩略图</th>
                            <th class="table-url">标题</th>
                            <th class="table-desc">描述信息</th>
                            <th class="table-name">状态</th>
                            <th class="table-date am-hide-sm-only">删除日期</th>
                            <th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($spiders as $spider)
                            <tr>
                                <td><input type="checkbox" value="{{$spider->id}}" class="checked_id"
                                           name="checked_id[]"/>
                                </td>
                                <td class="ad_id">{{ $spider->id }}</td>
                                <td>
                                    <img style="height: 90px;width: 90px"  src="{{$spider->image}}" alt="">
                                </td>
                                <td><a href="{{$spider->url}}" target="_blank">{{$spider->title}}</a></td>
                                <td>{!! sub($spider->description) !!}</td>
                                <td>  {!! is_something('state', $spider) !!}</td>
                                <td>{{$spider->deleted_at}}</td>
                                <td>
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a class="am-btn am-btn-default am-btn-xs am-text-secondary"
                                               href="/tool/spider/{{$spider->id}}/restore">
                                                <span class="am-icon-reply"></span> 还原
                                            </a>
                                            <a class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"
                                               href="{{route('tool.spider.force_destroy', $spider->id)}}"
                                               data-method="delete" data-token="{{csrf_token()}}" data-confirm="确定删除吗？">
                                                <span class="am-icon-trash-o"></span> 删除
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>

                    共 {{$spiders->total()}} 条记录

                    <div class="am-cf">
                        <div class="am-fr">
                            {!! $spiders->links() !!}
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function () {
            //删除所选
            $('#force_destroy_checked').click(function () {
                var length = $(".checked_id:checked").length;
                if (length == 0) {
                    alert("您必须至少选中一条!");
                    return false;
                }

                var checked_id = $(".checked_id:checked").serialize();
                $.ajax({
                    type: "DELETE",
                    url: "/tool/spider/force_destroy_checked",
                    data: checked_id,
                    success: function (data) {
                        if (data.status == 0) {
                            alert(data.msg);
                            return false;
                        }
                        location.href = location.href;
                    }
                });
            });

            //还原所选
            $('#restore_checked').click(function () {
                var length = $(".checked_id:checked").length;
                if (length == 0) {
                    alert("您必须至少选中一条!");
                    return false;
                }

                var checked_id = $(".checked_id:checked").serialize();
                $.ajax({
                    type: "POST",
                    url: "/tool/spider/restore_checked",
                    data: checked_id,
                    success: function (data) {
                        if (data.status == 0) {
                            alert(data.msg);
                            return false;
                        }
                        location.href = location.href;
                    }
                });
            });

            //是否...
            $(".is_something").click(function () {
                var _this = $(this);
                var data = {
                    id: _this.parents("tr").data('id'),
                    attr: _this.data('attr')
                }

                $.ajax({
                    type: "PATCH",
                    url: "/tool/spider/is_something",
                    data: data,
                    success: function (data) {
                        if (data.status == 0) {
                            alert(data.msg);
                            return false;
                        }
                        _this.toggleClass('am-icon-close am-icon-check');
                    }
                });
            });
        });
    </script>
@endsection