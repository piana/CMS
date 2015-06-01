$(document).ready(function() {    
	$("img").click(function() {
		if($(this).attr('src').indexOf(HOME) != -1){
			$( "div" ).remove('#selectModal');
			var srcValue = encodeURIComponent(encodeURIComponent($(this).attr('src').replace(HOME, '')));
			$( "body" ).append('<div id="selectModal" class="modal modalSmall" tabindex="-1" role="dialog" aria-hidden="false"><div class="modal-header"><button type="button" class="close" onclick="$(\'#selectModal\').hide(); $(\'.modal-backdrop\').hide();">×</button><h3>Zamień obrazek</h3></div><div class="modal-body"><iframe src="'+HOME+'admin/ajax/images/modalImageSelectUploader/'+srcValue+'/"></iframe></div></div><div class="modal-backdrop in" onclick="$(\'#selectModal\').hide(); $(\'.modal-backdrop\').hide();"></div>');		
			$( "#selectModal" ).show();
		}
	});	
	$("a").click(function(event) {
		var images = $(this).find('img');
		if (images.length) {
			event.preventDefault();
		}
	});		
});
