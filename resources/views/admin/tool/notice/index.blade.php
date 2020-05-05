@extends('layouts.admin.partials.application')
@section('content')
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">公告</strong> /
                <small>Notice Manage</small>
            </div>
        </div>


        @include('layouts.admin.partials._flash')

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <a type="button" class="am-btn am-btn-default" href="{{route('tool.notice.create')}}">
                            <span class="am-icon-plus"></span> 新增
                        </a>
                    </div>
                </div>
            </div>


            <div class="am-u-sm-12 am-u-md-3">
                <form action="{{route('tool.notice.index')}}" method="get">
                    <div class="am-input-group am-input-group-sm">
                        <input type="search" class="am-form-field" name="keyword" value="{{Request::input('keyword')}}">
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
                            <th class="table-id">编号</th>
                            <th class="table-name">标题</th>
                            <th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($notices as $notice)
                            <tr data-id="{{$notice->id}}">
                                <td>{{$notice->id}}</td>
                                <td>
                                    {{$notice->title}}
                                </td>

                                <td>
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a class="am-btn am-btn-default am-btn-xs am-text-secondary"
                                               href="{{route('tool.notice.edit', $notice->id)}}">
                                                <span class="am-icon-pencil-square-o"></span> 编辑
                                            </a>

                                            <a class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"
                                               href="{{route('tool.notice.destroy', $notice->id)}}"
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

                    共 {{$notices->total()}} 条记录

                    <div class="am-cf">
                        <div class="am-fr">
                            {!! $notices->links() !!}
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

    </script>
@endsection