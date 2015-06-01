<?php
abstract class formElement
{
	public $data;
	public $errors;
	
	public function __construct($name, $title, $value, $type,  $attributes)
	{
		$this->data['name'] = $name;
		$this->data['title'] = $title;
		$this->data['value'] = $value;
		$this->data['type'] = $type;
		$this->data['attributes'] = $attributes;
		$this->errors = array();
	}
	
	protected function renderTitle()
	{
		$title = null;
		
		$style="control-label";

		if($this->data['title']!=NULL)
		{
			$title.= "<label class='$style'>{$this->data['title']}</label>";
		}

		return $title;
	}
	protected function renderPopover() {
		$popover = null;
		if ($this->data['attributes']['popover']!=null){
			$popover = "data-toggle='popover' data-original-title='{$this->data['attributes']['popover']}' data-placement='right'";
		}
		return $popover;
	}
	protected function renderTooltip() {
		$tooltip = null;
		if ($this->data['attributes']['tooltip']!=null){
			$tooltip = "data-toggle='tooltip' data-original-title='{$this->data['attributes']['tooltip']}' data-placement='right'";
		}
		return $tooltip;
	}	
	protected function renderPlaceholder() {
		$placeholder = null;
		if ($this->data['attributes']['placeholder']!=null){
			$placeholder = "placeholder='{$this->data['attributes']['placeholder']}'";
		}
		return $placeholder;
	}
	protected function renderError() {
		$error = null;
		if (count($this->errors)>0){
			$error = "<span class='label label-important label-form-error'>{$this->errors[0]}</span>";
		}
		return $error;
	}	
	public function setError($error)
	{
		$this->errors[] = $error;
	}
	public function setAjaxValidator($validator)
	{
		if ($validator == 'numeric') {
			$validator = 'number';
		}
		$this->ajaxValidators[] = $validator;	
	}
	public function toArray()
	{
		return $this->data;	
	}
}
	