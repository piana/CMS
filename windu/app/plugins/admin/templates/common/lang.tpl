<div class="tab-menu-top">
	<a href="{$HOME}admin/content/lang/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i></a>
	<h3 class="pull-left tab-title"> {L key = "admin.content.tpl.languages"}</h3>
	{*<a href="{$HOME}admin/do/content/vacummLanguages/" class="btn btn-small btn-warning"><i class="fa fa-plus  icon-margin">&nbsp;</i> Porządkuj tłumaczenia</a>*}
	<a href="{$HOME}admin/content/lang/addLang/" class="btn btn-small btn-primary"><i class="fa fa-plus  icon-margin">&nbsp;</i> {L key = "admin.lang.tpl.addlanguage"}</a>
</div>	
<div class="row-fluid">

  <div class="span{if is_object($formEditLangVariable) or is_object($formEditLang) or is_object($formAddLang)}9{else}12{/if}">
  	 	{if is_object($formEditLang)}
            <div class="box">
                <h5><i class="fa fa-pencil icon-margin icon-grey">&nbsp;</i> {L key = "admin.content.tpl.addlanguage"}</h5>
                {$formEditLang->toHtml()}
            </div>
		{else}
            <div class="box">
                <h5><i class="fa fa-pencil icon-margin icon-grey">&nbsp;</i> {L key = "admin.lang.tpl.editlangphrase"}</h5>
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th></th>
                      <th>{L key = "admin.lang.tpl.key"}</th>
                      {foreach $langs as $lang}
                      <th><a href="{$HOME}admin/content/lang/editLang/{$lang->name}/front.txt/"><i class="fa fa-edit">&nbsp;</i> {$lang->name}</a></th>
                      {/foreach}
                    </tr>
                  </thead>
                  <tbody>
                    {if $smarty.const.DEV_MODE}
                        {$langVariables = lang::prepareLanguageMultiArray('admin')}
                        {foreach $langVariables as $key => $langspom}
                            <tr id="langkey-id-{str_replace('.','_',$key)}" {if $key==$REQUEST->getVariable('id')}class="active"{/if}>
                              <td class="align-right"><span class="badge badge-primary">admin</span></td>
                              <td>
                                <a href="{$HOME}admin/content/lang/editLangAdminVariable/{$key}/#langkey-id-{str_replace('.','_',$key)}" class="badge badge-inverse">{$key|strip_tags}</a>
                              </td>
                              {foreach $langspom as $lang}
                              <td>{$lang|strip_tags|truncate:30}{if $lang==''}<span class="badge badge-important">{L key = "admin.lang.tpl.nodata"}</span>{/if}</td>
                              {/foreach}
                              <td>
                                <div class="buttons buttons-two">
                                    <a href="{$HOME}admin/content/lang/editLangAdminVariable/{$key}/#langkey-id-{str_replace('.','_',$key)}"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
                                    <span onclick="loadDoActionDelete('{$HOME}admin/do/content/deleteLanguageVariable/{str_replace('.','_',$key)}/','#langkey-id-{str_replace('.','_',$key)}',{if !usersDB::isDeveloper()}1{else}0{/if})"><i class="fa fa-times-circle icon-red">&nbsp;</i></span>
                                </div>
                              </td>
                            </tr>
                        {foreachelse}
                            <tr>
                                <td>
                                    {L key="admin.tools.tpl.banners.nodata"}
                                </td>
                            </tr>
                        {/foreach}
                    {/if}
                    {$langVariables = lang::prepareLanguageMultiArray()}
                    {foreach $langVariables as $key => $langspom}
                        <tr id="langkey-id-{str_replace('.','_',$key)}" {if $key==$REQUEST->getVariable('id')}class="active"{/if}>
                          <td class="align-right"><span class="badge badge-success">front</span></td>
                          <td>
                            <a href="{$HOME}admin/content/lang/editLangVariable/{$key}/#langkey-id-{str_replace('.','_',$key)}" class="badge badge-inverse">{$key}</a>
                          </td>
                          {foreach $langspom as $lang}
                          <td>{$lang|strip_tags|truncate:30}{if $lang==''}<span class="badge badge-important">{L key = "admin.lang.tpl.nodata"}</span>{/if}</td>
                          {/foreach}
                          <td>
                            <div class="buttons buttons-two">
                                <a href="{$HOME}admin/content/lang/editLangVariable/{$key}/#langkey-id-{str_replace('.','_',$key)}"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
                                <span onclick="loadDoActionDelete('{$HOME}admin/do/content/deleteLanguageVariable/{str_replace('.','_',$key)}/','#langkey-id-{str_replace('.','_',$key)}',{if !usersDB::isDeveloper()}1{else}0{/if})"><i class="fa fa-times-circle icon-red">&nbsp;</i></span>
                            </div>
                          </td>
                        </tr>
                    {foreachelse}
                        <tr>
                            <td>
                                {L key="admin.tools.tpl.banners.nodata"}
                            </td>
                        </tr>
                    {/foreach}
                    {foreach widgetsDB::getWidgetArray() as $widget}
                        {$langWidgetVariables = lang::prepareLanguageMultiArray('widget',$widget)}
                        {foreach $langWidgetVariables as $key => $langspom}
                            <tr id="langkey-id-{str_replace('.','_',$key)}" {if $key==$REQUEST->getVariable('id')}class="active"{/if}>
                              <td class="align-right">
                                <span class="badge badge-info">{$widget}</span>
                              </td>
                              <td>
                                <a href="{$HOME}admin/content/lang/editLangVariable/{$key}/#langkey-id-{str_replace('.','_',$key)}" class="badge badge-inverse">{$key}</a>
                              </td>
                              {foreach $langspom as $lang}
                              <td>{$lang|strip_tags|truncate:30}{if $lang==''}<span class="badge badge-important">{L key = "admin.lang.tpl.nodata"}</span>{/if}</td>
                              {/foreach}
                              <td>
                                <div class="buttons buttons-two">
                                    <a href="{$HOME}admin/content/lang/editLangVariableWidget/{$key}/{$widget}/#langkey-id-{str_replace('.','_',$key)}"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
                                    <span onclick="loadDoActionDelete('{$HOME}admin/do/content/deleteLanguageVariable/{str_replace('.','_',$key)}/','#langkey-id-{str_replace('.','_',$key)}',{if !usersDB::isDeveloper()}1{else}0{/if})"><i class="fa fa-times-circle icon-red">&nbsp;</i></span>
                                </div>
                              </td>
                            </tr>
                        {/foreach}
                    {/foreach}
                  </tbody>
                </table>
            </div>
		{/if}
  </div>
  {if is_object($formEditLangVariable) or is_object($formEditLang) or is_object($formAddLang)}
      <div class="span3">
        {if is_object($formEditLangVariable)}
            <div class="box-floating box">
                <h5><i class="fa fa-pencil icon-margin icon-grey">&nbsp;</i> {L key = "admin.lang.tpl.editphrase"} <span class="badge badge-inverse">{$REQUEST->getVariable('id')}</span></h5>
                {$formEditLangVariable->toHtml()}
            </div>
        {elseif is_object($formAddLang)}
          <div class="box-floating box">
            {$formAddLang->toHtml()}
          </div>
        {else}
            <div class="box box-floating">
                <h5><i class="icon-flag icon-margin icon-grey">&nbsp;</i> {L key = "admin.content.common.tpl.languages"}</h5>
                {include file='common/lang_list.tpl'}
            </div>
        {/if}
      </div>
  {/if}
</div> 
