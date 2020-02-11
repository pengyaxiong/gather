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
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">文章列表</strong> /
                <small>Article List</small>
            </div>
        </div>

        @include('layouts.admin.partials._flash')

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <a type="button" class="am-btn am-btn-default" href="{{route('cms.article.create')}}">
                            <span class="am-icon-plus"></span> 新增
                        </a>

                        <button type="button" class="am-btn am-btn-default" id="destroy_checked">
                            <span class="am-icon-trash-o"></span> 删除
                        </button>

                        <a  href="{{route('cms.article.trash')}}" type="button" class="am-btn am-btn-default">
                            <span class="am-icon-trash"></span> 回收站
                        </a>
                    </div>
                </div>
            </div>
            <div class="am-u-sm-12 am-u-md-3">
                <div class="am-form-group">
                    <select data-am-selected="{btnWidth: '80%',  btnStyle: 'secondary', btnSize: 'sm', maxHeight: 360, searchBox: 1}"
                            name="category_id" id="change_category">
                        <option value="-1">所有栏目</option>
                        @if(!empty($categories))
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                        @if($category->id == Request::input('category_id')) selected @endif>
                                    {!! indent_category($category->count) !!}{{ $category->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div class="am-u-sm-12 am-u-md-3">
                <form action="{{route('cms.article.index')}}" method="get">
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
                <form class="am-form" id="form">
                    <table class="am-table am-table-striped am-table-hover table-main">
                        <thead>
                        <tr>
                            <th class="table-check"><input type="checkbox" id="checked"/></th>
                            <th class="table-id">编号</th>
                            <th>缩略图</th>
                            <th class="table-title">标题</th>
                            <th class="table-category">所属栏目</th>
                            <th class="table-date am-hide-sm-only">发布日期</th>
                            <th class="table-top am-hide-sm-only">是否置顶</th>
                            <th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($articles as $article)
                            <tr data-id="{{$article->id}}">
                                <td><input type="checkbox" value="{{$article->id}}" class="checked_id"
                                           name="checked_id[]"/></td>
                                <td>{{$article->id}}</td>
                                <td class="article_thumb">
                                    <img src="{{$article->image}}" alt="" class="thumb">
                                </td>
                                <td>
                                    {{$article->title}}
                                </td>
                                <td>{{$article->category->name}}</td>
                                <td class="am-hide-sm-only">
                                    {{$article->created_at}}
                                </td>

                                <td class="am-hide-sm-only">
                                    {!! is_something('is_top', $article) !!}
                                </td>
                                <td>
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a class="am-btn am-btn-default am-btn-xs am-text-secondary"
                                               href="{{route('cms.article.edit', $article->id)}}">
                                                <span class="am-icon-pencil-square-o"></span> 编辑
                                            </a>

                                            <a class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"
                                               href="{{route('cms.article.destroy', $article->id)}}"
                                               data-method="delete" data-token="{{csrf_token()}}" data-confirm="确认删除吗?">
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
                    <hr/>
                </form>
            </div>

        </div>

    </div>
@endsection

@section('js')
    <script>
        $(function () {
            //删除所选
            $('#destroy_checked').click(function () {
                var length = $(".checked_id:checked").length;
                if (length == 0) {
                    alert("您必须至少选中一条!");
                    return false;
                }

                var checked_id = $(".checked_id:checked").serialize();

                $.ajax({
                    type: "DELETE",
                    url: "/cms/article/destroy_checked",
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
                    url: "/cms/article/is_something",
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

            //切换栏目
            $("#change_category").change(function () {
                var category_id = $(this).val();
                if (category_id == "-1") {
                    location.href = "{{route('cms.article.index')}}";
                    return false;
                }
                var url = "/cms/article?category_id=" + category_id;
                location.href = url;
            })
        });
    </script>
@endsection