function loadDoAction(url,id){
	$.ajaxSetup ({
	    cache: false
	});	
	$(id+' i').load(url, function() {
		$(id+' i').toggleClass('icon-red');
		$(id+' i').toggleClass('icon-grey');	
	});	
}
function loadDoActionDelete(url,id,popupconfirm){
	$.ajaxSetup ({
	    cache: false
	});	
	idclass=id.replace('#', '.');
	if (popupconfirm=='1'){
	    if (confirm("Are you sure?")) {
			$(id).load(url, function() {
				$(idclass).fadeOut('normal', function() {});
				$(id).fadeOut('normal', function() {});
			});	
	    };		
	}else{
		$(id).load(url, function() {
			$(idclass).fadeOut('normal', function() {});
		});		
	}
}
function loadDoActionGreen(url,id){
	$.ajaxSetup ({
	    cache: false
	});	
	$(id+' i').load(url, function() {
		$(id+' i').toggleClass('icon-red');
		$(id+' i').toggleClass('icon-green');	
	});	
}
function toggleHidden(id){
	$('.'+id).toggleClass('hidden');
	if($.cookie(id)=='1'){
		$.cookie(id, '0',{ path: '/'});
	}else{
		$.cookie(id, '1',{ path: '/'});
	}
}
function setTabOpen(name){
	var tabNameArray=name.replace('#','').split('_');
	
	$.cookie('main-'+tabNameArray[0],tabNameArray[1],{path:SUBDIR+'admin/'});
	$.cookie('openMainMenu','main-'+tabNameArray[0],{path:SUBDIR+'admin/'});	
}

function togglepopover(id)
{
	$('i[rel=popovercontentlist][id!=popover-id-'+id+']').popover('hide');
	$('i[id=popover-id-'+id+']').popover('toggle');
}

function putContentInToDiv(target,content){
	$(target).html(decodeURIComponent(content).replace("{{$HOME}}", HOME));
}

function drawLineChartSmall(id,data) {
	google.load("visualization", "1", {packages:["corechart"]});
    var options = {
    		  chartArea:{left:0,width:"100%",height:"100%"},
	          legend:{position: 'none'},
	          width:'100%',
	          height:120,
	          pointSize: 2,
	          vAxis:{gridlines:{color: '#eee', count: 3},textPosition:'in',baselineColor:'#b3bfd8',textStyle:{color:'silver'}},
	          areaOpacity:0.1,
	          hAxis:{textPosition:'none'}

	        };
	
	var chart = new google.visualization.AreaChart(document.getElementById(id));
	chart.draw(data, options);
  }
function drawLineChartMedium(id,data) {
	google.load("visualization", "1", {packages:["corechart"]});
    var options = {
	          chartArea:{left:0,width:"100%",height:"100%"},
	          legend:{position: 'none'},
	          width:'100%',
	          height:200,
	          pointSize: 2,
	          vAxis:{gridlines:{color: '#eee', count:4},textPosition:'in',baselineColor:'#b3bfd8',textStyle:{color:'silver'}},
	          areaOpacity:0.1,
	          hAxis:{textPosition:'none'}	          
	        };
	
	var chart = new google.visualization.AreaChart(document.getElementById(id));
	chart.draw(data, options);
  }


function setFloatingLeftMenu(noleave){
	if($(window).height()<($('#leftMenu').height()+100)){
		$('#sidebar').addClass('positionAbsolute');
	}else if(noleave==true){
		$('#sidebar').removeClass('positionAbsolute');
	}	
}
function boxFloating(className){
	$(className).each(function() {
		if($(window).height()>($(this).height()+100)){
			var marginTop = $('body').scrollTop()-116;
			if(marginTop>0){
				if($('body').height()-$(this).height()-220>$(window).scrollTop()){
					if($('.tab-menu-top').length || $('.alert-nomargin').length){
						$(this).css("margin-top",marginTop);
					}else{
						$(this).css("margin-top",marginTop+55);
					}					
				}else{
					$(this).css("margin-top",$('body').height()-$(this).height()-380);
				}
			}else{
				$(this).css("margin-top",0);
			}
		}else{
			$(this).css("margin-top",0);
		}	
	});	
}
function redrawCharts () {
	if(window.dataVotes!=null){drawLineChartMedium('chartLineVotes',window.dataVotes);}
	
	if(window.dataSize!=null){drawLineChartSmall('chartLineSize',window.dataSize);}
	if(window.dataStat!=null){drawLineChartMedium('chartLineStat',window.dataStat);}
	if(window.dataStatRequest!=null){drawLineChartMedium('chartLineStatRequest',window.dataStatRequest);}
	if(window.dataStatMore!=null){drawLineChartMedium('chartLineStatMore',window.dataStatMore);}
	if(window.dataStatHourDay!=null){drawLineChartMedium('chartLineStatHourDay',window.dataStatHourDay);}
	
	if(window.dataStatAll!=null){drawLineChartMedium('chartLineStatAll',window.dataStatAll);}
	if(window.dataStatRequestAll!=null){drawLineChartMedium('chartLineStatRequestAll',window.dataStatRequestAll);}
	if(window.dataStatMoreAll!=null){drawLineChartMedium('chartLineStatMoreAll',window.dataStatMoreAll);}	
	
	if(window.dataStatLast!=null){drawLineChartMedium('chartLineStatLast',window.dataStatLast);}
	if(window.dataConservationLast!=null){drawLineChartMedium('chartLineStatLastConservation',window.dataConservationLast);}
	
	if(window.dataContacts!=null){drawLineChartMedium('chartLineContacts',window.dataContacts);}
	if(window.dataMailings!=null){drawLineChartMedium('chartLineMailings',window.dataMailings);}
	if(window.dataStatIndex!=null){drawLineChartMedium('chartLineStatIndex',window.dataStatIndex);}
	
	if(window.dataRequestLogMonth!=null){drawLineChartMedium('chartLineRequestsMonth',window.dataRequestLogMonth);}
	if(window.dataRequestLogDay!=null){drawLineChartMedium('chartLineRequestsDay',window.dataRequestLogDay);}
	if(window.dataRequestLogAll!=null){drawLineChartMedium('chartLineRequestsAll',window.dataRequestLogAll);}
	
	if(window.dataStatAlexaGlobalSmall!=null){drawLineChartSmall('dataStatAlexaGlobalSmall',window.dataStatAlexaGlobalSmall);}
	if(window.dataStatAlexaCountrySmall!=null){drawLineChartSmall('dataStatAlexaCountrySmall',window.dataStatAlexaCountrySmall);}
	if(window.dataStatAlexaLinkSmall!=null){drawLineChartSmall('dataStatAlexaLinkSmall',window.dataStatAlexaLinkSmall);}
	
	if(window.dataStatCronHour!=null){drawLineChartMedium('dataStatCronHour',window.dataStatCronHour);}
	if(window.dataStatCronDay!=null){drawLineChartMedium('dataStatCronDay',window.dataStatCronDay);}
	if(window.dataStatCronWeek!=null){drawLineChartMedium('dataStatCronWeek',window.dataStatCronWeek);}
	if(window.dataStatCronMonth!=null){drawLineChartMedium('dataStatCronMonth',window.dataStatCronMonth);}
}
jQuery(function ($) {
	$('a').click(function() {
		var hrefVal = $(this).attr('href');
		if(hrefVal.match('http://') || hrefVal.match('https://')){
			$( "div.alert-waiting" ).show();
		}
	});
	/*
	$('button').click(function() {
		var hrefVal = $(this).attr('href');
		$( "div.alert-waiting" ).show();
	});
	*/
	
	$('.accordion-toggle').click(function(e){
		setTimeout(function(){
			setFloatingLeftMenu(false);
	     },400);
	});

	setFloatingLeftMenu(true);
});	
$(window).resize(function() {
	redrawCharts();
	setFloatingLeftMenu(true);

	if($(window).innerWidth()>752){
		$('#sidebar').show();
		
	}else{
		$('#sidebar').hide();
		$('#content').removeClass('mobileHidden');
	}	
});
$(window).scroll(function () {
	if ($('body').width()>=768){
		boxFloating('.box-floating');
	}
});
$(document).ready(function(){
	$('#tabContent a:first').tab('show');
	$('#tabContent a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
		$.cookie('openContentTab', $(this).attr('href'), '/');
	});	
	
	$('#tabModerator a:first').tab('show');
	$('#tabModerator a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');
		$.cookie('openModeratorTab', $(this).attr('href'), '/');
	});		
	
	$('#requestTab a').click(function (e) {
		e.preventDefault();
		$(this).tab('show');		
		redrawCharts();
	});	
	var url = document.location.toString();
	
	if (url.match('#')) {
	    $('.nav-tabs a[href=#'+url.split('#')[1]+']').tab('show') ;
	}else if($.cookie($.cookie('openMainMenu'))!=null){
		$('.nav-tabs a[href=#'+$.cookie('openMainMenu').replace('main-','')+'_'+$.cookie($.cookie('openMainMenu'))+']').tab('show');
	} 
	
	if($.cookie('openContentTab')!=null){
		$('#tabContent a[href='+$.cookie('openContentTab')+']').tab('show');
	} 	
	if($.cookie('openModeratorTab')!=null){
		$('#tabModerator a[href='+$.cookie('openModeratorTab')+']').tab('show');
	} 		
    $("[data-toggle=popover]").popover({ html : true }).click(function(e){e.preventDefault()});
    if($(window).width()>768){
        $('[data-toggle=tooltip]').tooltip({ html : true });
        $('.tooltip-force').tooltip({ html : true });    	
    }
    
	$("[rel=popovercontentlist]").popover(
	{
		placement:'right',
		trigger:'manual',
		html: true
	});		

	$(".tablesort").tablesorter(); 
	$('div.alert-waiting').fadeOut();
	$('div.alert-top').delay(3000).slideUp();
});
