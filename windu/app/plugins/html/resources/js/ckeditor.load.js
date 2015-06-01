var editor, html = '';
var CKEDITOR_BASEPATH = './js/ckeditor/';

function loadEditor(id,editorType)
{

    var instance = CKEDITOR.instances[id];
    if(instance)
    {
        CKEDITOR.remove(instance);
    }
    editor = CKEDITOR;
    if($(window).width()<=768){editorType='mobile';}
    editor.config.toolbar = editorType;
    editor.config.enterMode = CKEDITOR.ENTER_BR;
    editor.config.entities = false;
    editor.config.basicEntities = false;
    editor.config.uiColor = '#e5e5e5';
    editor.config.height = '300';
    editor.config.allowedContent = true;

	editor.config.toolbar_full =
	[
	    ['Save','-','Source','NewPage','Preview','-','Templates'],
	    ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print', 'SpellChecker', 'Scayt'],
	    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
	    ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
	    '/',
	    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
	    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv','InsertPre'],
	    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
	    ['BidiLtr', 'BidiRtl'],
	    ['Link','Unlink','Anchor'],
	    ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak','Iframe'],
	    '/',
	    ['Styles','Format','Font','FontSize'],
	    ['TextColor','BGColor'],
	    ['Maximize', 'ShowBlocks','-','About']
	];
	
	editor.config.toolbar_normal =
	[
	    ['Save','-','Source'],
	    ['Cut','Copy','Paste','PasteText','PasteFromWord'],
	    ['Undo','Redo','-','Find','Replace','RemoveFormat'],
	    ['NumberedList','BulletedList','-','Outdent','Indent','CreateDiv','InsertPre'],
	    ['Flash','Iframe','Table','HorizontalRule','SpecialChar'],
	    
	    ['Bold','Italic','Underline','Strike'],
	    ['TextColor','FontSize','Format'],
	    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
	    ['Link','Unlink'],
	    
	    ['ShowBlocks','Maximize']
	];  

    	 	 
    editor.config.toolbar_basic =
    [
        ['Save','-','Source','Undo','Redo'],
        ['Bold','Italic','Underline', '-', 'NumberedList', 'BulletedList'],
        ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
        ['Link', 'Unlink'],
        ['Maximize']
    ];
 
    editor.config.toolbar_mobile =
        [
            ['Save','-','Source'],
            ['Bold','-', 'NumberedList', 'BulletedList'],
            ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
            ['Link', 'Unlink'],
            ['Maximize']
        ];    
    
    editor.config.toolbar_minimal_source =
		[
		    ['Save','Source','Bold', '-','Undo','Redo','-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink','-','Maximize']
		];		    
    
    editor.config.toolbar_minimal =
	[
	    ['Save','Bold', '-','Undo','Redo','-', 'NumberedList', 'BulletedList', '-', 'Link', 'Unlink','-','Maximize']
	];	    

	editor.replaceAll();  
}

