	<div class="loginbox">
		<img src="{$HOME}app/plugins/admin/resources/img/logo-login{license::get()}.png">
		<div class="loginbox-white">
			<script>
				{literal}
			 	$(document).ready(function() {
			 		$.ajaxSetup ({
			 		    cache: false
			 		});
	
			 		var toCheckArray = new Array({/literal}{$methodsToCheckSerialized}{literal});	
			 		window.barWidth = 10;
			 		window.counter = toCheckArray.length;
			 		
				 	$.each(toCheckArray , function( index, checkType ) {
				 		$('#ajax-response').load('{/literal}{$HOME}{literal}admin/do/login/ajaxCheck/'+checkType+'/', function(response) {
			 				window.barWidth = window.barWidth+(90/toCheckArray.length);
			 				$(".bar").css('width',window.barWidth+'%');
							
				 			if(window.counter<=1){
				 				$(".bar").css('width','100%');
				 				$(".progress").addClass('progress-success');
				 				$(".progress").removeClass('active');				 				
				 				window.location.replace('{/literal}{$backUrl}{literal}');
						 	}	
				 			window.counter = window.counter-1;
				 		});
					});
			    });
			 	{/literal}
			</script>
			<div class="pad">
				<h3>{L key="admin.check.system"}</h3>
				<div id="ajax-response"></div>
				<div class="progress progress-striped active">
				  <div class="bar" style="width: 10%;"></div>
				</div>
			</div>	
		</div>
		<p class="text-shadow">Windu 3.1 rev. {config::get(revision)}</p>
	</div>
