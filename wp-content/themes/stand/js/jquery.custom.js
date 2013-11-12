/*
 * jQuery Framework custom functions
 *
*/

jQuery.noConflict(); // jQuery's control of the $ variable

jQuery(document).ready(function($) {


	/*-----------------------------------------------------------------------------------*/
	/* Superfish - http://users.tpg.com.au/j_birch/plugins/superfish/#options */
	/*-----------------------------------------------------------------------------------*/

	jQuery('#navi ul').superfish({
		delay: 200, // one second delay on mouseout
		animation: {opacity:'show', height:'show'}, // an object equivalent to first parameter of jQuery’s .animate() method
		speed: 'normal', // faster animation speed
		dropShadows: false, // completely disable drop shadows by setting this to false
		autoArrows: true // if true, arrow mark-up generated automatically = cleaner source code at expense of initialisation performance
	});

	// Adding the class for dropdowns instead of 'menu_class' => 'sf-menu'
	jQuery("#navi .custom-menu ul, #navi .menu ul").addClass("sf-menu");
	
	// Remove the class .menu (default wp) because duplicated
	jQuery("#navi .custom-menu ul").removeClass("menu");


	/*-----------------------------------------------------------------------------------*/
	/* Responsive Support */
	/*-----------------------------------------------------------------------------------*/

	// Create a default selected item
	jQuery('select.responsive_menu').prepend('<option value="" selected="selected" disabled="disabled">Menu</option>');

	// Add Warning if no primary menu
	jQuery("#navi .menu").prepend('<div class="menu-notice">To use the Responsive Menu you need to assign a Custom Menu to the primary location under <strong>Appearance > Menus</strong>. If you are new to WordPress see this link <a href="http://en.support.wordpress.com/menus/">http://en.support.wordpress.com/menus/</a></div>');


	/*-----------------------------------------------------------------------------------*/
	/* Contact form validation */
	/*-----------------------------------------------------------------------------------*/

	// $("#contact_form").validate();
	
	// Validate signup form on keyup and submit
	var validator = $("#contact_form").validate({
		rules: {
			contact_name: {
				required: true
			},
			contact_email: {
				required: true,
				email: true
			},
			contact_message: {
				required: true
			}
		},
		messages: {
			contact_name: {
				required: "Please enter your name"
				
			},
			contact_email: {
				required: "Please enter your email address",
				minlength: "Please enter a valid email address"
			},
			contact_message: {
				required: "You need to enter a message"
			}
		},
		// set this class to error-labels to indicate valid fields
		success: function(label) {
			// label.addClass("checked");
		}
	});


	/*-----------------------------------------------------------------------------------*/
	/* PrettyPhoto - http://www.no-margin-for-errors.com/projects/prettyphoto-jquery-lightbox-clone/ */
	/*-----------------------------------------------------------------------------------*/

	function prettyphoto_function() {

		jQuery("a[data-rel^='prettyPhoto']").prettyPhoto({
			theme: 'pp_default',
			opacity: 0.90, /* Value between 0 and 1 */
			show_title: false, /* true/false */
			social_tools: false, /* html or false to disable */
			default_width: 700,
			default_height: 400
		});

	}

	prettyphoto_function();


	/*-----------------------------------------------------------------------------------*/
	/* Isotope - http://isotope.metafizzy.co/ */
	/*-----------------------------------------------------------------------------------*/

	$(window).load(function() {

		// cache container
		var $container = $('#projects, .tax-portfolios #projects, .tax-project_category #projects, .tax-project_tag #projects');

		// initialize isotope
		$container.isotope({
			filter: '*',
			itemSelector : '.element',
			layoutMode : 'fitRows',
			// resizable: false, // disable normal resizing
			animationEngine : 'best-available',
			animationOptions: {
				duration: 750,
				easing: 'linear',
				queue: false,
			},
	  		// set columnWidth to a percentage of container width
	  		masonry: {
	  			columnWidth: $container.width() / 5
	  		}
		});

		// filter items when filter link is clicked
		$('#filters a').click(function(){
			var selector = $(this).attr('data-filter');
			$container.isotope({
				filter: selector,
				animationOptions: {
					duration: 750,
					easing: 'linear',
					queue: false,
				}
			});
			return false;
		});

		// set selected menu items
		var $optionSets = $('.option-set'),
			$optionLinks = $optionSets.find('a');

			$optionLinks.click(function() {
				var $this = $(this);
				// don't proceed if already selected
				if ( $this.hasClass('selected') ) {
					return false;
				}

				var $optionSet = $this.parents('.option-set');
				$optionSet.find('.selected').removeClass('selected');
				$this.addClass('selected'); 
			});

	});


	/*-----------------------------------------------------------------------------------*/
	/* W3C 'rel' attribute */
	/*-----------------------------------------------------------------------------------*/

	jQuery('a[data-rel]').each(function() {
		jQuery(this).attr('rel', jQuery(this).data('rel'));
	});


	/*-----------------------------------------------------------------------------------*/
	/* Back To Top - http://webdesignerwall.com/tutorials/animated-scroll-to-top */
	/*-----------------------------------------------------------------------------------*/

	// hide #back-top first
	$("#back-top").hide();
	
	// fade in #back-top
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) {
				$('#back-top').fadeIn();
			} else {
				$('#back-top').fadeOut();
			}
		});

		// scroll body to 0px on click
		$('#back-top a').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});


	/*-----------------------------------------------------------------------------------*/
	/* MediaElement.js - http://mediaelementjs.com/ - https://github.com/johndyer/mediaelement/ */
	/*-----------------------------------------------------------------------------------*/

	jQuery('audio,video').mediaelementplayer({
		/*defaultVideoWidth: 620,
		defaultVideoHeight: 343,
		audioWidth: 620,
		audioHeight: 30,*/
		success: function(player, node) {
			jQuery('#' + node.id + '-mode').html('mode: ' + player.pluginType);
		}
	});


	/*-----------------------------------------------------------------------------------*/
	/* Equal Height Blocks in Rows - http://css-tricks.com/equal-height-blocks-in-rows/ */
	/*-----------------------------------------------------------------------------------*/

	var currentTallest = 0,
		currentRowStart = 0,
		rowDivs = new Array(),
		$el,
		topPosition = 0;

	$('.related-item, .element').each(function() {

		$el = $(this);
		topPostion = $el.position().top;

		if (currentRowStart != topPostion) {

			// we just came to a new row.  Set all the heights on the completed row
			for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
			rowDivs[currentDiv].height(currentTallest);
		}

			// set the variables for the new row
			rowDivs.length = 0; // empty the array
			currentRowStart = topPostion;
			currentTallest = $el.height();
			rowDivs.push($el);

		} else {

			// another div on the current row.  Add it to the list and check if it's taller
			rowDivs.push($el);
			currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);

		}

		// do the last row
		for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
			rowDivs[currentDiv].height(currentTallest);
		}

	});


	/*-----------------------------------------------------------------------------------*/
	/* iosSlider - http://www.iosscripts.com/iosslider */
	/*-----------------------------------------------------------------------------------*/

	$(document).ready(function() {
		
		$('#slider-default').iosSlider({
			snapToChildren: true,
			desktopClickDrag: true,
			scrollbar: true,
			scrollbarHide: false,
			scrollbarLocation: 'bottom',
			scrollbarHeight: '3px',
			scrollbarBackground: color,
			scrollbarMargin: '0',
			scrollbarOpacity: '1', // 0.75
			scrollbarContainer: '.scrollbar-container',
			scrollbarBorder: 'none',
			scrollbarBorderRadius: '0',
			infiniteSlider: false,
			autoSlide: true,
			responsiveSlideContainer: true,
			responsiveSlides: true,
			navSlideSelector: '.slider-buttons .button',
			navPrevSelector: $('.prevButton'),
			navNextSelector: $('.nextButton'),
			onSlideComplete: slideComplete,
			onSliderLoaded: sliderLoaded,
			onSlideStart: sliderUnselectable,
			unselectableSelector: '.unselectable'
			// onSlideChange: slideChange // select state on slider-buttons .button
		});

	});

	function sliderUnselectable(args) {
		// console.log(args.targetSliderOffset);
	}

	function slideComplete(args) {

		// .slider-text
		$(args.sliderObject).find('.slider-text').attr('style', '');
		$(args.currentSlideObject).find('.slider-text').animate({
			opacity: '.95'
		}, 300, 'linear');

		// indicator, bottom navigation
		$(args.sliderObject).parent().find('.slider-buttons .button').removeClass('selected');
		$(args.sliderObject).parent().find('.slider-buttons .button:eq(' + args.currentSlideNumber + ')').addClass('selected');

		// Unselectable
		$(args.sliderObject).parent().find('.prevButton, .nextButton').removeClass('unselectable');

	    if(args.currentSlideNumber == 0) {
			$(args.sliderObject).parent().find('.prevButton').addClass('unselectable');
	    } else if(args.currentSliderOffset == args.data.sliderMax) {
			$(args.sliderObject).parent().find('.nextButton').addClass('unselectable');
	    }

	}

	function slideChange(args) {  }

	function sliderLoaded(args) {
		slideComplete(args);
	}


	/*-----------------------------------------------------------------------------------*/
	/* Mav Slider - http://mattiaviviani.com/mav-slider/ */
	/*-----------------------------------------------------------------------------------*/

	/*(function() {
		
		var container = $('div.dragdealer').css('overflow', 'hidden'),
		
		slider = new Slider( "100", mav_slider_height, container, $('#slideshowmenu'), $('#slideshownav') ); // variable: mav_slider_height = 360px standard

		slider.nav.find('#link'+slider.currentPosition).addClass('active'); // activate selection // Mav

		slider.cris.find('a').on('click', function() { // next prev event

			slider.setCurrent($(this).attr('href').substring(1) );
			slider.slideshow.setStep(slider.currentPosition); // go to slide
			slider.nav.find('a').removeClass('active'); // remove sections
			slider.nav.find('#link'+slider.currentPosition).addClass('active'); // activate selection

		});

		slider.nav.find('a').on('click', function() { // click navigation

			var temp_selection = $(this).attr('href').substring(1);

			if (slider.currentPosition != temp_selection) { // if click different then current
				slider.nav.find('a').removeClass('active'); // remove sections
				jQuery(this).addClass('active'); // activate selection
				slider.slideshow.setStep(temp_selection); // go to slide
				slider.currentPosition = temp_selection; // update current position
				return false;
			}

		});

		// Timer
		var timer = new Timer(mav_slider_timer); // Change the time interval variable: mav_slider_height = 6000
		timer.addEventListener(TimerEvent.TIMER, function(e)
		{
			slider.setCurrent('next');
			slider.slideshow.setStep(slider.currentPosition); // go to slide
			slider.nav.find('a').removeClass('active'); // remove sections
			slider.nav.find('#link'+slider.currentPosition).addClass('active'); // activate selection
		});
		timer.start();
		slider.container.on('mouseover', function() { // stop the timer and start it back on mouseover
			timer.stop();
		});	
		slider.container.on('mouseout', function() {
			timer.start();
		});	
		slider.nav.on('mouseover', function() {
			timer.stop();
		});	
		slider.nav.on('mouseout', function() {
			timer.start();
		});	
		slider.cris.on('mouseover', function() {
			timer.stop();
		});	
		slider.cris.on('mouseout', function() {
			timer.start();
		});	
	})();*/




}); // jQuery.custom ends
