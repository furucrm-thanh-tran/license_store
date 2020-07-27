function customUploading(UploadedId, uploadedView) {
    var btnUpload = $(UploadedId),
    btnOuter = $(".button_outer");
    btnUpload.on("change", function(e) {
        var ext = btnUpload.val().split('.').pop().toLowerCase();
        if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
            $(".error_msg").text("Not an Image...");
        } else {
            $(".error_msg").text("");
            btnOuter.addClass("file_uploading");
            setTimeout(function() {
                btnOuter.addClass("file_uploaded");
            }, 1000);
            var uploadedFile = URL.createObjectURL(e.target.files[0]);
            setTimeout(function() {
                $(uploadedView).append('<img src="' + uploadedFile + '" />').addClass(
                    "show");
            }, 3500);
        }
    });
    $(".file_remove").on("click", function(e) {
        $(uploadedView).removeClass("show");
        $(uploadedView).find("img").remove();
        btnOuter.removeClass("file_uploading");
        btnOuter.removeClass("file_uploaded");
    });
};
