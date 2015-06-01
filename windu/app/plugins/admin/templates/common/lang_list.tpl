<table class="table table-striped">
  <tbody>
  {foreach $langs as $lang}
	<tr>
		<td>
			{include file='common/content_list_icon.tpl' type=$lang->type name=$lang->name}
			{$lang->name}
		</td>
		<td>
			<div class="buttons">
				<a href="{$HOME}admin/do/content/deleteLang/{$lang->id}/"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>
			</div>
		</td>
	</tr>
	{foreach baseFile::getFilesList("{$smarty.const.LANGUAGES_PATH}/{$lang->name|lower}/") as $file}
	<tr>
		<td style="padding-left:25px;">
			<i class="color-icons icons-document-list icon-margin"> </i>
			{$file->name}
		</td>
		<td>
			<div class="buttons">
				<a href="{$HOME}admin/content/lang/editLang/{$lang->name}/{$file->name}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
			</div>
		</td>
	</tr>	
	{/foreach}
  {/foreach}   
  </tbody>
</table>




