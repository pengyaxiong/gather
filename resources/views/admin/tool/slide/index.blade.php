@extends('layouts.admin.partials.application')
@section('content')
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">轮播图</strong> /
                <small>Slides Manage</small>
            </div>
        </div>


        @include('layouts.admin.partials._flash')

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <a type="button" class="am-btn am-btn-default" href="{{route('tool.slide.create')}}">
                            <span class="am-icon-plus"></span> 新增
                        </a>
                    </div>
                </div>
            </div>

            <div class="am-u-sm-12 am-u-md-3">
                <form id="show_form" action="{{route('tool.slide.index')}}" method="get">
                    <div class="am-input-group am-input-group-sm">
                        <div class="am-form-group">
                            <select data-am-selected="{ btnSize: 'sm', searchBox: 0}"
                                    name="is_show" onchange="javascript:$('#show_form').submit()">
                                <option value="-1">全部</option>
                                <option value="1" @if(1 == Request::input('is_show')) selected @endif>显示</option>
                                <option value="0" @if(0 == Request::input('is_show')) selected @endif>不显示</option>
                            </select>
                        </div>
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
                            <th class="table-id">编号</th>
                            <th class="table-thumb">缩略图</th>
                            <th class="table-is-show am-hide-sm-only">是否显示</th>
                            <th class="table-sort-order am-hide-sm-only" style="width:10%">排序</th>
                            <th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($slides as $slide)
                            <tr data-id="{{$slide->id}}">
                                <td>{{$slide->id}}</td>
                                <td>
                                    {!!  thumb_url($slide,['class'=>'thumb']) !!}
                                </td>

                                <td class="am-hide-sm-only">
                                    {!! is_something('is_show', $slide) !!}
                                </td>

                                <td class="am-hide-sm-only">
                                    <input type="text" name="sort_order" class="am-input-sm"
                                           value="{{$slide->sort_order}}">
                                </td>


                                <td>
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a class="am-btn am-btn-default am-btn-xs am-text-secondary"
                                               href="{{route('tool.slide.edit', $slide->id)}}">
                                                <span class="am-icon-pencil-square-o"></span> 编辑
                                            </a>

                                            <a class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"
                                               href="{{route('tool.slide.destroy', $slide->id)}}"
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

                    共 {{$slides->total()}} 条记录

                    <div class="am-cf">
                        <div class="am-fr">
                            {!! $slides->links() !!}
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
            //排序
            $("input[name='sort_order']").change(function () {
                var data = {
                    sort_order: $(this).val(),
                    id: $(this).parents("tr").data('id')
                };

                $.ajax({
                    type: "PATCH",
                    url: "/tool/slide/sort_order",
                    data: data,
                    success: function (data) {
                        if (data.status == 0) {
                            alert(data.msg);
                            return false;
                        }
                        location.href=location.href;
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
                    url: "/tool/slide/is_something",
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