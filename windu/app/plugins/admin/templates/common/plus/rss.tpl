{$action = $REQUEST->getVariable('action')}
{$id = $REQUEST->getVariable('id')}
<div class="tab-menu-top">
	<a href="{$HOME}admin/tools/rss/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i> </a>
	<h3 class="pull-left tab-title"> {L key = "admin.tools.tpl.rss"}</h3>
</div>

<div class="row-fluid">
	<div class="span7">
  		{$rssUrls = unserialize(config::get('rssUrls'))}
  		<div class="box">
			<h5>{L key="admin.rss.tpl.rsslist"}</h5>
			<table class="table table-striped">
			  <tbody>
			  	{foreach $rssUrls as $key => $rssUrl}
			  		{$rssRow = explode('|',$rssUrl)}
					<tr>
				      <td>
				      	<i class="color-icons icons-mail-open-document-text icon-margin"> </i>{$rssRow.0}
				      </td>
				      <td>
				      	{pagesDB::getPageById($rssRow.1)->name}
				      </td>	
				      <td>
				      	<span class="badge badge-inverse">{$rssRow.1}</span>
				      </td>						      			      
				      <td>
			  			<div class="buttons">
							<a href="{$HOME}admin/do/tools/deleteRssUrl/{$key}/"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>
						</div>
				      </td>
				    </tr>
				{foreachelse}
					<div class="pad">
						{L key="admin.rss.tpl.noata"}
					</div>
  				{/foreach}
			  </tbody>
			</table>
  		</div>
	</div> 
	<div class="span5">	
	  	<div class="box">
	  		<h5>{L key="admin.rss.tpl.newrss"}</h5>
	  		{$formRSS->toHtml()}
	  	</div>	
	</div>	
</div>  	