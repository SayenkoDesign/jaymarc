import $ from 'jquery';

export default {
	init() {

		$('.home-recent-posts .post-content').matchHeight();

		$('.acf-block-home-available-custom-homes .overlay').matchHeight(true);

		$('.sell-home-benefits figure').matchHeight(true);
		

		$(".wp-block-gallery .wp-block-image a").attr('data-fancybox', 'gallery');


		$('.home-filters').on('click', '#filters-toggle', function() {
			console.log('clocked');
			let filters = $(this).parents().find('.filters-wrap');  
			let filtersAriaLabel = 'false' == $(this).parents().find('.filters-wrap').attr('aria-expanded') ? 'true' : 'false';
			filters.toggleClass('open');
			filters.attr('aria-expanded', filtersAriaLabel);
		});


		$('.acf-block-location-links').on('click', 'a', function(e) {
			var id = $(this).attr('href');

			// target element
			var $id = $(id);
			if ($id.length === 0) {
				return;
			}

			// prevent standard hash navigation (avoid blinking in IE)
			e.preventDefault();

			// top position relative to the document
			var pos = $id.offset().top - 30;

			$(this).parents().find('li').removeClass('current-menu-item');

			$(this).parent('li').addClass('current-menu-item');

			// animated top scrolling
			$('body, html').animate({scrollTop: pos});
		});
	},
};
