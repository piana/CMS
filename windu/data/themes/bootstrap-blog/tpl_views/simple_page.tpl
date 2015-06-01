{{include file='../tpl_common/top.tpl'}}
<div class="background-footer">
	<div class="container pad-bot">
		<div class="row">
			<div class="col-sm-8 blog-main">
				<div class="blog-post">
					<h4>{{$page->name}}</h4>
					{{eval var=$page->content}}
				</div>
			</div>
			<div class="col-sm-4 hidden-xs col-sm-offset-1 blog-sidebar">
				<div class="sidebar-module sidebar-module-inset">
				{{include file='../tpl_common/left_column.tpl'}}
				</div>
			</div>
		</div>
	</div>
</div>
{{include file='../tpl_common/footer.tpl'}}