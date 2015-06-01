<?php
class formSelectElement extends formElement
{
	public function render() {
		$form=NULL;
		$attributes = $this->data['attributes'];
		
		
		if ($attributes['class']!=null) {$class = "class='{$attributes['class']}'";}
		$placeholder = $this->renderPlaceholder();
		$popover = $this->renderPopover();
		$tooltip = $this->renderTooltip();
		$error = $this->renderError();
		
		$form .= $this->renderTitle();
		$form .= "<div class='controls'>";		
		$form .= "<select name='{$this->data['name']}' $class $popover $placeholder $tooltip>";
		
		$attributes = $this->data['attributes'];

		foreach ($attributes['option'] as $key => $option)
		{
			if ($attributes['key']=='false')
			{
				if ($option==$this->data['value']){$selected='selected';}else{$selected='';}
				$form .= "<option value='$option' $selected>$option</option>";				
			}
			else
			{
				if ($key==$this->data['value']){$selected='selected';}else{$selected='';}
				$form .= "<option value='$key' $selected>$option</option>";
			}
		}
		$form .= '</select>';
		$form .= $error;
		$form .= "</div>";		
		return $form;
	}
}
?>