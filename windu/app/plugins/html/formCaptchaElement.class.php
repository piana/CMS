<?php
class formCaptchaElement extends formElement
{
	public function render()
	{
		$form=NULL;
		$attributes = $this->data['attributes'];
		$this->data['title'] = lang::read('validator.captcha');

		if (is_array($this->ajaxValidators)) {
			foreach ($this->ajaxValidators as $ajaxValidator){
				$class .= $ajaxValidator.' ';
			}
		}
		
		if ($attributes['class']!=null or $class!=null) {$class = "class='$class {$attributes['class']}'";}

		$error = $this->renderError();
		
		$form .= $this->renderTitle();
		$form .= "<div class='controls'>";
		$form .= "<img src='".HOME."captcha/generate/image/'><br>";
		$form .= "<input type='text' name='{$this->data['name']}' $class $popover $placeholder $tooltip>";
		$form .= $error;
		$form .= "</div>";

		return $form;
	}	
}
	