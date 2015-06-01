<?php
class formtextareaCodeMirrorEditorElement extends formElement
{
	public function render() {
		if($this->data['attributes']['mode']!=null){$mode=$this->data['attributes']['mode'];}else{$mode='smartymixed';}
		
		$form=NULL;
		$form.= $this->renderTitle();

		$form.="<textarea id='{$this->data['name']}CodeMirror' name='{$this->data['name']}' editor='CodeMirror'>{$this->data['value']}</textarea>";
		$form.="<script type='text/javascript' src='".HOME."app/plugins/html/resources/codemirror/lib/codemirror.js'></script>";
        $form.="<script type='text/javascript' src='".HOME."app/plugins/html/resources/codemirror/addon/edit/matchbrackets.js'></script>";
        $form.="<script type='text/javascript' src='".HOME."app/plugins/html/resources/codemirror/mode/clike/clike.js'></script>";

		$form.="<script type='text/javascript' src='".HOME."app/plugins/html/resources/codemirror/mode/xml/xml.js'></script>";
		$form.="<script type='text/javascript' src='".HOME."app/plugins/html/resources/codemirror/mode/javascript/javascript.js'></script>";
		$form.="<script type='text/javascript' src='".HOME."app/plugins/html/resources/codemirror/mode/css/css.js'></script>";
		$form.="<script type='text/javascript' src='".HOME."app/plugins/html/resources/codemirror/mode/htmlmixed/htmlmixed.js'></script>";
        $form.="<script type='text/javascript' src='".HOME."app/plugins/html/resources/codemirror/mode/php/php.js'></script>";


		$form.="<script type='text/javascript'> 
				$(document).ready(
				function(){
					  window.{$this->data['name']} = CodeMirror.fromTextArea(document.getElementById('{$this->data['name']}CodeMirror'), {
                        mode           : '{$mode}',
                        tabSize        : 2,
                        indentUnit     : 2,
                        indentWithTabs : false,
                        lineNumbers    : true,
                        lineWrapping   : true
					});
					}
				)
				</script>
				";

		return $form;
	}
}
?>