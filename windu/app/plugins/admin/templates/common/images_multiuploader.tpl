<script type="text/javascript" src="{$HOME}app/plugins/image/resources/js/tmpl.min.js"></script>
<script type="text/javascript" src="{$HOME}app/plugins/image/resources/js/load-image.min.js"></script>
<script type="text/javascript" src="{$HOME}app/plugins/image/resources/js/canvas-to-blob.min.js"></script>
<script type="text/javascript" src="{$HOME}app/plugins/image/resources/blueimp-jQuery-File-Upload/js/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="{$HOME}app/plugins/image/resources/blueimp-jQuery-File-Upload/js/jquery.fileupload.js"></script>
<script type="text/javascript" src="{$HOME}app/plugins/image/resources/blueimp-jQuery-File-Upload/js/jquery.fileupload-ip.js"></script>
<script type="text/javascript" src="{$HOME}app/plugins/image/resources/blueimp-jQuery-File-Upload/js/jquery.fileupload-ui.js"></script>
<script type="text/javascript" src="{$HOME}app/plugins/image/resources/blueimp-jQuery-File-Upload/js/locale.js"></script>
<script type="text/javascript" src="{$HOME}app/plugins/image/resources/blueimp-jQuery-File-Upload/js/mainImage.js"></script>
<!--[if gte IE 8]><script src="{$HOME}app/plugins/image/resources/blueimp-jQuery-File-Upload/js/cors/jquery.xdr-transport.js"></script><![endif]-->

	<form id="imageupload" action="{$HOME}imageServerJsUpload/{$REQUEST->getVariable('id')}/" method="POST" enctype="multipart/form-data">
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="fileupload-loading"></div>
        <div class="fileupload-buttonbar">
            <div class="form-actions">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <span><i class="fa fa-plus "></i> {L key = "admin.images_multiuploader.tpl.addfiles"}</span>
                    <input type="file" name="files[]" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="icon-upload "></i> {L key = "admin.images_multiuploader.tpl.startupload"}
                </button>
                <button type="reset" class="btn btn-warning cancel">
                    <i class="fa fa-ban "></i> {L key = "admin.images_multiuploader.tpl.cancelupload"}
                </button>
                <a href="{$HOME}admin/do/reload/" type="reset" class="btn"  style="padding-left:5px; padding-right:5px;" >&nbsp;<i class="fa fa-refresh">&nbsp;</i>&nbsp;</a>   
				              
            </div>
            <div class="fileupload-loading"></div>
        </div>
        <!-- The loading indicator is shown during image processing -->
        
        <br>
        <!-- The table listing the files available for upload/download -->
        <table class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
    </form>
{literal}    
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
        <td class="name">{%=file.name.substring(0, 20)%}</td>
        <td class="size">{%=o.formatFileSize(file.size)%}</td>
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td>
                <div class="progress progress-success progress-striped active"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start" style="display:none;">{% if (!o.options.autoUpload) { %}
                <button class="btn btn-primary">
                    <i class="icon-upload "></i> {%=locale.fileupload.start%}
                </button>
            {% } %}</td>
        {% } else { %}
            <td colspan="2"></td>
        {% } %}
        <td class="cancel">{% if (!i) { %}
            <button class="btn btn-warning">
                <i class="fa fa-ban "></i> {%=locale.fileupload.cancel%}
            </button>
        {% } %}</td>
    </tr>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
        {% if (file.error) { %}
            <td></td>
            <td class="name">{%=file.name%}</td>
            <td class="size">{%=o.formatFileSize(file.size)%}</td>
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else { %}
            <td class="preview">{% if (file.url) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery" download="{%=file.name%}"><img src="{%=file.url%}"></a>
            {% } %}</td>
            <td class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
            </td>
            <td class="size">{%=o.formatFileSize(file.size)%}</td>
            <td colspan="2"></td>
        {% } %}
        <td>

        </td>
    </tr>
{% } %}
</script>
{/literal}


