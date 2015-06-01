<div class="tabbable">
	  <div class="tab-content">
		    <div class="row-fluid menu mobileHidden margin-bottom">
		    {if usersDB::permissionCheck(adminContentController)}
		      <a href="{$HOME}admin/content/pages/" class="span2 box box-hover-animate" data-toggle="tooltip" data-original-title="{L key = "admin.index.tpl.deleteedit"}" data-placement="bottom">
				<i class="fa fa-file-text fa-3x icon-orange"></i>
				<h4>{L key = "admin.menu.content"}</h4>
		      </a>
		      {/if}
              {if usersDB::permissionCheck(adminConfigController)}
              <a href="{$HOME}admin/forum/forums/" class="span2 box box-hover-animate" data-toggle="tooltip" data-original-title="{L key = "admin.index.tpl.forum"}" data-placement="bottom">
                <i class="fa fa-comments  fa-3x icon-yellow"></i>
                <h4>{L key = "admin.menu.forum"}</h4>
              </a>
              {/if} 		      
		      {if usersDB::permissionCheck(adminUsersController)}
		      <a href="{$HOME}admin/users/moderator/" class="span2 box box-hover-animate" data-toggle="tooltip" data-original-title="{L key = "admin.index.tpl.addusers"}" data-placement="bottom">
                <i class="fa fa-users fa-3x icon-green"></i>
                <h4>{L key = "admin.menu.users"}</h4>
			  </a>	
			  {/if}
		      {if usersDB::permissionCheck(adminThemesController)}
			  <a href="{$HOME}admin/themes/themes/" class="span2 box box-hover-animate" data-toggle="tooltip" data-original-title="{L key = "admin.index.tpl.themes"}" data-placement="bottom">
                <i class="fa fa-desktop fa-3x icon-blue"></i>
                <h4>{L key = "admin.menu.themes"}</h4>
			  </a>
			  {/if}
			  {if usersDB::permissionCheck(adminBackupController)}
			  <a href="{$HOME}admin/tools/tools/" class="span2 box box-hover-animate" data-toggle="tooltip" data-original-title="{L key = "admin.index.tpl.tools"}" data-placement="bottom">
                <i class="fa fa-wrench fa-3x icon-dark"></i>
                <h4>{L key = "admin.menu.tools"}</h4>
			  </a>
			  {/if}

			  {if usersDB::permissionCheck(adminSystemController)}
			  <a href="{$HOME}admin/system/system/"  class="span2 box box-hover-animate" data-toggle="tooltip" data-original-title="{L key = "admin.index.tpl.system"}" data-placement="bottom">
                <i class="fa fa-tachometer fa-3x icon-purple"></i>
                <h4>{L key = "admin.menu.system"}</h4>
			  </a>
			  {/if}	      
		    </div>
	    	<div class="row-fluid">
			  	<div class="span4">
				  	{if usersDB::permissionCheck(adminSystemController) and notifyDB::count()>0}
				  		<div class="box margin-bottom">
				  			{include file='common/notify_list.tpl' simple=true}
				  		</div>
				  	{/if}	
				  	<div class="box">
				  		<h5>{L key = "admin.system.tpl.lastlogs"}
					  		<div class="buttons">
					  			<a href="{$HOME}admin/system/log/" class="btn btn-small">{L key="admin.system.tpl.log"}</a>
					  		</div>
				  		</h5>
						<table class="table table-striped">
						  <tbody>
						  {foreach $logDB->fetchCountGroup('data',"bucket!=30 and bucket!=31 and bucket!=32 and bucket!=33","createTime DESC",'*',7) as $log}
							<tr>
								<td class="align-right">
									<a href="{$HOME}admin/system/log/showLogs/{$log->bucket}/">
										{if $log->bucket == logDB::BUCKET_UPDATE}
											<span class="badge badge-info">update</span>
										{elseif $log->bucket == logDB::BUCKET_404}
											<span class="badge badge-warning">warning</span>
										{elseif $log->bucket == logDB::BUCKET_ERROR}
											<span class="badge badge-important">error</span>
										{elseif $log->bucket == logDB::BUCKET_LOGIN_ERROR}
											<span class="badge badge-inverse">login error</span>
										{else}
											<span class="badge">info</span>
										{/if}
									</a>									
								</td>
								<td>{$log->data|truncate:30}</td>
								<td style="width:40px;">{generate::showDatatime($log->createTime,true,true)}</td>
							</tr>
						  {/foreach}   
						  </tbody>
						</table>				  	
				 	</div>
			 	</div>
				<div class="span4">
					{include file='common/goProBanner.tpl'}
					<div class="box">
						<h5>
                            <i class="fa fa-signal icon-margin icon-grey"></i> {L key = "admin.common.statistics.tpl.visits"}
					  		<div class="buttons">
					  			<a href="{$HOME}admin/system/stats/" class="btn btn-small">{L key="admin.system.tpl.stats"}</a>
					  		</div>						
						</h5>
						{if $systemStatusDB->fetchCount()!=0}
						  	{literal}
							    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
							    <script type="text/javascript">
							      google.load("visualization", "1", {packages:["corechart"]});
							      $(document).ready(function() {
								      window.dataStatIndex = google.visualization.arrayToDataTable([
											{/literal}
											['Date', 'Views'],
											{$stats = $systemStatusDB->fetchAll(null, 'id DESC', '*',30)}
											{foreach $stats|@array_reverse as $stat}
											['{$stat->date}', {intval($stat->pageViewsUniqueCookiesIP)}],
											{/foreach}
											{literal}
								        ]);
								      drawLineChartMedium('chartLineStatIndex',window.dataStatIndex);
								  }); 
							    </script>
							 {/literal}		
		 					 <div id="chartLineStatIndex" style="width: 99.9%; height: 200px;"></div>
		 				{else}
							<div class="alert alert-info">
							  {L key = "admin.nodata"}
							</div>		 					
		 				{/if}
		 			</div>
		 			{if license::hasPro() or cookie::get('closeGoProBanner')==1}
		 			<div class="box margin-top margin-bottom">	
				  		<h5>
							<i class="fa fa-upload icon-margin icon-grey"></i> {L key = "admin.system.tpl.memory"}
						  	<div class="buttons">
								<a href="{$HOME}admin/system/system/" class="btn btn-small">{L key = "admin.system.tpl.system"}</a>					  		
						  	</div>						
						</h5>
						<h2 class="align-center" style="margin-top:40px;">{cache::read("{$SITE_PATH}")}MB</h2>
						
					  	{literal}
						    <script type="text/javascript">
						      google.load("visualization", "1", {packages:["corechart"]});
						      $(document).ready(function() {
							      window.dataSize = google.visualization.arrayToDataTable([
									  {/literal}
									  ['Date', 'Size'],
									  {foreach array_reverse($systemStatusDB->fetchAll(null, 'id DESC', '*', '30')) as $stat}
									  ['{$stat->date}', {$stat->size}],
									  {/foreach}
							     	  {literal}
							        ]);
							      drawLineChartSmall('chartLineSize',window.dataSize);
							  }); 
						    </script>
						 {/literal}		
						 <div id="chartLineSize" style="width: 99.9%; height:120px;"></div>
					</div>	
					{/if}
			</div>			 	
			<div class="span4 box pad align-center mobileHidden" style="height:516px;">
				<div id="fb-root"></div>
				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/pl_PL/all.js#xfbml=1";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));</script>			
				<div class="fb-like-box"  data-href="http://www.facebook.com/{L key="facebook.page.key"}" data-width="100%" data-height="460px" data-colorscheme="light" data-show-faces="false" data-header="false" data-stream="true" data-show-border="false"></div>	
			</div>
		</div>			  
	  </div>
</div>
