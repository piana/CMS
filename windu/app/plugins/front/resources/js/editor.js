(function (factory) {
	if (typeof define === 'function' && define.amd) {
		// AMD. Register as anonymous module.
		define(['jquery'], factory);
	} else {
		// Browser globals.
		factory(jQuery);
	}
}(function ($) {
	var pluses = /\+/g;

	function raw(s) {
		return s;
	}

	function decoded(s) {
		return decodeURIComponent(s.replace(pluses, ' '));
	}

	function converted(s) {
		if (s.indexOf('"') === 0) {
			// This is a quoted cookie as according to RFC2068, unescape
			s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
		}
		try {
			return config.json ? JSON.parse(s) : s;
		} catch(er) {}
	}

	var config = $.cookie = function (key, value, options) {

		// write
		if (value !== undefined) {
			options = $.extend({}, config.defaults, options);

			if (typeof options.expires === 'number') {
				var days = options.expires, t = options.expires = new Date();
				t.setDate(t.getDate() + days);
			}

			value = config.json ? JSON.stringify(value) : String(value);

			return (document.cookie = [
				config.raw ? key : encodeURIComponent(key),
				'=',
				config.raw ? value : encodeURIComponent(value),
				options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
				options.path    ? '; path=' + options.path : '',
				options.domain  ? '; domain=' + options.domain : '',
				options.secure  ? '; secure' : ''
			].join(''));
		}

		// read
		var decode = config.raw ? raw : decoded;
		var cookies = document.cookie.split('; ');
		var result = key ? undefined : {};
		for (var i = 0, l = cookies.length; i < l; i++) {
			var parts = cookies[i].split('=');
			var name = decode(parts.shift());
			var cookie = decode(parts.join('='));

			if (key && key === name) {
				result = converted(cookie);
				break;
			}

			if (!key) {
				result[name] = converted(cookie);
			}
		}

		return result;
	};

	config.defaults = {};

	$.removeCookie = function (key, options) {
		if ($.cookie(key) !== undefined) {
			// Must not alter options, thus extending a fresh object...
			$.cookie(key, '', $.extend({}, options, { expires: -1 }));
			return true;
		}
		return false;
	};

}));
function saveInPlaceEditorContent(id) {
	$("#saveinfo_content_"+id).delay(2000).fadeIn("fast").html('<span class="info" id="info_'+id+'">saving changes ...</span>');
	var content = CKEDITOR.instances['content_'+id].getData();
	$.ajax({
		  type: "POST",
		  processData: "false",
		  url: HOME+"admin/do/content/saveInPlaceEditorContent/",
		  data: { id: 'content_'+id, content: content },
		  success: function( data ) {
			  $("#saveinfo_content_"+id).html('<span id="info_'+id+'">saved successfully</span>');
			  $("#info_"+id).delay(2000).fadeOut("slow");
	      },
	      dataType: "text"
	});	
}
function pasteHtmlAtCaret(html) {
    var sel, range;
    if (window.getSelection) {
        // IE9 and non-IE
        sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            range = sel.getRangeAt(0);
            range.deleteContents();

            // Range.createContextualFragment() would be useful here but is
            // non-standard and not supported in all browsers (IE9, for one)
            var el = document.createElement("div");
            el.innerHTML = html;
            var frag = document.createDocumentFragment(), node, lastNode;
            while ( (node = el.firstChild) ) {
                lastNode = frag.appendChild(node);
            }
            range.insertNode(frag);
            
            // Preserve the selection
            if (lastNode) {
                range = range.cloneRange();
                range.setStartAfter(lastNode);
                range.collapse(true);
                sel.removeAllRanges();
                sel.addRange(range);
            }
        }
    } else if (document.selection && document.selection.type != "Control") {
        // IE < 9
        document.selection.createRange().pasteHTML(html);
    }
}
function editorInsertText(value){
	pasteHtmlAtCaret(value);
}

function toggleLeftMenu(){	
	if($.cookie("hideLeftMenu")==1){
		$.cookie("hideLeftMenu",0);

		$('#adminMenuLeft-container').animate({ width: 'toggle' },400);
		$("body").animate({"padding-left":"250px"},400);		
		
		$(".hideTopMenuButton").animate({"left":"250px"},400);
		$(".hideLeftMenuButton").animate({"left":"250px"},400);
		$(".hideLeftMenuButton").html('‹');
	}else{
		$.cookie("hideLeftMenu",1);
		
		$('#adminMenuLeft-container').animate({ width: 'toggle' },400);
		$("body").animate({"padding-left":"0px"},400);
		
		$(".hideTopMenuButton").animate({"left":"0px"},400);
		$(".hideLeftMenuButton").animate({"left":"0px"},400);
		$(".hideLeftMenuButton").html('›');
	}
}

function handleDragStart (event, ui) {
	$(this).removeClass('static');
	$(this).addClass('dragged');
}

function handleDropEvent (event, ui) {
   $(this).append(ui.draggable.addClass('static'));
   $(this).append(ui.draggable.removeClass('dragged'));
   ui.draggable.css({top: 0, left: 0});
}
jQuery.expr[':'].regex = function(elem, index, match) {
    var matchParams = match[3].split(','),
        validLabels = /^(data|css):/,
        attr = {
            method: matchParams[0].match(validLabels) ? 
                        matchParams[0].split(':')[0] : 'attr',
            property: matchParams.shift().replace(validLabels,'')
        },
        regexFlags = 'ig',
        regex = new RegExp(matchParams.join('').replace(/^\s+|\s+$/g,''), regexFlags);
    return regex.test(jQuery(elem)[attr.method](attr.property));
}
$(document).ready(function() {    
    $('.jeditable').editable(HOME+"admin/do/content/saveJeditableContent/");
    $('.jeditable_area').editable(HOME+"admin/do/content/saveJeditableContent/", { 
        type      : 'textarea',
        cancel    : 'Cancel',
        submit    : 'OK'
    });    
	
	$(".widget .wname").click(function() {
		$( "div" ).remove('#selectModal');
		var params = $(this).parent().find('.wparams').text();
		params = encodeURIComponent(params);
		
		var template = $(this).parent().find('.wtemplate').text();
		template = encodeURIComponent(encodeURIComponent(template));	
		
		$( "body" ).append('<div id="selectModal" class="modal modalSmall" tabindex="-1" role="dialog" aria-hidden="false"><div class="modal-header"><button type="button" class="close" onclick="$(\'#selectModal\').hide(); $(\'.modal-backdrop\').hide();">×</button><h3>Edit widget params</h3></div><div class="modal-body"><iframe src="'+HOME+'admin/ajax/widgets/modalWidgetSelect/'+params+'/'+template+'/"></iframe></div></div><div class="modal-backdrop in"  onclick="$(\'#selectModal\').hide(); $(\'.modal-backdrop\').hide();"></div>');		
		$( "#selectModal" ).css('display','block!important');
	});		
	$(".widget").hover(
			function(){
				window.oldName = $(this).find('.wname').html();
				$(this).find('.wname').html('Click to edit this widget');
			},function(){
				$(this).find('.wname').html(window.oldName);
			}
	);
	
	/*
    $(".widget").draggable({
    	start: handleDragStart,
        cursor: 'move',
        revert: "invalid"
    });
    $("div:regex(class, span*)").droppable({
        drop: handleDropEvent,
        tolerance: "pointer",
        hoverClass: "drop-hover"
    });
    */
   
});

