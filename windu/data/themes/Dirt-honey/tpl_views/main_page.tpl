{{W name=notify}}	

	<div class="smalltop">
		<div class="container relat">
		{{include file='../tpl_common/top.tpl'}}
	</div>
	</div>
		<div class="slider">
			<div class="container subslide">
				{{W name=sliderBootstrap  imagesBucket=737 pagesBucket=737 count=7 fit="fit" filter="blur" width=300 height=500 showContent=true}}
			</div>
		</div>
		
	

	<div class="content">		
		{{W name=newsNormal  newsGroup=861 length=100 showDate=false showTitle=true showContent=true showImg=true showMore=true cssUl="fluid-news" cssLi="msitem" width=300 height=1000 where=true}}	
	</div>
		
			<div class="logos">
				{{foreach $imagesDB->getByBucket(759) as $image}}
			    <a href="{{$image->url}}"><img src="{{$HOME}}image/{{$image->ekey}}/200/150/fit/" alr="strony www"></a>
				{{/foreach}}
			</div>	
		{{include file='../tpl_common/footer.tpl'}}	
</div>
	
