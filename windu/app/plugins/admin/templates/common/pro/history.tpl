{if license::hasPro()}
    <div class="tab-menu-top">
        <a href="{$HOME}admin/users/history/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i> </a>
        <h3 class="pull-left tab-title">{L key = "admin.users.hist.action"}</h3>
    </div>
    {include file='common/paginator.tpl' elementsCount=$historyCount count=$historyPageCount}
    <div class="box">
        <table class="table table-striped sortable">
            <thead>
                <tr>
                    <th style="width:80px;">{L key = "admin.users.hist.type"}</th>
                    <th style="width:130px;">{L key = "admin.users.hist.user"}</th>
                    <th style="width:80px;">{L key = "admin.users.hist.tabel"}</th>
                    <th>{L key = "admin.users.hist.data"}</th>
                    <th class="align-right">{L key = "admin.users.hist.time"}</th>
                </tr>
            </thead>
            <tbody>
            {foreach $logDB->getHistoryLogs($historyPage,$historyPageCount) as $historyLog}
                <tr>
                    <td>
                        {if $historyLog->bucket==logDB::BUCKET_USER_ACTIONS_ADD}
                            <span class="badge badge-info">{L key = "admin.users.hist.add"}</span>
                        {elseif $historyLog->bucket==logDB::BUCKET_USER_ACTIONS_EDIT}
                            <span class="badge badge-success">{L key = "admin.users.hist.edit"}</span>
                        {elseif $historyLog->bucket==logDB::BUCKET_USER_ACTIONS_DELETE}
                            <span class="badge badge-important">{L key = "admin.users.hist.del"}</span>
                        {elseif $historyLog->bucket==logDB::BUCKET_USER_ACTIONS_OTHER}
                            <span class="badge badge-inverse">{L key = "admin.users.hist.other"}</span>
                        {else}
                            <span class="badge">{L key = "admin.users.hist.other"}</span>
                        {/if}
                    </td>
                    <td>{$usersDB->get($historyLog->userId,'email')}</td>
                    <td>{$historyLog->table}</td>
                    <td>
                        <div style="display: none;" id="history{$historyLog->id}">
                            <span class="badge badge-inverse" style="cursor:pointer" onclick="$('#history{$historyLog->id}').hide(); $('#historyBtn{$historyLog->id}').show()">{L key = "admin.users.hist.hide"}</span><br><br>
                            {debugger::dprint($historyLog->data)}
                        </div>
                        <span class="badge" style="cursor:pointer" id="historyBtn{$historyLog->id}" onclick="$('#history{$historyLog->id}').show(); $('#historyBtn{$historyLog->id}').hide()">{L key = "admin.users.hist.show"}</span>
                    </td>
                    <td class="align-right">{generate::showDatatime($historyLog->createTime)}</td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>
    {include file='common/paginator.tpl' elementsCount=$historyCount count=$historyPageCount}
{else}
    {include file='common/goPro.tpl'}
{/if}