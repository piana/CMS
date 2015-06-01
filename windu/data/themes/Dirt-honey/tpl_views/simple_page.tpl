
<div class="smalltop">
	<div class="container">
	{{include file='../tpl_common/top.tpl'}}
</div>
</div>
<div class="content">
	<div class="pad smallpad subtext">
		<h4 class="pghead">{{$page->name}}</h4>
       		
			{{eval var=$page->content}}
	</div>

		{{include file='../tpl_common/footer.tpl'}}

</div>