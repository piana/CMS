<?php
class formTextareaCKEditorElement extends formElement
{
	public function render() {
		$form=NULL;
		$form.= $this->renderTitle();

		$form.="<textarea id='{$this->data['name']}' name='{$this->data['name']}' class='noborder' editor='CKE'>{$this->data['value']}</textarea>";
		$form.="<script type='text/javascript' src='".HOME."app/plugins/html/resources/ckeditor/ckeditor.js'></script>";
		$form.="<script type='text/javascript' src='".HOME."app/plugins/html/resources/js/ckeditor.load.js'></script>";
		$form.="<script type='text/javascript'>
		
				$(document).ready(function(){loadEditor('{$this->data['name']}','{$this->data['attributes']['editorType']}');})
				function editorInsertText(value)
				{
					// Get the editor instance that we want to interact with.
					var oEditor = CKEDITOR.instances.{$this->data['name']};
				
					// Check the active editing mode.
					if ( oEditor.mode == 'wysiwyg' )
					{
						oEditor.insertHtml(value,'unfiltered_html');
					}
					else alert( 'You must be in WYSIWYG mode!' );
				}
				</script>";
		return $form;
	}
}
?>