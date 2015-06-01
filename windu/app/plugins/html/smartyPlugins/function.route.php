<?php
function smarty_function_route($params, &$smarty) {
	$parameters = array();
	if (isset($params['parameters'])) parse_str($params['parameters'], $parameters);
	
	$target = $params['name'];
	if (isset($params['renderer'])) $target = array($params['name'], $params['renderer']);

	
	return router::route($target,$parameters);
}
?>