<table class="table table-striped tablesort">
    <thead>
    <tr>
        <th>Email</th>
        <th>{L key = "admin.moderator.userlist.tpl.creationdate"}</th>
        <th>IP</th>
    </tr>
    </thead>
    <tbody>
    {foreach $logDB->fetchAll("bucket = 2 or bucket = 3","createTime DESC",'*',100) as $log}
        <tr>
            <td><i class="color-icons {if $log->bucket == 2}icons-user-white{else}icons-user-thief{/if} icon-margin">&nbsp;</i>{$log->data}</td>
            <td>{generate::showDatatime($log->createTime)}</td>
            <td class="smallWidthHidden">{$log->createIp}</td>
        </tr>
    {/foreach}
    </tbody>
</table>
