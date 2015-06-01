<div class="tab-menu-top">
	<a href="{$HOME}admin/content/trash/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i></a>
	<h3 class="pull-left tab-title"> {L key = "admin.content.tpl.trash"}</h3>
	<a href="{$HOME}admin/do/trash/emptyTrash/" class="btn btn-small btn-danger"><i class="fa fa-trash-o icon-margin ">&nbsp;</i> {L key = "admin.content.tpl.emptytrash"}</a>
</div>
{if $pagesDB->fetchCount("status=0")>0}
<div class="row-fluid">
  <div class="span5 box">
  	<h5>
		<i class="fa fa-trash-o icon-margin icon-grey">&nbsp;</i> {L key = "admin.content.common.tpl.trashcontent"}
	  	<div class="buttons">
	  		<a href="{$HOME}admin/do/trash/emptyTrash/" class="btn btn-small btn-danger">{L key = "admin.content.tpl.emptytrash"}</a>
	  	</div>					
  	</h5>
	{include file='common/trash_list.tpl'}
  </div>
  <div class="span7">
 	 <div class="box-floating">
  		<div class="pad box">
	  		<div id="trashPreview">{L key="admin.content.tpl.trash.preview"}</div>
		</div>
	 </div>
  </div>
</div>
{else}
    <div class="center-box align-center">
        <i class="fa fa-trash-o fa-6x icon-red"></i>
        <h4>{L key="admin.content.tpl.trash.bucket"}</h4>
    </div>
{/if}