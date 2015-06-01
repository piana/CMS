<?php
function smarty_function_L($params, $template)
{
 	return lang::read($params['key']);
}
?>