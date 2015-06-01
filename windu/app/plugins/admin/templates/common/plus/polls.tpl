<div class="tab-menu-top">
	<a href="{$HOME}admin/content/polls/" class="btn btn-small pull-left"><i class="fa fa-home icon-grey icon-nomargin" ></i></a>
	<h3 class="pull-left tab-title"> {L key = "admin.tools.tpl.polls"}</h3>
	<a href="{$HOME}admin/content/polls/addPoll/" class="btn btn-primary btn-small">{L key = "admin.common.plus.polls.tpl.add"}</a>
</div>	
<div class="row-fluid">
	{if $pollsDB->fetchCount()==0 and $REQUEST->getVariable('action')!='addPoll'}
		<div class="center-box">
			<a href="{$HOME}admin/content/polls/addPoll/" class="btn btn-large">
				<i class="fa fa-plus-circle fa-2x"></i>
				{L key = "admin.common.plus.polls.tpl.add"}
			</a>
		</div>	
	{else}
		<div class="span4">
			<div class="box">
				<h5>
					<i class="fa fa-list-alt icon-margin icon-grey"></i> {L key = "admin.common.plus.polls.tpl.polls"}
				  	<div class="buttons">
				  		<a href="{$HOME}admin/content/polls/addPoll/" class="btn btn-primary btn-small">{L key = "admin.common.plus.polls.tpl.add"}</a>
				  	</div>				
				</h5>
				<table class="table table-striped">
				  <tbody>
					{foreach $pollsDB->fetchAll() as $poll}
				    <tr {if ($poll->id == $REQUEST->getVariable('id'))}class="active"{/if}>
				      <td>
				      	<i class="color-icons icons-cheque icon-margin"> </i>
						{$poll->name}
				      </td>
				      <td>
				      	{literal}{{W name=poll id={/literal}{$poll->id}{literal}}}{/literal}
				      </td>	
				      <td>
					    <div class="buttons buttons-five">
					   		<a href="{$HOME}admin/content/polls/showPoll/{$poll->id}/"><i class="fa fa-align-justify icon-blue">&nbsp;</i></a>
					    	<a href="{$HOME}admin/content/polls/addQuestionsPoll/{$poll->id}/"><i class="fa fa-plus-circle icon-green">&nbsp;</i></a>
					    	<a href="{$HOME}admin/content/polls/editPoll/{$poll->id}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
					    	<span href="#" onclick="loadDoAction('{$HOME}admin/do/content/toggleActivationPoll/{$poll->id}/','#hidden-{$poll->id}')" id='hidden-{$poll->id}'><i class="fa fa-eye {if $poll->status == 1}icon-grey{else}icon-red{/if}">&nbsp;</i></span>
					    	<a href="{$HOME}admin/do/content/deletePoll/{$poll->id}/"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>
					    </div>
				      </td>
				    </tr>
				    {foreachelse}
				    <tr>	
				    	<td>
				    		{L key="admin.tools.tpl.banners.nodata"}
				    	</td>
				    </tr>
					{/foreach}		  	
				  </tbody>
				</table>
			</div>
		</div>
		{if $showQuestionList==1}
			<div class="span4">
				<div class="box">
					<h5>
						<i class="fa fa-question-circle icon-margin icon-grey"></i> {L key = "admin.common.plus.polls.tpl.questions"}
					  	<div class="buttons">
					  		<a href="{$HOME}admin/content/polls/addQuestionsPoll/{$REQUEST->getVariable('id')}/" class="btn btn-primary btn-small">{L key = "admin.common.plus.polls.tpl.addansw"}</a>
					  	</div>				
					</h5>	
					<table class="table table-striped">
					  <tbody>
						{foreach $pollQuestionsDB->fetchAll("pollId={$REQUEST->getVariable('id')}") as $question}
					    <tr {if ($question->id == $REQUEST->getVariable('secoundId'))}class="active"{/if}>
					      <td>
					      	<i class="color-icons icons-cheque icon-margin"> </i>
							{$question->name}
					      </td>
					      <td>
						    <div class="buttons buttons-two">
						    	<a href="{$HOME}admin/content/polls/editQuestionsPoll/{$REQUEST->getVariable('id')}/{$question->id}/"><i class="fa fa-pencil icon-blue">&nbsp;</i></a>
						    	<a href="{$HOME}admin/do/content/deleteQuestion/{$question->id}/"><i class="fa fa-times-circle icon-red">&nbsp;</i></a>
						    </div>
					      </td>
					    </tr>
						{/foreach}	  	
					  </tbody>
					</table>							
				</div>
			</div>	
			<div class="span4">
				<div class="box">
					<h5><i class="fa fa-plus-circle icon-margin icon-grey"></i> {L key = "admin.common.plus.polls.tpl.addquest"}</h5>			
					{if is_object($formQuestionPoll)}
						{$formQuestionPoll->toHtml()}
					{/if}
				</div>
			</div>			
		{else}
			<div class="span8">
				{if is_object($formAddPoll)}
					<div class="box">
						{$formAddPoll->toHtml()}
					</div>
				{else}
					<div class="box">
						<h5><i class="fa fa-thumbs-up icon-margin icon-grey"></i> {L key = "admin.common.plus.polls.tpl.votes"}</h5>
					  	{literal}
						    <script type="text/javascript">
						      google.load("visualization", "1", {packages:["corechart"]});
						      $(document).ready(function() {
							      window.dataVotes = google.visualization.arrayToDataTable([
						    	      {/literal}
						    	      ['Date', 'Requests'],
						    	      {foreach array_reverse($pollAnswersDB->fetchCountGroup("strftime('%Y%m%d', createTime)",$pollChartWhere,'createTime DESC')) as $stat}
						    	      ['{$stat->createTime}', {$stat->{"COUNT(strftime('%Y%m%d', createTime))"}}],
						    	      {foreachelse}
						    	      ['0000-00-00 00:00:00', 0]
						    	      {/foreach}
						    	      {literal}
							        ]);
							      drawLineChartMedium('chartLineVotes',window.dataVotes);
							  }); 
						    </script>
						 {/literal}		
						 <div id="chartLineVotes" style="width: 99.9%; height:200px;"></div> 
					</div>			
				{/if}
			</div>
		{/if}
	{/if}	
</div>