<?php
//TODO integracja z chosen
class formAutocompleteInputElement extends formElement
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
		$form .= "<input type='hidden' name='{$this->data['name']}' value='{$this->data['value']}' $class $popover $placeholder $tooltip >";
		
		$attributes = $this->data['attributes'];

		foreach ($attributes['option'] as $option)
		{
			$finalOptions .= '"'.$option.'",';
		}
		$finalOptions = rtrim($finalOptions,',');
		$form .= $error;
		$form .= "</div>";	
		$form .= "<script src='".HOME."app/plugins/html/resources/select2/select2.min.js' type='text/javascript'></script>";
		$form .= "<script type='text/javascript'>
		$('input[name=".'"'.$this->data['name'].'"'."]').select2({tags:[{$finalOptions}]});
 		$('input[name=".'"'.$this->data['name'].'"'."]').select2('container').find('ul.select2-choices').sortable({
                containment: 'parent',
                start: function() { $('input[name=".'"'.$this->data['name'].'"'."]').select2('onSortStart'); },
                update: function() { $('input[name=".'"'.$this->data['name'].'"'."]').select2('onSortEnd'); }
            });		
		</script>";
		
		return $form;
	}
}
?>