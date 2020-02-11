@extends('layouts.admin.partials.application')
@section('admin.system') am-in @endsection
@section('admin.role.index') am-active @endsection

@section('content')
    <div class="admin-content">
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">用户组管理</strong> /
                <small>Good Brands</small>
            </div>
        </div>

        @include('layouts.admin.partials._flash')

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <a class="am-btn am-btn-default" href="{{ route('system.role.create') }}">
                            <span class="am-icon-plus"></span> 新增
                        </a>
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
                            <th class="table-id">编号</th>
                            <th class="table-thumb">用户组名</th>
                            <th>创建时间</th>
                            <th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($roles as $role)
                            <tr data-id="{{$role->id}}">
                                <td>{{$role->id}}</td>
                                <td>{{$role->name}}</td>
                                <td>{{$role->created_at}}</td>
                                <td>
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a class="am-btn am-btn-default am-btn-xs am-text-secondary"
                                               href="{{route('system.role.edit', $role->id)}}">
                                                <span class="am-icon-pencil-square-o"></span> 编辑
                                            </a>

                                            @if($role->id != '1')
                                                <a class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"
                                                   href="{{route('system.role.destroy', $role->id)}}" data-method="delete"
                                                   data-token="{{csrf_token()}}" data-confirm="确认删除吗?">
                                                    <span class="am-icon-trash-o"></span> 删除
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    共 {{$roles->total()}} 条记录

                    <div class="am-cf">
                        <div class="am-fr">
                            {!! $roles->appends(Request::all())->links() !!}
                        </div>
                    </div>
                    <hr/>
                </form>
            </div>
        </div>
    </div>
@endsection