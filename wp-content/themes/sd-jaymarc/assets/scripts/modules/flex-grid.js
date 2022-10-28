import $ from 'jquery';

export default {
	init() {
		$('.flex-grid').each(function() {
			$(this).addClass('flex-grid-' + $(this).children().length);
		});
	},
};
