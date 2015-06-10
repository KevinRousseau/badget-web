(function(){

	var svgArea = Snap('.intro-svg');


	function init(){

		rotateRad();

		moveClouds();

		carousel();

		smallChanges();

		videoSize();

	}

	function videoSize(){

		var video = $('iframe');

		var width = video.width(),
			height = (width/16)*9;

		video.height(height);


		$(window).resize(function() {

			videoSize();

		});

	}

	function smallChanges(){

		$('button').addClass('hidden');

	}

	function carousel(){

		$('.carousel').slick({
			lazyLoad: 'ondemand',
			slidesToShow: 1,
			slidesToScroll: 1,
	    	autoplay: true,
			autoplaySpeed: 3000,
		});

	}

	function moveClouds(){

		var clouds = svgArea.select('#wolken_20'),
		cloudBbox = clouds.getBBox();

		clouds.transform('t200, 0');

		clouds.removeClass('hidden');

		clouds.animate(
			{ transform: 't4000,0' },
			200000,
			function(){
				clouds.attr(
					{ transform: 'position(0 ' + cloudBbox.x + ' ' + cloudBbox.y + ')' }
				);

				moveClouds();
			}
		);
	}


	function rotateRad(){

		var rad = svgArea.select('#rad'),
		radBbox = rad.getBBox();

		rad.animate(
			{ transform: "r360," + radBbox.cx + ',' + radBbox.cy },
			20000,
			function(){
				rad.attr(
					{ transform: 'rotate(0 ' + radBbox.cx + ' ' + radBbox.cy + ')' }
				);

				rotateRad();
			}
		);

	}


	init();

})();
