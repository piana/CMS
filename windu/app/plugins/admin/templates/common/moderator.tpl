<div class="tab-menu-top">
	<a href="{$HOME}admin/users/moderator/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i> </a>
	<h3 class="pull-left tab-title"> {L key = "admin.tools.tpl.moderator"}</h3>
</div>
<ul class="nav nav-tabs nav-tabs-top" id="tabModerator">

    <li>
        <a href="#tabModerator7"><i class="color-icons icons-clipboard-task icon-margin">&nbsp;</i>Ostatnie logowania</a>
    </li>
    {$unactiveUsersCount = $usersDB->fetchCount('active=0')}
	{if $unactiveUsersCount>0}
        <li><a href="#tabModerator1"><span class="badge badge-important" style="margin-bottom:2px;">{$unactiveUsersCount}</span> Oczekują na aktywacje </a></li>
    {/if}
	<li>
		<a href="#tabModerator3"><i class="color-icons icons-user-business-gray icon-margin">&nbsp;</i>{L key = "admin.users.ctpl.review"}</a>
	</li>
    {$commentsUnactiveCount = $commentsDB->fetchCount('status=0')}
    {if $commentsUnactiveCount>0}
	    <li><a href="#tabModerator2"><span class="badge badge-important" style="margin-bottom:2px;">{$commentsUnactiveCount}</span> Komentarze oczekujące na akceptację</a></li>
    {/if}
	<li>
		<a href="#tabModerator4"><i class="color-icons icons-balloons icon-margin">&nbsp;</i>Komentarze</a>
	</li>

	<li>
		<a href="#tabModerator5"><i class="color-icons icons-clipboard-text icon-margin">&nbsp;</i>{L key = "admin.menu.content"}</a>
	</li>
	<li>
		<a href="#tabModerator6"><i class="color-icons icons-clipboard-task icon-margin">&nbsp;</i>{L key = "admin.users.ctpl.review"}</a>
	</li>
</ul>
<div class="tab-content tab-moderator box">
    <div class="tab-pane" id="tabModerator7">
        <div class="row-fluid">
            <div class="span12">
                {include file='common/moderator_users_login_list.tpl'}
            </div>
        </div>
    </div>
	<div class="tab-pane" id="tabModerator1">
		<div class="row-fluid">
			<div class="span12">
				{include file='common/moderator_users_unactive_list.tpl'}
			</div>
		</div>
	</div>
	<div class="tab-pane" id="tabModerator2">
		<div class="row-fluid">
			<div class="span12">
				{include file='common/moderator_comments_unactive_list.tpl'}
			</div>
		</div>
	</div>
	<div class="tab-pane" id="tabModerator3">
		<div class="row-fluid">
			<div class="span12">
				{include file='common/moderator_users_list.tpl'}
			</div>
		</div>
	</div>
	<div class="tab-pane" id="tabModerator4">
		<div class="row-fluid">
			<div class="span12">
				{include file='common/moderator_comments_list.tpl'}
			</div>
		</div>
	</div>
	<div class="tab-pane" id="tabModerator5">
		<div class="row-fluid">
			<div class="span6">
				{include file='common/moderator_content_active_list.tpl' type=0}
			</div>
			<div class="span6">
				{include file='common/moderator_content_active_list.tpl' type=1}
			</div>
		</div>
	</div>
	<div class="tab-pane" id="tabModerator6">
		<div class="row-fluid">
			<div class="span12">
				{include file='common/moderator_content_list.tpl'}
			</div>
		</div>
	</div>
</div>