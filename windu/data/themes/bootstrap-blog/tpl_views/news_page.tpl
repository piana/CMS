{{include file='../tpl_common/top.tpl'}}
<div class="background-footer">
	<div class="container big-box pad-bot">
		<div class="row-fluid">
			<div class="col-sm-8 blog-main">
				<div class="box news-page">
					<h2>{{$page->name}}</h2>
	            		{{if pagesDB::getMainImageEkey($page->id)!=null}}
	            			<img src="{{$HOME}}image/{{pagesDB::getMainImageEkey($page->id)}}/572/100/"><br><br>	
	            		{{/if}}
						{{eval var=$page->content}}
					<br><br>
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