<?php
function smarty_function_W($params,&$smarty)
{
	$user = usersDB::getLoggedUser('AdminUser');
	$inplaceConfigVarName =  "showInPlaceWidgetsBox{$user->id}";

	if ($user!=null and config::get($inplaceConfigVarName)==1 and config::get('leftOpenMenu')==1 and config::get('showLeftEditor'.$user->id)==1) {
		$cacheKeyParams = md5(serialize($params));
		$cacheValParams = cache::read($cacheKeyParams);
		if ($cacheValParams==null) {
			$cacheValParams = $params;
			cache::write($cacheKeyParams,$cacheValParams,'widgetsPanelEditor');
		}
		
		$cacheKeyTemplate = md5(serialize($smarty->source->filepath));
		$cacheValTemplate = cache::read($cacheKeyTemplate);
		if ($cacheValTemplate==null) {
			$cacheValTemplate = $smarty->source->filepath;
			cache::write($cacheKeyTemplate,$cacheValTemplate,'widgetsPanelEditor');
		}		
		
		$output .='<div class="widget" id="'.md5($params['name'].serialize($params)).'">';
		$output .='<div class="wname">'.$params['name'].'</div>';
		$output .='<div class="wparams">'.$cacheKeyParams.'</div>';
		$output .='<div class="wtemplate">'.$cacheKeyTemplate.'</div>';
		$output .= widgetLoader::loadWidgetByName($params,$smarty->get_template_vars('REQUEST'));
		$output .='</div>';
	}else{
		$output .= widgetLoader::loadWidgetByName($params,$smarty->get_template_vars('REQUEST'));
	}

 	return $output;
}
?>