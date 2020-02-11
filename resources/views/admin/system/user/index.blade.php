@extends('layouts.admin.partials.application')

@section('content')
    <div class="admin-content">
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">员工管理</strong> /
                <small>User Lists</small>
            </div>
        </div>

        @include('layouts.admin.partials._flash')

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-6">
                <div class="am-btn-toolbar">
                    <div class="am-btn-group am-btn-group-xs">
                        <a class="am-btn am-btn-default" href="{{ route('system.user.create') }}">
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
                            <th class="table-thumb">用户名</th>
                            <th class="table-thumb">真实姓名</th>
                            <th class="table-thumb">所属用户组</th>
                            <th class="table-name">手机号</th>
                            <th class="table-name">邮箱</th>
                            <th class="table-name">状态</th>
                            <th>创建时间</th>
                            <th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                            <tr data-id="{{$user->id}}">
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->real_name}}</td>
                                <td>{{$user->roles->implode('name', ', ')}}</td>
                                <td>{{$user->phone}}</td>
                                <td>{{$user->email}}</td>
                                <td>  {!! is_something('state', $user) !!}</td>
                                <td>{{$user->created_at}}</td>
                                <td>
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a class="am-btn am-btn-default am-btn-xs am-text-secondary"
                                               href="{{route('system.user.edit', $user->id)}}">
                                                <span class="am-icon-pencil-square-o"></span> 编辑
                                            </a>

                                            @if($user->id != '1')
                                                <a class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"
                                                   href="{{route('system.user.destroy', $user->id)}}" data-method="delete"
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

                    共 {{$users->total()}} 条记录

                    <div class="am-cf">
                        <div class="am-fr">
                            {!! $users->appends(Request::all())->links() !!}
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
        //是否...
        $(".is_something").click(function () {
            var _this = $(this);
            var data = {
                id: _this.parents("tr").data('id'),
                attr: _this.data('attr')
            }

            $.ajax({
                type: "PATCH",
                url: "/system/user/is_something",
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