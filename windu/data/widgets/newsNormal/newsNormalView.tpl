{if !isset($params.count)}{$params.count = config::get(newsCount)}{/if}
{if !isset($params.length)}{$params.length = config::get(newsLength)}{/if}
{if !isset($params.lengthTitle)}{$params.lengthTitle = config::get(newsLengthTitle)}{/if}
{if !isset($params.width)}{$params.width = config::get(imgSmallWidth)}{/if}
{if !isset($params.height)}{$params.height = config::get(imgSmallHeight)}{/if}
{if !isset($params.span)}{$params.span = config::get(newsSpan)}{/if}
{if !isset($params.btncss)}{$params.btncss = config::get(newsBtnCssClass)}{/if}
{if !isset($params.cssUl)}{$params.cssUl = 'newsNormal'}{/if}
{if !isset($params.cssLi)}{$params.cssLi = ""}{/if}

{if !isset($params.showDate)}{$params.showDate = true}{/if}
{if !isset($params.showAuthor)}{$params.showAuthor = true}{/if}

{if !isset($params.showTitle)}{$params.showTitle = true}{/if}
{if !isset($params.showContent)}{$params.showContent = true}{/if}
{if !isset($params.showImg)}{$params.showImg = true}{/if}
{if !isset($params.showMore)}{$params.showMore = false}{/if}
{if !isset($params.startNews)}{$params.startNews = 0}{/if}
{if !isset($params.fit)}{$params.fit = 'smart'}{/if}
{if !isset($params.where)}{$params.where = null}{/if}

{if $params.range != ''}
    {$first = generate::sqlDate(strtotime("first day of {$params.range}"))}
    {$last = generate::sqlDate(strtotime("last day of {$params.range}"))}
    {$where=" and type=2 and status=1 and createTime >= '{$first}' and createTime <= '{$last}'"}
    {$getNews = $data.pagesDB->getNews($params.newsGroup,$params.count,$params.startNews,$where)}
    {else}
    {$getNews = $data.pagesDB->getNews($params.newsGroup,$params.count,$params.startNews)}
{/if}

{if !isset($params.news)}{assign newsList $newsGroup}
{else}{assign newsList $params.news}{/if}


<ul class="{$params.cssUl}">
    {foreach $getNews as $news}
        <li class="{$params.cssLi}">
            {if $params.showMore == false}<a href="{$HOME}{$news->urlKey}">{/if}
                {if pagesDB::getMainImageEkey($news->id)!=null and $params.showImg}
                    <a href="{$HOME}{$news->urlKey}"><img src="{$HOME}image/{pagesDB::getMainImageEkey($news->id)}/{$params.width}/{$params.height}/{$params.fit}/" class="pull-left img-margin"></a>
                {/if}

                {if $params.showTitle}<h4><a href="{$HOME}{$news->urlKey}">{$news->name|truncate:$params.lengthTitle}</a></h4>{/if}
                {if $params.showAuthor or $params.showDate}
                    <p class="newsNormal-meta">
                        {if $params.showAuthor}<span class="label margin-right">{$data.usersDB->get($news->authorId,'username')}</span>{/if}
                        {if $params.showDate}{$news->date}{/if}
                    </p>
                {/if}
                {if $params.showContent}<p>{$news->content|strip_tags|truncate:$params.length}</p>{/if}
                {if $params.showMore}<a href="{$HOME}{$news->urlKey}" class="{$params.btncss}">{L key="news.normal.more"}</a>{/if}
                {if $params.showMore == false}</a>{/if}
        </li>
    {/foreach}
</ul>