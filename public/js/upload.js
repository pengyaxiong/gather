//文件上传
var opts = {
    url: "/system/photo/upload",
    type: "POST",
    beforeSend: function () {
        $("#loading").attr("class", "am-icon-spinner am-icon-pulse");
    },
    success: function (result, status, xhr) {
        if (result.status == "0") {
            alert(result.msg);
            $("#loading").attr("class", "am-icon-cloud-upload");
            return false;
        }
        console.log(result);
        $("input[name='image']").val(result.image);
        $("#img_show").attr('src', result.image_url);
        $("#loading").attr("class", "am-icon-cloud-upload");
    },
    error: function (result, status, errorThrown) {
        alert('文件上传失败');
    }
}

$('#image_upload').fileUpload(opts);