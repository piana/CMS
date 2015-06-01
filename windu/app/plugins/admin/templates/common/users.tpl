<div class="tab-menu-top">
 <a href="{$HOME}admin/users/users/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i> </a>
 <h3 class="pull-left tab-title"> {L key = "admin.users.ctpl.users"}</h3>
 {$formSearch->toHtml()}
 <a href="{$HOME}admin/users/users/" class="btn btn-small btn-primary pull-right">{L key = "admin.users.tpl.adduser"}</a>
</div> 
<div class="row-fluid">
	{if count($usersPage)==0 and $REQUEST->getVariable('action')!='add'}
		<div class="center-box">
			<a href="{$HOME}admin/users/users/add/" class="btn btn-large">
				<i class="fa fa-plus-circle fa-2x"></i>
				{L key = "admin.users.tpl.adduser"}
			</a>
		</div>	
	{else}	
	  <div class="span6">	
	  	<div class="box">  
			{include file='common/users_page_list.tpl'}
		</div>
	  </div>
	  <div class="span6">
	  	<div class="box-floating box">
	  		<h5><i class="fa fa-user icon-margin icon-grey"></i> {L key = "admin.users.tpl.adduser"}</h5>
	  		{$userPage->toHtml()}
	  	</div>
	  </div>
	{/if}
</div>	 	      		