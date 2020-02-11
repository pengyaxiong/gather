@extends('layouts.admin.partials.application')

@section('content')
    <div class="admin-content">

        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-primary am-text-lg">编辑广告</strong> /
                <small>Edit Ad</small>
            </div>
        </div>
        @include('layouts.admin.partials._flash')

        <div class="am-g">
            <div class="am-u-sm-12 am-u-md-12">

                <form class="am-form" action="{{ route('tool.spider.update', $spider->id) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            标题
                        </div>
                        <div class="am-u-sm-8 am-u-md-4">
                            <input type="text" class="am-input-sm" name="title" value="{{$spider->title}}">
                        </div>
                        <div class="am-hide-sm-only am-u-md-6">*必填，不可重复</div>
                    </div>

                    <div class="am-g am-margin-top sort">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            描述信息
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <textarea rows="4" name="description">{{$spider->description}}</textarea>
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            链接地址
                        </div>
                        <div class="am-u-sm-8 am-u-md-4  am-u-end col-end">
                            <input type="text" class="am-input-sm" name="url" placeholder="链接地址~"
                                   value="{{$spider->url}}">
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            缩略图
                        </div>

                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <div class="am-form-group am-form-file new_thumb">
                                <button type="button" class="am-btn am-btn-success am-btn-sm">
                                    <i class="am-icon-cloud-upload" id="loading"></i> 上传新的缩略图
                                </button>
                                <input type="file" id="image_upload">
                                <input type="hidden" name="image" value="{{$spider->image}}">
                            </div>

                            <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed" />

                            <div>
                                <img src="{{$spider->image}}" id="img_show" style="height: 90px;width: 90px">
                            </div>
                        </div>
                    </div>

                    <div class="am-g am-margin-top">
                        <div class="am-u-sm-4 am-u-md-2 am-text-right">
                            状态
                        </div>
                        <div class="am-u-sm-8 am-u-md-4 am-u-end col-end">
                            <label class="am-radio-inline">
                                <input type="radio" value="1" name="state" @if($spider->state) checked @endif > 显示
                            </label>
                            <label class="am-radio-inline">
                                <input type="radio" value="0" name="state" @if(!$spider->state) checked @endif> 隐藏
                            </label>
                        </div>
                    </div>

                    <div class="am-margin">
                        <button type="submit" class="am-btn am-btn-primary am-radius">提交保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="/js/jquery.html5-fileupload.js"></script>
    <script src="/js/upload.js"></script>
@endsection