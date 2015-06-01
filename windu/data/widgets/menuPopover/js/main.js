$(document).ready(function() {
	$('.menuPopover').hover(
		function () {$(this).children('.menuPopover-popover').show()},
		function () {$(this).children('.menuPopover-popover').fadeOut(100)}
	);		
});