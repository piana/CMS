<div class="container">
{{include file='../tpl_common/top.tpl'}}
</div>
<div class="bckground">
	<div class="container">
		<div class="row simplerow">
			<div class="col-md-4 hidden-xs hidden-sm">
				{{include file='../tpl_common/left_column.tpl'}}
			</div>
			<div class="col-md-8 newsmd8">
					<h2>{{$page->name}}</h2>
					{{W name=navigation page=$page}}
					{{eval var=$page->content}}
			</div>
		</div>
	</div>
</div>	

{{include file='../tpl_common/footer.tpl'}}

</div>