$(document).ready(function() {
	$("a.image_single").fancybox({
		'overlayShow'	: false,
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'elastic'
	});
	$("a[rel=image_group]").fancybox({
		//'overlayShow'	: false,
		'padding' : 2,
		'transitionIn'		: 'elastic',
		'transitionOut'		: 'elastic',
		'titlePosition' 	: 'outside',//over
		'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
			return '<span id="fancybox-title-over">' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ': &nbsp; ' + title : '') + '</span>';
		},
		'onComplete'	:	function() {
			$("#fancybox-wrap").hover(function() {
				$("#fancybox-title").show();
			}, function() {
				$("#fancybox-title").hide();
			});
		}
	});
	$(".details").fancybox({
		'overlayShow'	: false,
		'transitionIn'	: 'elastic',
		'transitionOut'	: 'elastic'
//	'titleShow'		: false
	});
});

