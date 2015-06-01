<?php
//TODO integracja z chosen
class formAutocompleteSelectElement extends formElement
{
	public function render() {
		$form=NULL;
		$attributes = $this->data['attributes'];
		
		
		if ($attributes['class']!=null) {$class = "class='{$attributes['class']}'";}
		if ($attributes['multiple']==true) {$multiple = "multiple";}
		$placeholder = $this->renderPlaceholder();
		$popover = $this->renderPopover();
		$tooltip = $this->renderTooltip();
		$error = $this->renderError();
		
		$form .= $this->renderTitle();
		$form .= "<div class='controls'>";		
		$form .= "<select name='{$this->data['name']}' $class $popover $placeholder $tooltip $multiple>";
		
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
		$form .= "<script src='".HOME."app/plugins/html/resources/select2/select2.min.js' type='text/javascript'></script>";
		$form .= "<script type='text/javascript'>
		$('select[name=".'"'.$this->data['name'].'"'."]').select2();
		</script>";
		
		return $form;
	}
}
?>