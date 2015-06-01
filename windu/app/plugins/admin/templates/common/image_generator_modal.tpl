<div id="imageGeneratorModal" class="modal hide" tabindex="-1"
	role="dialog" aria-labelledby="myModalLabel" aria-hidden="false"
	style="margin: 0 0 0 -35%; width: 70%; height: 700px">
	<button type="button" class="close" data-dismiss="modal"
		aria-hidden="true"
		style="position: absolute; right: 10px; top: 10px; padding: 10px;">×</button>
	<div class="modal-body" style="max-height: 700px;  padding-right:0px; margin-right:0px;">
		<script>
  function stopFinishAction(){
	  window.width = $( "#width" ).attr('value');
	  window.height = $( "#height" ).attr('value');
	  window.fit = $( "#fitType" ).text();
	  
	  window.brightness = $( "#brightness" ).attr('value');
	  window.contrast = -1*$( "#contrast" ).attr('value');
	  window.colorize1 = $( "#colorize1" ).attr('value');
	  window.colorize2 = $( "#colorize2" ).attr('value');
	  window.colorize3 = $( "#colorize3" ).attr('value');
	  window.colorize4 = $( "#colorize4" ).attr('value');
	  window.smooth = $( "#smooth" ).attr('value');
	  window.pixelate = $( "#pixelate" ).attr('value');
	  
	  $( "#code" ).html("{$HOME}image/{$image->ekey}/" + window.width + "/" + window.height + "/" + window.fit + "/custom.2," + window.brightness + ".3," + window.contrast + ".4," + window.colorize1 + "," + window.colorize2 + "," + window.colorize3 + "," + window.colorize4 + ".10," + window.smooth + ".11," + window.pixelate + "/"); 
	  $( "#picture" ).attr('src', "{$HOME}image/{$image->ekey}/" + window.width + "/" + window.height + "/" + window.fit + "/custom.2," + window.brightness + ".3," + window.contrast + ".4," + window.colorize1 + "," + window.colorize2 + "," + window.colorize3 + "," + window.colorize4 + ".10," + window.smooth + ".11," + window.pixelate + "/");
  }

  $(function() {
    $( "#slider-width" ).slider({
      range: "min",
      min: 10,
      max: 1600,
      value: {$image->width},
      slide: function( event, ui ) {
		  $( "#width" ).attr('value',ui.value);
      },
      stop: function( event, ui ) {
    	  stopFinishAction();
      }
    });
    $( "#slider-height" ).slider({
        range: "min",
        min: 10,
        max: 1600,
        value: {$image->height},
        slide: function( event, ui ) {
		  $( "#height" ).attr('value',ui.value);
        },
        stop: function( event, ui ) {
      	  stopFinishAction();
        }      
      });
    $( "#slider-brightness" ).slider({
        range: "min",min: -255,max: 255,value: 0,
        slide: function( event, ui ) { $( "#brightness" ).attr('value',ui.value); },
        stop: function( event, ui ) { stopFinishAction(); }
      });    
    $( "#slider-contrast" ).slider({
        range: "min",min: -255,max: 255,value: 0,
        slide: function( event, ui ) { $( "#contrast" ).attr('value',ui.value); },
        stop: function( event, ui ) { stopFinishAction(); }
      });  
    $( "#slider-colorize1" ).slider({
        range: "min",min: 0,max: 255,value: 0,
        slide: function( event, ui ) { $( "#colorize1" ).attr('value',ui.value); },
        stop: function( event, ui ) { stopFinishAction(); }
      });  
    $( "#slider-colorize2" ).slider({
        range: "min",min: 0,max: 255,value: 0,
        slide: function( event, ui ) { $( "#colorize2" ).attr('value',ui.value); },
        stop: function( event, ui ) { stopFinishAction(); }
      }); 
    $( "#slider-colorize3" ).slider({
        range: "min",min: 0,max: 255,value: 0,
        slide: function( event, ui ) { $( "#colorize3" ).attr('value',ui.value); },
        stop: function( event, ui ) { stopFinishAction(); }
      }); 
    $( "#slider-colorize4" ).slider({
        range: "min",min: 0,max: 127,value: 0,
        slide: function( event, ui ) { $( "#colorize4" ).attr('value',ui.value); },
        stop: function( event, ui ) { stopFinishAction(); }
      });             
    $( "#slider-smooth" ).slider({
        range: "min",min: -100,max: 100,value: 100,
        slide: function( event, ui ) { $( "#smooth" ).attr('value',ui.value); },
        stop: function( event, ui ) { stopFinishAction(); }
      });  
    $( "#slider-pixelate" ).slider({
        range: "min",min: 0,max: 200,value: 0,
        slide: function( event, ui ) { $( "#pixelate" ).attr('value',ui.value); },
        stop: function( event, ui ) { stopFinishAction(); }
      });                  
  });
  function setFitType(fitType){
	  	$( '.selected' ).attr('class','');
	  	$( '#' + fitType ).attr('class','selected');
	  	$( "#fitType" ).html(fitType);
	  	stopFinishAction();
	}
  $("#height").keypress(function() {
	  alert("Handler for .keypress() called.");
	});	

</script>

		<div class="row-fluid">
			<div class="span8 pad">
				<img id="picture" src="{$HOME}image/{$image->ekey}/600/600/fit/">
				<hr>
				<div id="code"></div>
			</div>
			<div class="span4 pad"
				style="text-align:right; background-color: #f5f5f5; border-left: solid #e5e5e5 1px; height: 100%; padding: 40px; height: 700px;">
				<span id="fitType" style="visibility: hidden;">fit</span>
				<a href="#" onClick="setFitType('fit')" id="fit">Fit</a> | 
				<a href="#" onClick="setFitType('limit')" id="limit">Limit</a> | 
				<a href="#"	onClick="setFitType('smart')" id="smart">Smart</a><br>
				<a href="#"	onClick="setFitType('smart_top')" id="smart">Smart Top</a>
				<a href="#"	onClick="setFitType('smart_top_left')" id="smart">Smart Top-L</a> | 
				<a href="#"	onClick="setFitType('smart_top_right')" id="smart">Smart Top-R</a>
				
				<br>
				
				
				<br> Szerokość <input type="text" id="width" value="600"> px<br>
				<div id="slider-width" class="jquery-slider-slide"></div>

				Wysokość <input type="text" id="height" value="600"> px<br>
				<div id="slider-height" class="jquery-slider-slide"></div>
<hr>
				Jasność <input type="text" id="brightness" value="0"><br>
				<div id="slider-brightness" class="jquery-slider-slide"></div>

				Kontrast <input type="text" id="contrast" value="0"><br>
				<div id="slider-contrast" class="jquery-slider-slide"></div>
<hr>
				Nasycenie RED<input type="text" id="colorize1" value="0"><br>
				<div id="slider-colorize1" class="jquery-slider-slide red"></div>
				Nasycenie GREEN<input type="text" id="colorize2" value="0"><br>
				<div id="slider-colorize2" class="jquery-slider-slide green"></div>
				Nasycenie BLUE<input type="text" id="colorize3" value="0"><br>
				<div id="slider-colorize3" class="jquery-slider-slide blue"></div>
				Nasycenie Alpha <input type="text" id="colorize4" value="0"><br>
				<div id="slider-colorize4" class="jquery-slider-slide"></div>
<hr>
				Wygładzenie <input type="text" id="smooth" value="100"><br>
				<div id="slider-smooth" class="jquery-slider-slide"></div>

				Pikselowanie <input type="text" id="pixelate" value="0"><br>
				<div id="slider-pixelate" class="jquery-slider-slide"></div>
			</div>
		</div>

	</div>
</div>
