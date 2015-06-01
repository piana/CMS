			<div class="row-fluid">
			  <div class="span5 box">
			  	<h5><i class="fa fa-clipboard icon-margin icon-grey">&nbsp;</i> {L key = "admin.content.common.tpl.pageslist"}
				  	<div class="buttons buttons-three">
				  		<a href="{$HOME}admin/mainDo/toogleCookie/sortableOn/tab1/" class="btn btn-small {if cookie::readCookie(sortableOn)}btn-success{/if}">{L key = "admin.content.tpl.sort"}</a>
				  		<a href="{$HOME}admin/mainDo/toogleCookie/showAllOn/tab1/" class="btn btn-small {if cookie::readCookie(showAllOn)}btn-success{/if}">{L key = "admin.content.tpl.showall"}</a>
				  		<a href="{$HOME}admin/do/content/hideTreelistAll/" class="btn btn-small">-</a>
				  	</div>
			  	</h5>
				{include file='common/content_list.tpl'}
			  </div>
			  	{if $contentType == 'form'}
				  	<div class="span7">
				  		<div class="box box-floating">
				  			<h5><i class="fa fa-plus-circle icon-margin icon-grey">&nbsp;</i>{L key = "admin.content.common.tpl.addelement"}</h5>
					  		{$form->toHtml()}
				  		</div>
				  	</div>
				{elseif $contentType == 'edit'}
					{include file='common/images_modal.tpl'}
					{include file='common/widgets_modal.tpl'}
					{include file='common/files_modal.tpl'}
					{include file='common/customfields_modal.tpl'}
				  	<div class="span7">
					  	<div class="box box-silver">
							{$form->toHtml()}
					  	</div>
					  	{if $images!=null}
					  	<div class="box margin-top mobileHidden">
					  		<h5><i class="fa fa-picture-o icon-margin icon-grey">&nbsp;</i> {L key = "admin.content.common.tpl.imagelistingalery"}
							  	<div class="buttons">
							  		<a href="{$HOME}admin/mainDo/toogleCookie/sortableOn/tab1/" class="btn btn-small {if cookie::readCookie(sortableOn)}btn-success{/if}">{L key = "admin.content.tpl.sort"}</a>
							  	</div>				  			
					  		</h5>
					  		{include file='common/images_list.tpl'}
					  	</div>
					  	{/if}
				  	</div>				  	
			  	{elseif $contentType == 'gallery'}
				  	<div class="span7">
					  		<div class="box">
						  		<h5><i class="fa fa-plus-circle icon-margin icon-grey">&nbsp;</i> {L key = "admin.content.common.tpl.addimages"}</h5>
						  		{include file='common/images_multiuploader.tpl'}
						  	</div>	
						  	<div class="box margin-top">
					  			<h5><i class="fa fa-picture-o icon-margin icon-grey">&nbsp;</i> {L key = "admin.content.common.tpl.imagelistingalery"}
								  	<div class="buttons">
								  		<a href="{$HOME}admin/mainDo/toogleCookie/sortableOn/tab1/" class="btn btn-small {if cookie::readCookie(sortableOn)}btn-success{/if}">{L key = "admin.content.tpl.sort"}</a>
								  	</div>				  			
					  			</h5>
					  			{include file='common/images_list.tpl'}	
					  		</div>
				  	</div>
				{elseif $contentType == 'image'}
				  	<div class="span2">
					  	<div class="box">
						  	<h5><i class="fa fa-pencil icon-margin icon-grey">&nbsp;</i> {L key = "admin.content.tpl.editimages"}</h5>
							{include file='common/images_editor.tpl'}	
						</div>				  	
				  		<div class="box margin-top">
					  		<h5><i class="fa fa-picture-o icon-margin icon-grey">&nbsp;</i> {L key = "admin.content.common.tpl.imagelistingalery"}</h5>
					  		{include file='common/images_list.tpl' parentId=$image->bucket small=1}	
					  	</div>	
				  	</div>					
				  	<div class="span5">
				  		<div class="box">
					  		<h5><i class="fa fa-clipboard icon-margin icon-grey">&nbsp;</i> {L key = "admin.content.tpl.description"}</h5>
					  		{$form->toHtml()}
					  	</div>
				  	</div>	
				{elseif $contentType == 'news'}
				  	<div class="span7">
				  		<div class="box">
					  		<h5><i class="fa fa-calendar icon-margin icon-grey">&nbsp;</i> {L key = "admin.content.tpl.addnews"}</h5>
					  		{$form->toHtml()}
					  	</div>	
					  	{if is_object($formRestore)}
				  		<div class="box margin-top">
					  		<h5><i class="fa fa-picture-o icon-margin icon-grey">&nbsp;</i> {L key = "admin.content.tpl.restore"}</h5>
					  		{$formRestore->toHtml()}
				  		</div>
				  		{/if}	
				  	</div>	
			  	{else}
			  		<div class="span7">
			  			{include file='common/content_info.tpl'}
			  		</div>
			  	{/if}
			</div>