{if is_object($data.file)}
	<a href="{$HOME}do/bannerClick/{$data.banner->id}/" target="_blank">
		{if $data.file->type=='swf'}
			<object width="{$data.width}" height="{$data.height}">
			    <param name="movie" value="{$HOME}data/files/{$data.file->path}/{$data.file->fileName}">
			    <embed src="{$HOME}data/files/{$data.file->path}/{$data.file->fileName}" width="{$data.width}" height="{$data.height}">
			    </embed>
			</object>
		{else}
			<img src="{$HOME}data/files/{$data.file->path}/{$data.file->fileName}">
		{/if}
	</a>
{/if}