{$pageCount = 20}
{$page = $pageCount*$REQUEST->getVariable('p')}
{$postsCount = $forumPostsDB->fetchCount()}
<div class="tab-menu-top">
 <a href="{$HOME}admin/forum/posts/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i> </a>
 <h3 class="pull-left tab-title"> {L key = "admin.forum.tpl.posts"}</h3>
 {$formSearch->toHtml()}
</div> 
<div class="row-fluid">
  <div class="span{if is_object($form)}8{else}12{/if}">
  	{if $searchString!=''}
	  	<div class="box">
			<table class="table table-striped tablesort">
				<thead>
					<tr>
						<th>{L key = "admin.forum.tpl.name"}</th>
		                <th></th>
		                <th></th>
		                <th></th>
					</tr>
				</thead>
			    <tbody> 
				  {foreach $searchResult as $post}
					  {$author = $usersDB->fetchRow("id={$post->authorId}")}
					  <tr class="forum-id-{$post->id} {if $post->id == $REQUEST->getVariable('id') and $REQUEST->getVariable('action')=='editPost'}active{/if}" id="post-id-{$post->id}">
						<td><a href="{$HOME}admin/forum/posts/editPost/{$post->id}/?p={$REQUEST->getVariable('p')}"><i class="color-icons icons-balloon-white-left icon-margin">&nbsp;</i>{$post->content|strip_tags|truncate:100}</a></td>
						<td>{generate::showDatatime($post->createTime)}</td>
						<td>{$author->email}</td>
						<td>
							<div class="buttons buttons-two">
								<a href="{$HOME}admin/forum/posts/editPost/{$post->id}/?p={$REQUEST->getVariable('p')}"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
								<span onclick="loadDoActionDelete('{$HOME}admin/do/forum/deletePost/{$post->id}/','#post-id-{$post->id}',{if !usersDB::isDeveloper()}1{else}0{/if})"><i class="fa fa-times-circle icon-red">&nbsp;</i></span>
							</div>
						</td>
					  </tr>					  
				  {/foreach}
				</tbody>
			</table>
		</div>	  	
  	{else}
	  	{include file='common/paginator.tpl' elementsCount=$postsCount count=$pageCount}
	  	<div class="box">
			<table class="table table-striped tablesort">
				<thead>
					<tr>
						<th>{L key = "admin.forum.tpl.name"}</th>
		                <th></th>
		                <th></th>
		                <th></th>
					</tr>
				</thead>
			    <tbody> 
				  {foreach $forumPostsDB->fetchAll(null,'createTime DESC','*',"{$page},{$pageCount}") as $post}
					  {$author = $usersDB->fetchRow("id={$post->authorId}")}
					  <tr class="forum-id-{$post->id} {if $post->id == $REQUEST->getVariable('id') and $REQUEST->getVariable('action')=='editPost'}active{/if}" id="post-id-{$post->id}">
						<td><a href="{$HOME}admin/forum/posts/editPost/{$post->id}/?p={$REQUEST->getVariable('p')}"><i class="color-icons icons-balloon-white-left icon-margin">&nbsp;</i>{$post->content|strip_tags|truncate:100}</a></td>
						<td>{generate::showDatatime($post->createTime)}</td>
						<td>{$author->email}</td>
						<td>
							<div class="buttons buttons-two">
                                <a href="{$HOME}admin/forum/posts/editPost/{$post->id}/?p={$REQUEST->getVariable('p')}"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
								<span onclick="loadDoActionDelete('{$HOME}admin/do/forum/deletePost/{$post->id}/','#post-id-{$post->id}',{if !usersDB::isDeveloper()}1{else}0{/if})"><i class="fa fa-times-circle icon-red">&nbsp;</i></span>
							</div>
						</td>
					  </tr>					  
				  {/foreach}
				</tbody>
			</table>	
		</div>	
		{include file='common/paginator.tpl' elementsCount=$postsCount count=$pageCount}
	{/if}	
  </div>
  {if is_object($form)}
      <div class="span4">
          <div class="box">
            <h5>Edytuj post</h5>
            {$form->toHtml()}
          </div>
      </div>
  {/if}
</div>
