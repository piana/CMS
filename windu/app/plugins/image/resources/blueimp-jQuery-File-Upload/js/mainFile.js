$(function () {
    'use strict';
    $('#fileupload').fileupload({maxFileSize: window.MAX_UPLOAD_FILE_SIZE});
    $('#fileupload').bind('fileuploadstopped', function (e, data) {location.reload();});   
});