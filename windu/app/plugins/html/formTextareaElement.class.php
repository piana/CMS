<?php
class formTextareaElement extends formElement
{
	public function render() {
		if ($this->data['attributes']['class']!='') {$class = "class='{$this->data['attributes']['class']}'";}else{$class = "class='input-xxlarge-height'";}
		$form=NULL;
		$form.= $this->renderTitle();
		$form.= '<div class="controls">';
		$form.= "<textarea $class name='{$this->data['name']}'>{$this->data['value']}</textarea>";
		$form.= '</div>';
		return $form;
	}
}
?>