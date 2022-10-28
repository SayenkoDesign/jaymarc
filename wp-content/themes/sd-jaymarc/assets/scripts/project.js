import $ from 'jquery';

import '@accessible360/accessible-slick';

// jquery match height NMP
import jqueryMatchHeight from 'jquery-match-height';

// Custom Modules

import general from './modules/general';
import frontpage from './modules/frontpage';

import fancyBox from './modules/fancybox';

import accordion from './modules/accordion';

import flexGrid from './modules/flex-grid';

/* window.onload = () => {
	modules.init();
}; */

document.addEventListener('DOMContentLoaded', function () {
	general.init();
	frontpage.init();
	fancyBox.init();
	accordion.init();
	// flexGrid.init();


	let $slider = $('.acf-block-about-logos');

	if ($('.slick', $slider).length) {

		let $counter = $('.slick-counter', $slider);

		$('.slick', $slider).on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
			//currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
			let i = (currentSlide ? currentSlide : 0) + 1;
			$counter.html(i + '<span> | </span>' + slick.slideCount);
		});
	}

	$slider = $('.acf-block-about-values');

	if ($('.slick', $slider).length) {

		let $counter = $('.slick-counter', $slider);

		$('.slick', $slider).on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
			//currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
			let i = (currentSlide ? currentSlide : 0) + 1;
			$counter.html(i + '<span> | </span>' + slick.slideCount);
		});
	}

	$('.slick').slick();
	$('.slick-cloned').find('a').removeAttr('data-fancybox'); // remove duplicate fancbox

}, false);