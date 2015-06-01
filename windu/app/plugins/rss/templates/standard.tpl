<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
	<channel>
		<title>{$pageInfo->name}</title>
		<description>{$pageInfo->description}</description>
		<link>{$HOME}</link>
		<generator>Windu CMS</generator>

		{foreach $pages as $page}
			<item>
				<title>{$page->name}</title>
				<link>{$HOME}{$page->urlKey}</link>
				<description>{$page->content|strip_tags}</description>
				<author>{$usersDB->get($page->authorId,'username')}</author>
				<pubDate>{$page->createTime|date_format:"%a, %d %b %Y %H:%M:%S %z"}</pubDate>
			</item>
		{/foreach}
	</channel>
</rss>
