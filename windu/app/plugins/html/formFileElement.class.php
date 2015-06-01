<?php
class formFileElement extends formElement
{
	public function render()
	{
		$form=NULL;
		$attributes = $this->data['attributes'];
			
			if ($attributes['class']!=null) {$class = "class='{$attributes['class']}'";}
			$placeholder = $this->renderPlaceholder();
			$popover = $this->renderPopover();
			$tooltip = $this->renderTooltip();
			$error = $this->renderError();
			
			$form .= $this->renderTitle();
			$form .= "<div class='controls'>";
			$form .= "<input type='file' name='{$this->data['name']}' value='{$this->data['value']}' $class $popover $placeholder $tooltip>";
			$form .= $error;
			$form .= "</div>";

		return $form;
	}	
}
	