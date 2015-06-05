fallback.load({
	jQuery: [
		'http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js',
		'vendor/jquery/dist/jquery.min.js'
	],
	'app.js': 'js/app.js'
},{
	shim: {
		'app.js': ['jQuery']
	}
})
