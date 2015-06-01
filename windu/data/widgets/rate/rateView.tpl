<div class="rating-box">
	{assign rate $data.ratesDB->getElementRate($params.ekey,$params.bucket)}
	{if $rate>=1}
		{L key="rate.rates.positive"} <span class="label label-success">{$rate}</span>
	{elseif $rate<0}
		{L key="rate.rates.negative"} <span class="label label-important">{$rate}</span>
	{/if}
</div>
{if $data.ratesDB->checkUnique($params.ekey,$params.bucket)}
	<div class="rate-{$params.ekey} rate-box">
		{if $rate==0}
			{L key="rate.rates.befirst"}
		{/if}	
		<span onclick="CallDoAction('.rate-{$params.ekey}','{$HOME}do/rate/{$params.bucket}/{$params.ekey}/0/');" class="rate-btn" rel="nofollow"><i class="icon-thumbs-down"></i></span>
		<span onclick="CallDoAction('.rate-{$params.ekey}','{$HOME}do/rate/{$params.bucket}/{$params.ekey}/1/');" class="rate-btn" rel="nofollow"><i class="fa fa-thumbs-up"></i></span>
	</div>
{/if}