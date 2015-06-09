fallback.load({
	jQuery: [
		'http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js',
		'js/vendor/jquery/dist/jquery.min.js'
	],
	Snap: [
		'http://cdnjs.cloudflare.com/ajax/libs/snap.svg/0.3.0/snap.svg-min.js',
		'js/vendor/snap.svg/dist/snap.svg-min.js'
	],
	Lazysizes: [
		'js/vendor/lazysizes/lazysizes.min.js'
	],
	'app.js': 'js/app.js'
},{
	shim: {
		'app.js': ['jQuery', 'Snap']
	}
})
