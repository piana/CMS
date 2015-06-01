<div class="tab-menu-top">
	<a href="{$HOME}admin/forum/forums/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i> </a>
	<h3 class="pull-left tab-title"> {L key = "admin.forum.tpl.forums"}</h3>
</div>
<div class="row-fluid">
	<div class="span{if is_object($form)}6{else}12{/if}">	
		{if count($forums)==0 and !is_object($form)}
			<div class="center-box">
				<a href="{$HOME}admin/forum/forums/addForum/" class="btn btn-large">
					<i class="fa fa-plus-circle fa-2x"></i>
					{L key = "admin.forum.tpl.addforum"}
				</a>
			</div>	
		{else}
			<div class="box">
				<h5>
                    <i class="fa fa-list-alt icon-margin icon-grey">&nbsp;</i>{L key = "admin.forum.tpl.forumlist"}
                    <div class="buttons">
                        <a href="{$HOME}admin/forum/forums/addForum/" class="btn btn-small btn-primary">{L key = "admin.forum.tpl.addforum"}</a>
                    </div>
                </h5>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>{L key = "admin.forum.tpl.name"}</th>
							{if !is_object($form)}
                                <th>Widget</th>
                                <th>{L key = "admin.forum.tpl.desc"}</th>
                                <th>{L key = "admin.forum.tpl.groups"}</th>
                                <th>{L key = "admin.forum.tpl.topics"}</th>
                                <th>{L key = "admin.forum.tpl.posts"}</th>
							{/if}
							<th></th>
						</tr>
					</thead>
					<tbody>
						{foreach $forums as $forum}
						<tr class="forum-id-{$forum->id} {if $forum->id == $REQUEST->getVariable('id') and $REQUEST->getVariable('action')!='editGroup'}active{/if}">
							<td><i class="color-icons icons-application-list icon-margin">&nbsp;</i>{$forum->name}</td>
							<td>{literal}{{W name=forum id={/literal}{$forum->id}{literal}}}{/literal}</td>
							{if !is_object($form)}
                                <td>{$forum->description|truncate:100}</td>
                                <td>{$forum->groupsCount}</td>
                                <td>{$forum->topicsCount}</td>
                                <td>{$forum->postsCount}</td>
							{/if}
							<td>
							<div class="buttons buttons-five">
								<a href="{$HOME}admin/forum/forums/addGroup/{$forum->id}/"><i class="fa fa-plus-circle icon-green">&nbsp;</i></a>
								<a href="{$HOME}admin/forum/forums/editForum/{$forum->id}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
								<a href="{$HOME}admin/do/forum/forumUp/{$forum->id}/"><i class="fa fa-arrow-up icon-blue">&nbsp;</i></a>
								<a href="{$HOME}admin/do/forum/forumDown/{$forum->id}/"><i class="fa fa-arrow-down icon-blue">&nbsp;</i></a>
								<span onclick="loadDoActionDelete('{$HOME}admin/do/forum/deleteForum/{$forum->id}/','.forum-id-{$forum->id}',{if !usersDB::isDeveloper()}1{else}0{/if})"><i class="fa fa-times-circle icon-red">&nbsp;</i></span>
							</div></td>
						</tr>
                            {foreach $forumGroupsDB->fetchAll("forumId={$forum->id}",'position ASC') as $group}
                            <tr class="forum-id-{$forum->id} {if $group->id == $REQUEST->getVariable('id') and $REQUEST->getVariable('action')=='editGroup'}active{/if}" id="group-id-{$group->id}">
                                <td><i class="color-icons icons-balloon-white-left icon-margin margin-left">&nbsp;</i>{$group->name}</td>
                                <td></td>
                                {if !is_object($form)}
                                    <td>{$group->description|truncate:100}</td>
                                    <td></td>
                                    <td>{$group->topicsCount}</td>
                                    <td>{$group->postsCount}</td>
                                {/if}
                                <td>
                                <div class="buttons buttons-four">
                                    <a href="{$HOME}admin/forum/forums/editGroup/{$group->id}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
                                    <a href="{$HOME}admin/do/forum/groupUp/{$group->id}/"><i class="fa fa-arrow-up icon-blue">&nbsp;</i></a>
                                    <a href="{$HOME}admin/do/forum/groupDown/{$group->id}/"><i class="fa fa-arrow-down icon-blue">&nbsp;</i></a>
                                    <span onclick="loadDoActionDelete('{$HOME}admin/do/forum/deleteGroup/{$group->id}/','#group-id-{$group->id}',{if !usersDB::isDeveloper()}1{else}0{/if})"><i class="fa fa-times-circle icon-red">&nbsp;</i></span>
                                </div></td>
                            </tr>
                            {/foreach}
						{/foreach}
					</tbody>
				</table>
			</div>
		</div>	
	{/if}	
	
	{if is_object($form)}
        <div class="span6">
            <div class="box box-floating">
                <h5>{L key = "admin.forum.tpl.addedit"}</h5>
                {$form->toHtml()}
            </div>
        </div>
	{/if}
</div>
