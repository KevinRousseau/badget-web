fallback.load({
	jQuery: [
		'http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js',
		'js/vendor/jquery/dist/jquery.min.js'
	],
	Snap: [
		'http://cdnjs.cloudflare.com/ajax/libs/snap.svg/0.3.0/snap.svg-min.js',
		'js/vendor/snap.svg/dist/snap.svg-min.js'
	],
	lazysizes: [
		//'http://cdnjs.cloudflare.com/ajax/libs/lazysizes/1.1.2/lazysizes.min.js',
		'js/vendor/lazysizes/lazysizes.min.js'
	],
	Slick: [
		//'http://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.5/slick.min.js',
		'js/vendor/slick.js/slick/slick.min.js'
	],
	'app.js': 'js/app.js'
},{
	shim: {
		'Slick': ['jQuery'],
		'Snap': ['jQuery'],
		'app.js': ['Snap']
	}
})
