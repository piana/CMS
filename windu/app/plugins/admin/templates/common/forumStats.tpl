<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<div class="tab-menu-top">
 <a href="{$HOME}admin/forum/stats/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i> </a>
 <h3 class="pull-left tab-title"> {L key = "admin.forum.tpl.stats"}</h3>
</div>
<div class="row-fluid">
    <div class="span12">
        <div class="box margin-bottom">
            <h5>
                <i class="fa fa-list-alt icon-margin icon-grey"></i> {L key = "admin.forum.tpl.posts.last90days"}
            </h5>

            {literal}
            <script type="text/javascript">

                google.load("visualization", "1", {packages:["corechart"]});
                $(document).ready(function() {
                    window.dataConservationLast = google.visualization.arrayToDataTable([
                        {/literal}
                        ['Date', 'Posts'],
                        {foreach $forumPostsDB->fetchCountGroup("strftime('%Y%m%d', createTime)","createTime>={strtotime("-90 days")}",'createTime') as $stat}
                        ['{$stat->createTime}', {$stat->{"COUNT(strftime('%Y%m%d', createTime))"}}],
                        {/foreach}
                        {literal}
                    ]);
                    drawLineChartMedium('chartLineStatLastConservation',window.dataConservationLast);
                });
            </script>
            {/literal}
            <div id="chartLineStatLastConservation" style="width: 99.9%; height:200px;"></div>

        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span2 mobileHidden">
        <div class="box pad margin-bottom align-center">
            {L key ="admin.forum.tpl.threads.last3days"}
            <h2>{$forumTopicsDB->fetchCount("createTime>={strtotime("-3 days")}")}</h2>
        </div>
        <div class="box pad margin-bottom align-center">
            {L key = "admin.forum.tpl.posts.last3days "}
            <h2>{$forumPostsDB->fetchCount("createTime>={strtotime("-3 days")}")}</h2>
        </div>
        <div class="box pad margin-bottom align-center">
            {L key = "admin.forum.tpl.threads.last30days"}
            <h2>{$forumTopicsDB->fetchCount("createTime>={strtotime("-30 days")}")}</h2>
        </div>
        <div class="box pad margin-bottom align-center">
            {L key = "admin.forum.tpl.posts.last30days"}
            <h2>{$forumPostsDB->fetchCount("createTime>={strtotime("-30 days")}")}</h2>
        </div>
    </div>
    <div class="span4">
        <div class="box">
            <h5>{L key = "admin.forum.tpl.posts.popular30days"}</h5>
            <table class="table table-striped">
                <tbody>
                {$valKey = 'COUNT(topicId)'}
                {foreach $forumPostsDB->fetchCountGroup("topicId","createTime>={strtotime("-30 days")}","{$valKey} DESC",'*',20) as $popularTopic}
                    <tr>
                        <td><i class="color-icons icons-balloon-white-left icon-margin"></i> {$forumTopicsDB->get($popularTopic->topicId,'name')}</td>
                        <td class="align-right">{$popularTopic->$valKey}</td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
        </div>
    </div>
    <div class="span2 mobileHidden">
        <div class="box pad margin-bottom align-center">
            {L key = "admin.forum.tpl.newusers.3days"}
            <h2>{$usersDB->fetchCount("createTime>={strtotime("-3 days")}")}</h2>
        </div>
        <div class="box pad margin-bottom align-center">
            {L key = "admin.forum.tpl.activeusers.3days"}
            <h2>{count($forumPostsDB->fetchCountGroup("authorId","createTime>={strtotime("-3 days")}"))}</h2>
        </div>
        <div class="box pad margin-bottom align-center">
            {L key = "admin.forum.tpl.newusers.30days"}
            <h2>{$usersDB->fetchCount("createTime>={strtotime("-30 days")}")}</h2>
        </div>
        <div class="box pad margin-bottom align-center">
            {L key = "admin.forum.tpl.activeusers.30days"}
            <h2>{count($forumPostsDB->fetchCountGroup("authorId","createTime>={strtotime("-30 days")}"))}</h2>
        </div>
    </div>
    <div class="span4">
        <div class="box">
            <h5>{L key = "admin.forum.tpl.activeusers.most30days"}</h5>
            <table class="table table-striped">
                <tbody>
                {$valKey = 'COUNT(authorId)'}
                {foreach $forumPostsDB->fetchCountGroup("authorId","createTime>={strtotime("-30 days")}","{$valKey} DESC",'*',20) as $activeUser}
                    <tr>
                        <td><i class="color-icons icons-user-black icon-margin"></i> {$usersDB->get($activeUser->authorId,'email')}</td>
                        <td class="align-right">{$activeUser->$valKey}</td>
                    </tr>
                {/foreach}
                </tbody>
            </table>
        </div>
    </div>
</div>