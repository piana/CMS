	<div class="loginbox">
		<img src="{$HOME}app/plugins/admin/resources/img/logo-login{license::get()}.png">
		<div class="loginbox-white">
			<script>
				{literal}
				function errorShow(){
		            $('#ajax-status').html('<span style="color:red">error</span>');
                    $("#ajax-error").removeClass('hidden');
                    $(".progress").addClass('progress-danger');
                    $(".progress").removeClass('active');
				}
			 	$(document).ready(function() {
			 		$.ajaxSetup ({
			 		    cache: false
			 		});	
			 		var toCheckArray = new Array({/literal}{$updateMethods}{literal});	
			 		window.barWidth = 10;
			 		barWidthPart = 90/toCheckArray.length;

			 		$('#ajax-error-message').load('{/literal}{$HOME}{literal}admin/do/update/download/', function(response) {
			 		    
		 				if(response==1){
		 					window.barWidth = window.barWidth+barWidthPart; $(".bar").css('width',window.barWidth+'%');
		 					$('#ajax-status').html('{/literal}{L key="admin.update.controller.downloadupdate"}{literal}');
    				 		$('#ajax-error-message').load('{/literal}{$HOME}{literal}admin/do/update/makeUpdate/', function(response) {
    				 		    
    				 		    if(response==1){    
        			 				window.barWidth = window.barWidth+barWidthPart; $(".bar").css('width',window.barWidth+'%');
        			 				$('#ajax-status').html('{/literal}{L key="admin.update.controller.beginupdate"}{literal}');
        					 		$('#ajax-error-message').load('{/literal}{$HOME}{literal}admin/do/update/flushCache/', function(response) {
        					 		    
        					 		    if(response==1){ 
        				 				    window.barWidth = window.barWidth+barWidthPart; $(".bar").css('width',window.barWidth+'%');
        				 				    $('#ajax-status').html('{/literal}{L key="admin.update.controller.flushcache"}{literal}');
            						 		$('#ajax-error-message').load('{/literal}{$HOME}{literal}admin/do/update/updatePHP/', function(response) {
            						 		    
            						 		    if(response==1){ 
                					 				window.barWidth = window.barWidth+barWidthPart; $(".bar").css('width',window.barWidth+'%');
                					 				$('#ajax-status').html('{/literal}{L key="admin.update.controller.updatephp"}{literal}');
                							 		$('#ajax-error-message').load('{/literal}{$HOME}{literal}admin/do/update/checkSystem/', function(response) {
                							 		    
                							 		    if(response==1){ 
                    						 				window.barWidth = window.barWidth+barWidthPart; $(".bar").css('width',window.barWidth+'%');
                    						 				$('#ajax-status').html('{/literal}{L key="admin.update.controller.checksystem"}{literal}');
                    								 		$('#ajax-error-message').load('{/literal}{$HOME}{literal}admin/do/update/finish/', function(response) {
                    								 		    
                    								 		    if(response==1){ 
                        							 				window.barWidth = window.barWidth+barWidthPart;
                        							 				$('#ajax-status').html('{/literal}{L key="admin.update.controller.finish"}{literal}');
                        							 				$(".bar").css('width',window.barWidth+'%');
                        							 				$(".progress").addClass('progress-success');
                        											window.location.replace('{/literal}{$HOME}{literal}admin/check/');
                                                                }else{
                                                                    errorShow();
                                                                }});
                                                        }else{
                                                            errorShow();
                                                        }});
                                                }else{
                                                    errorShow();
                                                }});
                                        }else{
                                            errorShow();
                                        }});
                                }else{
                                    errorShow();
                                }});	
    				 	}else{
                            errorShow();
                        }});
			    });
			 	{/literal}
			</script>
			<div class="pad">
				<h3>{L key="admin.update.controller.systemupdate"}</h3>
				<div id="ajax-status">{L key="admin.update.controller.checkForUpdates"}</div>
				<div class="progress progress-striped active">
				  <div class="bar" style="width: 10%;"></div>
				</div>
				<div id="ajax-error" class="hidden">
				    <div id="ajax-error-message"></div>
				    <hr>
				    <a href="{$HOME}admin/update/" class="btn btn-warning btn-large">{L key="admin.update.controller.tryagain"}</a>
				</div>
			</div>	
		</div>
		<p class="text-shadow">Windu 3.1 rev. {config::get(revision)}</p>
	</div>
