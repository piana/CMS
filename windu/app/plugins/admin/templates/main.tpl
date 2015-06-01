<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		{foreach resourceManager::loadAdminCSS() as $cssFile}
			<link rel="stylesheet" href="{$cssFile}?ver={config::get('revision')}">
		{/foreach}						           
		<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
		
		<script type="text/javascript">
			window.HOME = "{$HOME}";
			window.SUBDIR = "{$smarty.const.SUBDIR}";
			window.TEMPLATE = "{config::get(template)}";
			window.MAX_UPLOAD_FILE_SIZE = "{generate::returnBytes($smarty.const.MAX_UPLOAD_FILE_SIZE)}";
		</script>
		{foreach resourceManager::loadAdminJS() as $jsFile}
			<script type="text/javascript" src="{$jsFile}?ver={config::get('revision')}"></script>
		{/foreach}
		
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
		<!--[if gte IE 8]><script src="{$HOME}image/resources/blueimp-jQuery-File-Upload/js/cors/jquery.xdr-transport.js"></script><![endif]-->
		<title>WinduCMS - Admin</title>
	</head>
{nocache}
    {assign bg config::get("backgroundAdmin{$loggedIn->id}")}
    {$configPomName = "pins-{$loggedIn->id}"}
    {$pins = unserialize(config::get($configPomName))}

    <body {if $bg!=null}style="background-color: #{$bg}"{/if}>
        <noscript><div class="alert">Your browser does not support JavaScript!</div></noscript>
        {include file='common/note_modal.tpl'}
        <div class="alert-waiting alert-popup alert-popup-blue"><img src="{$HOME}app/plugins/admin/resources/img/ajax-loader.gif" style="margin-top:2px;"></div>
        {include file='common/alert.tpl'}
        <div id="container" {if config::get("smallSidebar{$loggedUser->id}")==1}class="sidebar-small"{/if}>
            <div id="sidebar">
{/nocache}
                {include file='common/page_menu.tpl'}
{nocache}
            </div>
            <div id="content" {if is_array($pins)}class="content-margin-right"{/if}>
                <div class="top-right-menu">
                    <div class="user-dropdown">
                        {include file='common/top_right_buttons.tpl'}
                        {include file='common/tabs.tpl'}
                    </div>
                </div>
                {include file=$page_content}
                <div id="footer">
                    <div class="bottom-panel">
                        <div class="row-fluid">
                            <div class="span5 mobileHidden">
                                <a href="{$HOME}admin/mainDo/toggleConfig/smallSidebar{$loggedUser->id}/" class="toggleSidebar" data-toggle="tooltip" data-placement="top" data-original-title="{L key = 'admin.sidebar'}">{if config::get("smallSidebar{$loggedUser->id}")==1}<i class="fa fa-chevron-right icon-dark"></i>{else}<i class="fa fa-chevron-left icon-dark"></i>{/if}</a>
                                {if !cache::isCached($SITE_PATH,3600)}{cache::write($SITE_PATH,round(baseFile::getSize({$SITE_PATH})/1048576,2),'disSize')}{/if}
                                <i class="color-icons icons-network-ip-local">&nbsp;</i>&nbsp;{generate::ip()} &nbsp;&nbsp;
                                <i class="color-icons icons-database icon-margin">&nbsp;</i>{cache::read($SITE_PATH)} MB &nbsp;&nbsp;
                                <span class="smallWidthHidden">
                                    <i class="color-icons icons-databases icon-margin">&nbsp;</i>{round(baseFile::getSize($smarty.const.FILE_DB_PATH)/1048576,2)} MB &nbsp;&nbsp;
                                </span>
                            </div>
                            <div class="span2 mobileHidden" style="text-align:center;">
                                <div class="bottom-center-menu">
                                    <a class="top" href="#top" data-toggle="tooltip" data-placement="bottom" data-original-title="{L key = "admin.main.tpl.up"}"><i class="fa fa-arrow-circle-up icon-dark"></i></a>
                                    {if $REQUEST->getVariable('subpage')!=''}<a href="{$HOME}admin/mainDo/pinIt/{$REQUEST->getVariable('subpage')}/" data-toggle="tooltip" data-placement="bottom" data-original-title="{L key = 'admin.pinit'}"><i class="fa fa-tag icon-dark" ></i></a>{/if}
                                </div>
                            </div>
{/nocache}
                            <div class="span5">
                                <div class="btn-group dropup">
                                    {assign icon pagesDB::getMainImageEkey($smarty.const.LANG,'icon')}
                                    <span class="btn dropdown-toggle" data-toggle="dropdown">{if !empty($icon)}<img src="{$HOME}image/{$icon}/100/100/original/"> {/if}{$lang->name}</span>
                                    <ul class="dropdown-menu">
                                      {foreach $pagesDB->getPagesByParent('0',null,'position ASC','*',null,null,true) as $lang}
                                        <li>
                                            <a href="{$HOME}admin/mainDo/setLanguage/{$lang->id}/">
                                                <img src='{$HOME}app/plugins/admin/resources/img/flags/{strtolower($lang->name)}.png' class="flag-icon"> {$lang->name}
                                            </a>
                                        </li>
                                      {/foreach}
                                    </ul>
                                </div>
                                <div class="admin-themplates">
                                    <a href="{$HOME}admin/mainDo/setBackground/999/" style="background-color:#999;"></a>
                                    <a href="{$HOME}admin/mainDo/setBackground/292929/" style="background-color:#292929;"></a>
                                    <a href="{$HOME}admin/mainDo/setBackground/362c59/" style="background-color:#362c59;"></a>
                                    <a href="{$HOME}admin/mainDo/setBackground/209a54/" style="background-color:#209a54;"></a>
                                    <a href="{$HOME}admin/mainDo/setBackground/246bad/" style="background-color:#246bad;"></a>
                                    <a href="{$HOME}admin/mainDo/setBackground/9b8e87/" style="background-color:#9b8e87;"></a>
                                    <a href="{$HOME}admin/mainDo/setBackground/b36f45/" style="background-color:#b36f45;"></a>
                                    <a href="{$HOME}admin/mainDo/setBackground/932727/" style="background-color:#932727;"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer-desc">
                    {L key = "admin.main.tpl.design"} <strong>Adam Czajkowski</strong><br>Windu <span class="badge badge-white">3.1</span> rev: <strong>{config::get(revision)}</strong>
                </div>
            </div>
        </div>
    </body>
</html>