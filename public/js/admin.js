$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

(function ($) {
    'use strict';

    $(document).ready(function () {
        NProgress.start();
    });


    $(window).on('load', function () {
        NProgress.done();
    });


    $(function () {
        var $fullText = $('.admin-fullText');
        $('#admin-fullscreen').on('click', function () {
            $.AMUI.fullscreen.toggle();
        });

        $(document).on($.AMUI.fullscreen.raw.fullscreenchange, function () {
            $fullText.text($.AMUI.fullscreen.isFullscreen ? '退出全屏' : '开启全屏');
        });

        //切换栏目
        $("#change_system").change(function () {
            var url = $(this).val();
            location.href = url;
        })

        //全选
        $("#checked").click(function () {
            $('.checked_id').prop("checked", this.checked);
        });


        /**
         * 权限管理模块
         */
        $('.permission1').click(function () {
            var checked = $(this).prop('checked');
            $(this).parents('.am-panel-hd').next().find('input').prop('checked', checked);
        })

        $('.permission2').click(function () {
            var checked = $(this).prop('checked');
            $(this).parents('.permission-div2').next().find('input').prop('checked', checked);

            // //如果全部选中，自动选择一级
            var $body = $(this).parents('.am-panel-bd');
            var $panel = $(this).parents('.am-panel');
            // var length2 = $body.find('.permission2').length;
            var length2_checked = $body.find('.permission2:checked').length;

            //只要有一个二级被选中，一级自动被选中
            if (length2_checked > 0) {
                $panel.find(".permission1").prop('checked', true);
            } else {
                $panel.find(".permission1").prop('checked', false);
            }

        })

        //一级 二级多选框，自动全选
        $(".permissions3").click(function () {
            var $permission_div3 = $(this).parents('.permission-div3');
            var $permission_div2 = $permission_div3.siblings('.permission-div2');
            var $body = $(this).parents('.am-panel-bd');
            var $panel = $(this).parents('.am-panel');
            //
            // 如果有三级一个选中，自动选择二级
            // var length3 = $permission_div3.children().length;
            var length3_checked = $permission_div3.find("input:checked").length;
            if (length3_checked > 0) {
                $permission_div2.find(".permission2").prop('checked', true);
            } else {
                $permission_div2.find(".permission2").prop('checked', false);
            }
            //
            //如果二级有一个选中，自动选择一级
            // var length2 = $body.find('.permission2').length;
            var length2_checked = $body.find('.permission2:checked').length;
            if (length2_checked > 0) {
                $panel.find(".permission1").prop('checked', true);
            } else {
                $panel.find(".permission1").prop('checked', false);
            }
        })

    });


})(jQuery);