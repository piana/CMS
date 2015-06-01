
<div class="smalltop">
	<div class="container">
		{{include file='../tpl_common/top.tpl'}}
	</div>
</div>
<div class="content">	
	<div class="pad smallpad subtext">
		<h4 class="pghead">{{$page->name}}</h4>
		<div class="newsimg">
    	{{$mainImage = $pagesDB->getMainImageEkeySmart($page->id)}}
		{{if $mainImage!=null}}
  			<img class="img-title" src="{{$HOME}}image/{{$mainImage}}/1450/400/smart/original/">
		{{/if}}
		</div>			
		<br><br>
		{{eval var=$page->content}}
		
	</div>            

<div class="footcont">
	{{include file='../tpl_common/footer.tpl'}}
</div>
</div>