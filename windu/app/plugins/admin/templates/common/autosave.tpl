<div class="tab-menu-top">
	<a href="{$HOME}admin/content/autosave/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i></a>
	<h3 class="pull-left tab-title"> {L key = "admin.content.tpl.autosave"}</h3>
	<a href="{$HOME}admin/do/content/deleteAllAutosaves/" class="btn btn-small btn-danger"><i class="fa fa-trash-o icon-margin ">&nbsp;</i> {L key = "admin.content.tpl.deleteallautosaves"}</a>
</div>
{$pagesbackups = $pagesbackupsDB->getBackupes("pageId = 0")}

{if count($pagesbackups)==0}
    <div class="center-box align-center">
        <i class="fa fa-save fa-6x icon-dark"></i>
        <h4>Brak autozapisów</h4>
    </div>
{else}
    <div class="row-fluid">
      <div class="span4">
        <div class="box">
            <h5><i class="fa fa-plus-circle icon-margin icon-grey">&nbsp;</i> {L key = "admin.content.tpl.autosave"}</h5>
            <table class="table table-striped tablesort">
                <tbody>
                {foreach $pagesbackups as $autosave}
                    {$contentToDisplay = unserialize($autosave->pageContent)}
                    <tr {if $autosave->id==$showAutosaveId}class="active"{/if}>
                        <td>{$autosave->id}</td>
                        <td>{generate::showDatatime($autosave->createTime)}</td>
                        <td class="smallWidthHidden">{$usersDB->get($autosave->createUser,'username')}</td>
                        <td>
                            <div class="buttons">
                                <a href="{$HOME}admin/content/autosave/showAutosave/{$autosave->id}/"><i class="fa fa-search-plus">&nbsp;</i></a>
                            </div>
                        </td>
                    </tr>
                {foreachelse}
                    <div class="pad">{L key = "admin.lang.tpl.nodata"}</div>
                {/foreach}
              </tbody>
            </table>

        </div>
      </div>
      <div class="span8">
         <div class="box">
            <h5><i class="fa fa-plus-circle icon-margin icon-grey">&nbsp;</i> {L key = "admin.content.tpl.autosave"}</h5>
            <table class="table table-striped tablesort">
            {if $showAutosaveId!=null}
                {$autosaveShow = unserialize($pagesbackupsDB->fetchRow("id={$showAutosaveId}")->pageContent)}
                {foreach $autosaveShow as $key => $autosaveRow}
                    {if $autosaveRow!=null and $key!='form_session_key'}
                    <tr><td class="silver">{$key}</td><td>{$autosaveRow|escape:'html'}</td></tr>
                    {/if}
                {/foreach}
            {else}
                <div class="pad">{L key = "admin.content.tpl.chooseelementdisp"}</div>
            {/if}
            </table>
         </div>
      </div>
    </div>
{/if}
   	