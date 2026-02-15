(function($) {
	"use strict"

	// Mobile Nav toggle
	$('.menu-toggle > a').on('click', function (e) {
		e.preventDefault();
		$('#responsive-nav').toggleClass('active');
	})

	// Fix cart dropdown from closing
	$('.cart-dropdown').on('click', function (e) {
		e.stopPropagation();
	});

	/////////////////////////////////////////

	// Products Slick
	$('.products-slick').each(function() {
		var $this = $(this),
				$nav = $this.attr('data-nav');

		$this.slick({
						slidesToShow: 4,
						slidesToScroll: 1,
						autoplay: true,
						autoplaySpeed: 3000,
						infinite: true,
						speed: 500,
						adaptiveHeight: false,
						lazyLoad: 'ondemand',
						dots: false,
						arrows: true,
						prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
						nextArrow: '<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>',
						appendArrows: $nav ? $nav : false,
						responsive: [
			{
				breakpoint: 1200,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
				}
			},
			{
				breakpoint: 991,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
				}
			},
			{
				breakpoint: 576,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				}
			}
		]
				});
	});

	// Products Widget Slick
	$('.products-widget-slick').each(function() {
		var $this = $(this),
				$nav = $this.attr('data-nav');

		$this.slick({
				slidesToShow: 3,
				slidesToScroll: 1,
				infinite: true,
				autoplay: true,
				autoplaySpeed: 2500,
				speed: 400,
				dots: false,
				arrows: true,
				prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
				nextArrow: '<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>',
				appendArrows: $nav ? $nav : false,
				responsive: [
					{ breakpoint: 991, settings: { slidesToShow: 2 } },
					{ breakpoint: 576, settings: { slidesToShow: 1 } }
				]
			});
	});

	/////////////////////////////////////////

	// Product Main img Slick
	if ($('#product-main-img').length) {
		$('#product-main-img').slick({
	    infinite: true,
	    speed: 300,
	    dots: false,
	    arrows: true,
	    fade: true,
	    asNavFor: '#product-imgs',
	  });
	}

	// Product imgs Slick
	if ($('#product-imgs').length) {
	  $('#product-imgs').slick({
	    slidesToShow: 3,
	    slidesToScroll: 1,
	    arrows: true,
	    centerMode: true,
	    focusOnSelect: true,
			centerPadding: 0,
			vertical: true,
	    asNavFor: '#product-main-img',
			responsive: [{
	        breakpoint: 991,
	        settings: {
						vertical: false,
						arrows: false,
						dots: true,
	        }
	      },
	    ]
	  });
	}

	// Product img zoom
	var zoomMainProduct = document.getElementById('product-main-img');
	if (zoomMainProduct) {
		$('#product-main-img .product-preview').zoom();
	}

	/////////////////////////////////////////

	// Input number
	$('.input-number').each(function() {
		var $this = $(this),
		$input = $this.find('input[type="number"]'),
		up = $this.find('.qty-up'),
		down = $this.find('.qty-down');

		down.on('click', function () {
			var value = parseInt($input.val()) - 1;
			value = value < 1 ? 1 : value;
			$input.val(value);
			$input.change();
			updatePriceSlider($this , value)
		})

		up.on('click', function () {
			var value = parseInt($input.val()) + 1;
			$input.val(value);
			$input.change();
			updatePriceSlider($this , value)
		})
	});

	// var priceInputMax = document.getElementById('price-max'),
	// 		priceInputMin = document.getElementById('price-min');

	// priceInputMax.addEventListener('change', function(){
	// 	updatePriceSlider($(this).parent() , this.value)
	// });

	// priceInputMin.addEventListener('change', function(){
	// 	updatePriceSlider($(this).parent() , this.value)
	// });
	var priceInputMax = document.getElementById('price-max'),
    priceInputMin = document.getElementById('price-min');

	if (priceInputMax) {
		priceInputMax.addEventListener('change', function(){
			if (priceSlider && priceSlider.noUiSlider) {
				priceSlider.noUiSlider.set([null, this.value]);
			}
		});
	}

	if (priceInputMin) {
		priceInputMin.addEventListener('change', function(){
			if (priceSlider && priceSlider.noUiSlider) {
				priceSlider.noUiSlider.set([this.value, null]);
			}
		});
	}


	function updatePriceSlider(elem , value) {
		if ( elem.hasClass('price-min') ) {
			console.log('min')
			priceSlider.noUiSlider.set([value, null]);
		} else if ( elem.hasClass('price-max')) {
			console.log('max')
			priceSlider.noUiSlider.set([null, value]);
		}
	}

	// Price Slider
	var priceSlider = document.getElementById('price-slider');
	if (priceSlider) {
		// Only create the slider if it hasn't already been initialized
			if (!priceSlider.noUiSlider && typeof noUiSlider !== 'undefined') {
				noUiSlider.create(priceSlider, {
				start: [100, 7000],
				connect: true,
				step: 1,
				range: {
					'min': 100,
					'max': 7000
				}
				});

			priceSlider.noUiSlider.on('update', function( values, handle ) {
				var value = values[handle];
				if (priceInputMax && priceInputMin) {
					handle ? priceInputMax.value = value : priceInputMin.value = value;
				}
			});
		} else if (priceSlider.noUiSlider) {
			// slider already initialized elsewhere — sync inputs once
			priceSlider.noUiSlider.on('update', function( values, handle ) {
				var value = values[handle];
				if (priceInputMax && priceInputMin) {
					handle ? priceInputMax.value = value : priceInputMin.value = value;
				}
			});
		}
	}

})(jQuery);
// add by me 
$(document).ready(function() {
    // Product Main img Slick
    $('#product-main-img').slick({
        infinite: true,
        speed: 300,
        dots: false,
        arrows: true,
        fade: true,
        asNavFor: '#product-imgs',
    });

    // Product thumbnails Slick
    $('#product-imgs').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '#product-main-img',
        dots: false,
        centerMode: true,
        focusOnSelect: true
    });
});

// Global search handler: submit from header, redirect to store with params
$(document).ready(function() {
	const $searchForm = $('#searchForm');
	if ($searchForm.length) {
		$searchForm.on('submit', function (e) {
			e.preventDefault();
			const q = ($('#searchInput').val() || '').trim();
			const cat = ($('#categorySelect').val() || '').trim();
			const params = new URLSearchParams();
			if (q) params.append('search', q);
			if (cat && cat !== '0') params.append('category', cat);
			const query = params.toString();
			window.location.href = '/store' + (query ? ('?' + query) : '');
		});
	}
});

