@extends('layouts.admin.partials.application')
@section('css')
    <style>
        .thumb {
            max-height: 60px;
        }
    </style>
@endsection

@section('content')
    <div class="admin-content">
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">文章回收站</strong> /
                <small>Articles Trash</small>
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
        </div>

        <div class="am-g">
            <div class="am-u-sm-12">
                <form class="am-form">
                    <table class="am-table am-table-striped am-table-hover table-main">
                        <thead>
                        <tr>
                            <th class="table-check"><input type="checkbox" id="checked"/></th>
                            <th class="table-id">编号</th>
                            <th>缩略图</th>
                            <th class="table-title">标题</th>
                            <th class="table-category">所属栏目</th>
                            <th class="table-date am-hide-sm-only">发布日期 / 删除日期</th>
                            <th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($articles as $article)
                            <tr>
                                <td><input type="checkbox" value="{{$article->id}}" class="checked_id"
                                           name="checked_id[]"/>
                                </td>

                                <td class="article_id">{{ $article->id }}</td>
                                <td class="article_thumb">
                                    <img src="{{$article->image}}" alt="" class="thumb">
                                </td>
                                <td>{{ $article->title }}</td>
                                <td>{{ $article->category->name }}</td>
                                <td>{{$article->created_at}} / {{$article->deleted_at}}</td>
                                <td>
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a class="am-btn am-btn-default am-btn-xs am-text-secondary"
                                               href="/cms/article/{{$article->id}}/restore">
                                                <span class="am-icon-reply"></span> 还原
                                            </a>
                                            <a class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"
                                               href="/cms/article/{{$article->id}}/force_destroy"
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

                    共 {{$articles->total()}} 条记录

                    <div class="am-cf">
                        <div class="am-fr">
                            {!! $articles->links() !!}
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
                    url: "/cms/article/force_destroy_checked",
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
                    url: "/cms/article/restore_checked",
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
        });
    </script>
@endsection