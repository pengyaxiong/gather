@extends('layouts.admin.partials.application')

@section('css')
    {{--<link rel="stylesheet" href="/vendor/markdown/css/editormd.min.css"/>--}}
@endsection
@section('content')
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">新增栏目</strong> /
                <small>Create A New Category</small>
            </div>
        </div>

        @include('layouts.admin.partials._flash')

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-12">

                <form class="am-form" action="{{ route('cms.category.store') }}" method="post">
                    {{ csrf_field() }}

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            上级分类
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <select data-am-selected="{btnWidth: '100%',  btnStyle: 'secondary', btnSize: 'sm', maxHeight: 360, searchBox: 1}"
                                    name="parent_id">
                                <option value="0">顶级分类</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {!! indent_category($category->count) !!}{{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            分类名称
                        </div>
                        <div class="am-u-sm-8 am-u-md-4">
                            <input type="text" class="am-input-sm" name="name">
                        </div>
                        <div class="am-hide-sm-only am-u-md-6">*必填，不可重复</div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            描述信息
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <textarea rows="4" name="description"></textarea>
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            URL跳转地址
                        </div>
                        <div class="am-u-sm-8 am-u-md-4  am-u-end col-end">
                            <input type="text" class="am-input-sm" name="url" placeholder="URL跳转地址~">
                        </div>
                    </div>

                    <div class="am-g am-margin-top sort">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            排序
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <input type="text" name="sort_order" class="am-input-sm" value="99">
                        </div>
                    </div>


                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            显示在导航栏
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <label class="am-radio-inline">
                                <input type="radio" value="1" name="is_show" checked> 是
                            </label>
                            <label class="am-radio-inline">
                                <input type="radio" value="0" name="is_show"> 否
                            </label>
                        </div>
                    </div>


                    {{--<div class="am-g am-margin-top-sm">--}}
                        {{--<div class="am-u-sm-12 am-u-md-2 am-text-right admin-form-text">--}}
                            {{--栏目内容--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    {{--<div class="am-g am-margin-top-sm">--}}
                        {{--<div class="am-u-sm-12 am-u-md-12">--}}
                            {{--<div id="markdown">--}}
                                {{--<textarea rows="10" name="content" style="display:none;"></textarea>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                    <div class="am-margin">
                        <button type="submit" class="am-btn am-btn-primary am-radius">提交保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('js')
    {{--<script src="/js/jquery.html5-fileupload.js"></script>--}}
    {{--<script src="/js/upload.js"></script>--}}
    {{--<script src="/vendor/markdown/editormd.min.js"></script>--}}
    {{--<script src="/js/editormd_config.js"></script>--}}
@endsection