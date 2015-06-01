<h4>{$data.poll->description}</h4>
{foreach $data.poll->questions as $question}

	<div class="row-fluid">
		<div class="span6" style="text-align:right">
	  		<span class="poll-question-description">{$question->description}</span> <strong>{$question->name}</strong>
		</div>
		<div class="span6">
			{if $data.cookie!=1}
				<span style="cursor: pointer;" onclick="CallDoAction('.pollVoteResult-{$question->ekey}','{$HOME}do/vote/{$question->ekey}/');"><i class="icon-ok"></i> {L key="widgets.poll.vote"}</span>
				<span class="pollVoteResult-{$question->ekey}"></span>				
			{else}
				<div class="progress progress-info progress-striped"><div class="bar" style="width: {($question->votes/$data.votesCount)*100}%">{$question->votes}</div></div>		
			{/if}
		</div>		
	</div>	

{foreachelse}
	{L key="widgets.poll.noquestion"}
{/foreach}
