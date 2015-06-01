$(function () {
    'use strict';
    $('#imageupload').fileupload({maxFileSize: window.MAX_UPLOAD_FILE_SIZE,acceptFileTypes: /(png)|(jpe?g)|(gif)$/i});
    $('#imageupload').fileupload({previewMaxWidth: 50});
    $('#imageupload').fileupload({previewMaxHeight: 40});
    $('#imageupload').bind('fileuploadstopped', function (e, data) {location.reload();});   

});