@extends('layouts.admin.partials.application')
@section('css')
    <link rel="stylesheet" href="/vendor/daterangepicker/daterangepicker.css">
@endsection
@section('content')
    <div class="admin-content">
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">客户列表</strong> /
                <small>Customer Lists</small>
            </div>
        </div>

        @include('layouts.admin.partials._flash')

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-offset-6">
                <form class="am-form-inline" role="form" method="get">
                    <div class="am-form-group">
                        <input type="text" id="created_at" placeholder="选择时间日期" name="created_at"
                               value="{{ Request::input('created_at') }}" class="am-form-field am-input-sm"/>
                    </div>

                    <div class="am-form-group">
                        <input type="text" id="phone" placeholder="选择手机号" name="phone"
                               value="{{ Request::input('phone') }}" class="am-form-field am-input-sm"/>
                    </div>

                    <button type="submit" class="am-btn am-btn-default am-btn-sm">查询</button>
                </form>
            </div>
        </div>

        <div class="am-g">
            <div class="am-u-sm-12">
                <form class="am-form">

                    <table class="am-table am-table-striped am-table-hover table-main">
                        <thead>
                        <tr>
                            <th class="table-phone">手机号</th>
                            <th class="table-name">姓名</th>
                            <th class="table-name">是否可用</th>
                            <th class="table-time">注册时间</th>
                            <th class="table-set">操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($customers as $customer)
                            <tr data-id="{{$customer->id}}">
                                <td>{{$customer->phone}}</td>
                                <td>{{$customer->name}}</td>
                                <td>  {!! is_something('state', $customer) !!}</td>
                                <td>{{$customer->created_at}}</td>
                                <td>
                                    <div class="am-btn-toolbar">
                                        <div class="am-btn-group am-btn-group-xs">
                                            <a class="am-btn am-btn-default am-btn-xs am-text-secondary"
                                               href="{{route('cms.customer.edit', $customer->id)}}">
                                                <span class="am-icon-pencil-square-o"></span> 编辑
                                            </a>

                                            <a class="am-btn am-btn-default am-btn-xs am-text-danger am-hide-sm-only"
                                               href="{{route('cms.customer.destroy', $customer->id)}}"
                                               data-method="delete"
                                               data-token="{{csrf_token()}}" data-confirm="确认删除吗?">
                                                <span class="am-icon-trash-o"></span> 删除
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    共 {{$customers->total()}} 条记录

                    <div class="am-cf">
                        <div class="am-fr">
                            {!! $customers->appends(Request::all())->links() !!}
                        </div>
                    </div>
                    <hr/>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="/vendor/daterangepicker/moment.js"></script>
    <script src="/vendor/moment/locale/zh-cn.js"></script>
    <script src="/vendor/daterangepicker/daterangepicker.js"></script>
    <script src="/js/daterange_config.js"></script>
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
                    url: "/cms/customer/is_something",
                    data: data,
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