<?php /* Smarty version Smarty-3.1.18, created on 2015-05-21 10:55:17
         compiled from "C:\xampp\htdocs\windu\app\plugins\admin\templates\common\files_multiuploader.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2656555d9d75a84611-75969014%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f49dec1eb721d51ba7716064bf16cfa3e43de834' => 
    array (
      0 => 'C:\\xampp\\htdocs\\windu\\app\\plugins\\admin\\templates\\common\\files_multiuploader.tpl',
      1 => 1398323024,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2656555d9d75a84611-75969014',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'HOME' => 0,
    'bucket' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_555d9d75ae2223_56097744',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555d9d75ae2223_56097744')) {function content_555d9d75ae2223_56097744($_smarty_tpl) {?><?php if (!is_callable('smarty_function_L')) include 'C:\\xampp\\htdocs\\windu/data/functions\\function.L.php';
?><script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/plugins/image/resources/js/tmpl.min.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/plugins/image/resources/js/load-image.min.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/plugins/image/resources/js/canvas-to-blob.min.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/plugins/image/resources/blueimp-jQuery-File-Upload/js/jquery.iframe-transport.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/plugins/image/resources/blueimp-jQuery-File-Upload/js/jquery.fileupload.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/plugins/image/resources/blueimp-jQuery-File-Upload/js/jquery.fileupload-ip.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/plugins/image/resources/blueimp-jQuery-File-Upload/js/jquery.fileupload-ui.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/plugins/image/resources/blueimp-jQuery-File-Upload/js/locale.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/plugins/image/resources/blueimp-jQuery-File-Upload/js/mainFile.js"></script>
<!--[if gte IE 8]><script src="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
app/plugins/image/resources/blueimp-jQuery-File-Upload/js/cors/jquery.xdr-transport.js"></script><![endif]-->

	<form id="fileupload" action="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
fileServerJsUpload/<?php echo $_smarty_tpl->tpl_vars['bucket']->value;?>
/" method="POST" enctype="multipart/form-data">
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="fileupload-buttonbar">
            <div class="form-actions">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <span><i class="fa fa-plus "></i> <?php echo smarty_function_L(array('key'=>"admin.images_multiuploader.tpl.addfiles"),$_smarty_tpl);?>
</span>
                    <input type="file" name="files[]" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="icon-upload "></i> <?php echo smarty_function_L(array('key'=>"admin.images_multiuploader.tpl.startupload"),$_smarty_tpl);?>

                </button>
                <button type="reset" class="btn btn-warning cancel">
                    <i class="fa fa-ban "></i> <?php echo smarty_function_L(array('key'=>"admin.images_multiuploader.tpl.cancelupload"),$_smarty_tpl);?>

                </button>
                <a href="<?php echo $_smarty_tpl->tpl_vars['HOME']->value;?>
admin/do/reload/" type="reset" class="btn"  style="padding-left:5px; padding-right:5px;" >&nbsp;<i class="fa fa-refresh">&nbsp;</i>&nbsp;</a>   
				              
            </div>
            <div>
                <!-- The global progress bar -->
                <div class="progress progress-success progress-striped active fade">
                    <div class="bar" style="width:0%;"></div>
                </div>
            </div>
        </div>
        <!-- The loading indicator is shown during image processing -->
        <div class="fileupload-loading"></div>
        <br>
        <!-- The table listing the files available for upload/download -->
        <table class="table table-striped"><tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody></table>
    </form>
    
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td class="preview"><span class="fade"></span></td>
        <td class="name">{%=file.name%}</td>
        <td class="size">{%=o.formatFileSize(file.size)%}</td>
        {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else if (o.files.valid && !i) { %}
            <td>
                <div class="progress progress-success progress-striped active"><div class="bar" style="width:0%;"></div></div>
            </td>
            <td class="start">{% if (!o.options.autoUpload) { %}
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
            <td class="name">{%=file.name%}</td>
            <td class="size">{%=o.formatFileSize(file.size)%}</td>
            <td class="error" colspan="2"><span class="label label-important">{%=locale.fileupload.error%}</span> {%=locale.fileupload.errors[file.error] || file.error%}</td>
        {% } else { %}
            <td class="preview"></td>
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



<?php }} ?>
