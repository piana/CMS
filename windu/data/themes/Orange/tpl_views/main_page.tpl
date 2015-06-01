<div class="container relat mdcontainer">
{{include file='../tpl_common/top.tpl'}}
	<div class="slider">
		<div class="subslide">
			{{W name=sliderBootstrap imagesBucket=737 count=7 width=1170 height=500 fit=smart}}
		</div>
	</div>
	<div class="row infobox">
        <div class="col-md-4 gap">
	          <span class="glyphicon glyphicon-search big-icon"></span>
	          <h2>{{$pagesDB->get(742,'name')}}</h2>
	          {{eval var=$pagesDB->getContent(742)|truncate:300}}<br/><br/>
	          <p><a class="btn btn-color btn-more" href="#_add_your_url" role="button">{{L key="front.form.more"}}</a></p>
        </div>
        <div class="col-md-4 gap">
	          <span class="glyphicon glyphicon-fire big-icon"></span>
	          <h2>{{$pagesDB->get(740,'name')}}</h2>
	          {{eval var=$pagesDB->getContent(740)|truncate:300}}<br/><br/>
	          <p><a class="btn btn-color btn-more" href="#_add_your_url" role="button">{{L key="front.form.more"}}</a></p>
        </div>
        <div class="col-md-4 gap">
	          <span class="glyphicon glyphicon-globe big-icon"></span>
	          <h2>{{$pagesDB->get(741,'name')}}</h2>
	          {{eval var=$pagesDB->getContent(741)|truncate:300}}<br/><br/>
	          <p><a class="btn btn-color btn-more" href="#_add_your_url" role="button">{{L key="front.form.more"}}</a></p>
        </div>
    </div>
   </div>
   <div class="bckground">
		<div class="container">	
			<div class="news smnews">
				<div class="center">
					<h1>{{L key="editable.front.news"}}</h1>
				</div>
					<div class="container-fluid">
						{{W name=newsNormal  newsGroup=745 count=4 length=220 showDate=false showTitle=true showContent=true showImg=true showMore=true cssUl="row" cssLi="col-md-6" width=120 height=120 where=true}}
					</div>
				<div class="center margin-bottom-lg">
					<a href="#_add_your_url" class="btn btn-lg btn-color btn-purpbig">{{L key="editable.front.news"}}</a>
				</div>
			</div>
		</div>	
	</div>
		<div class="bckgroundlogo">
			<div class="container">
				<div class="logos">
					{{foreach $imagesDB->getByBucket(759) as $image}}
					<img src="{{$HOME}}image/{{$image->ekey}}/200/150/fit/" alr="strony www">
					{{/foreach}}
				</div>		
			</div>
		</div>
	{{include file='../tpl_common/footer.tpl'}}

