    var enforceModalFocusFn = $.fn.modal.Constructor.prototype.enforceFocus;
	$.fn.modal.Constructor.prototype.enforceFocus = function () {};
	$(document).on('show.bs.modal', '.modal', function (event) {
		var md = $('.modal');
		var zIndex = 1050 + (10 * md.index(event.target));
		$(event.target).css('z-index', zIndex);
		var bd = $('.modal-backdrop');
		$(bd[bd.length-1]).css('z-index', zIndex-1);
	}).on('hidden.bs.modal', '.modal', function (event) {
		var bd = $('.modal-backdrop');
		$(bd[bd.length-1]).removeAttr('style');
	});