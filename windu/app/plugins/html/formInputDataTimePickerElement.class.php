<?php
class formInputDataTimePickerElement extends formElement
{
	public function render()
	{
		$form=NULL;
		$attributes = $this->data['attributes'];

		if ($attributes['class']!=null) {$class = "class='form_datetime {$attributes['class']}'";}
		$placeholder = $this->renderPlaceholder();
		$popover = $this->renderPopover();
		$tooltip = $this->renderTooltip();
		$error = $this->renderError();
		
		$form .= $this->renderTitle();
		$form .= "<div class='controls'>";
		$form .= '<div class="input-append date">';
		$form .= "<input type='text' name='{$this->data['name']}' value='".$this->data['value']."' id='datetimepicker-{$this->data['name']}' $class $popover $placeholder $tooltip>";
		$form .= '<span class="add-on"><i class="fa fa-calendar"></i></span>';
		$form .= '</div>';
		$form .= $error;
		$form .= "</div>";
		
		
		$form .='
		<script type="text/javascript" src="'.HOME.'app/plugins/html/resources/datetimepicker/bootstrap-datetimepicker.min.js"></script>
		<script>
			$("#datetimepicker-'.$this->data['name'].'").datetimepicker({format: "yyyy-mm-dd hh:ii"});
		</script>';
		
		return $form;
	}	
}