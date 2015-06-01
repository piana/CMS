<?php
class formInputElement extends formElement
{
	public function render()
	{
		$form=NULL;
		$attributes = $this->data['attributes'];
		if ($this->data['type']=='hidden'){
			$form .= "<input type='{$this->data['type']}' name='{$this->data['name']}' value='{$this->data['value']}'>";
		}
		elseif ($this->data['type']=='checkbox' or $this->data['type']=='radio')
		{
			if ($this->data['type']=='radio' and isset($attributes['group']))
			{
				$form .= "<div class='controls'>";
				$form .= "<label class='radio'>";
				$form .= "<input type='{$this->data['type']}' name='{$attributes['group']}' value='{$this->data['value']}'>";	
				$form .= $this->data['title'];
				$form .= "</label>";
				$form .= "</div>";	
			}
			else
			{
				$form .= "<div class='controls'>";
				$form .= "<label class='checkbox'>";
				if ($attributes['checkbox-selected']) {
					$checked = "checked='checked'";
				}else{
					$checked = "";
				}
				$form .= "<input type='{$this->data['type']}' name='{$this->data['name']}' value='1' $checked>";	
				$form .= $this->data['title'];
				$form .= "</label>";
				$form .= "</div>";	
			}
		}
		else
		{
			if (is_array($this->ajaxValidators)) {
				foreach ($this->ajaxValidators as $ajaxValidator){
					$class .= $ajaxValidator.' ';
				}
			}
			
			if ($attributes['class']!=null or $class!=null) {$class = "class='$class {$attributes['class']}'";}
			$placeholder = $this->renderPlaceholder();
			$popover = $this->renderPopover();
			$tooltip = $this->renderTooltip();
			$error = $this->renderError();
			
			$form .= $this->renderTitle();
			$form .= "<div class='controls'>";
			$form .= "<input type='{$this->data['type']}' name='{$this->data['name']}' value='{$this->data['value']}' $class $popover $placeholder $tooltip>";
			$form .= $error;
			$form .= "</div>";
		}
		return $form;
	}	
}
	