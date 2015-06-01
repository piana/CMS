{include file='common/goProBanner.tpl'}

<div class="row-fluid menu">
	<a href="{$HOME}admin/tools/monitoring/" class="span2 box box-hover-animate">
        <i class="fa fa-bar-chart-o fa-3x icon-dark"> </i> <h4>{L key = "admin.tools.tpl.monitoring"}</h4>
    </a>
	<a href="{$HOME}admin/tools/seo/" class="span2 box box-hover-animate">
        <i class="fa fa-globe fa-3x icon-green"> </i> <h4>{L key = "admin.tools.tpl.seo"}</h4>
    </a>
	<a href="{$HOME}admin/tools/mailing/" class="span2 box box-hover-animate">
        <i class="fa fa-inbox fa-3x icon-red"> </i> <h4>{L key = "admin.tools.tpl.mailing"}</h4>
	</a>
	<a href="{$HOME}admin/tools/rss/" class="span2 box box-hover-animate">
        <i class="fa fa-rss fa-3x icon-orange"> </i> <h4>RSS</h4>
    </a>
	{if !usersDB::isNoob()}
	<a href="{$HOME}admin/tools/contacts/" class="span2 box box-hover-animate">
        <i class="fa fa-envelope fa-3x icon-yellow"> </i> <h4>{L key = "admin.tools.tpl.contact"}</h4>
	</a>
	<a href="{$HOME}admin/tools/database/" class="span2 box box-hover-animate">
        <i class="fa fa-upload fa-3x icon-purple"> </i> <h4>{L key = "admin.tools.tpl.database"}</h4>
	</a>
	{/if}
</div>

<div class="row-fluid menu">
    <a href="{$HOME}admin/system/stats/" class="span2 box box-hover-animate">
        <i class="fa fa-signal fa-3x icon-blue"> </i> <h4>{L key = "admin.tools.tpl.stats"}</h4>
    </a>
    <a href="{$HOME}admin/system/backup/" class="span2 box box-hover-animate">
        <i class="fa fa-archive fa-3x icon-orange"> </i> <h4>{L key = "admin.tools.tpl.backup"}</h4>
    </a>
    {if !usersDB::isNoob()}
        <a href="{$HOME}admin/system/log/" class="span2 box box-hover-animate">
            <i class="fa fa-bell fa-3x icon-yellow"> </i> <h4>{L key = "admin.system.tpl.log"}</h4>
        </a>
        <a href="{$HOME}admin/system/cron/" class="span2 box box-hover-animate">
            <i class="fa fa-cogs fa-3x icon-green"> </i> <h4>Cron</h4>
        </a>
        <a href="{$HOME}admin/system/firewall/" class="span2 box box-hover-animate">
            <i class="fa fa-shield fa-3x icon-red"> </i> <h4>{L key = "admin.tools.tpl.firewall"}</h4>
        </a>
        <a href="{$HOME}admin/requestlog/showLogs/" class="span2 box box-hover-animate">
            <i class="fa fa-download fa-3x icon-dark"> </i> <h4>{L key = "admin.tools.tpl.requestlog"}</h4>
        </a>
    {/if}
</div>