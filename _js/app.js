(function(){

	var svgArea1 = Snap('.intro-svg');
	var svgArea2 = Snap('.outro-svg');


	function init(){

		rotateRad();

		clouds();

		carousel($('.carousel'));

		carousel($('.carousel-footer'));

		smallChanges();

		videoSize();

		//getData();

	}

	function getData(){

		//TODO
		//invullen aantal personen die challenge hebben gespeeld per challenge

		$.ajax({
			url: "http://student.howest.be/toon.bertier/20142015/MA4/BADGET/api/challenges/1",
			type: 'GET',
			dataType: 'json',
			success: function(data){
				console.log(data);
			}

		});

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

	function carousel(element){

		element.slick({
			lazyLoad: 'ondemand',
			slidesToShow: 1,
			slidesToScroll: 1,
	    	autoplay: true,
			autoplaySpeed: 3000,
		});

	}

	function clouds(){

		var clouds1 = svgArea1.select('#wolken_1'),
		cloudBbox1 = clouds1.getBBox();

		var clouds2 = svgArea2.select('#wolken_2'),
		cloudBbox2 = clouds2.getBBox();

		moveClouds(clouds1, cloudBbox1);

		moveClouds(clouds2, cloudBbox2);


	}

	function moveClouds(cloud, cloudBox){

		cloud.transform('t200, 0');

		cloud.removeClass('hidden');

		cloud.animate(
			{ transform: 't4000,0' },
			200000,
			function(){
				clouds.attr(
					{ transform: 'position(0 ' + cloudBox.x + ' ' + cloudBox.y + ')' }
				);

				clouds();
			}
		);
	}


	function rotateRad(){

		var rad = svgArea1.select('#rad'),
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
