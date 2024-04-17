const mix = require('laravel-mix');
require('laravel-mix-polyfill');
require('laravel-mix-copy-watched');
require('laravel-mix-imagemin');

const glob = require("glob");
const path = require('path');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Sage application. By default, we are compiling the Sass file
 | for your application, as well as bundling up your JS files.
 |
 */

 mix.options({
    // Don't perform any css url rewriting by default
    processCssUrls: true,
})


mix.setPublicPath('./dist');
mix.setResourceRoot('..');

mix.browserSync({
	proxy: 'http://jaymarc.local',
	port: 3000,
	notify: false,
	open: true,
	files: [
		'front-page.php',
		'archive*.php',
		'single*.php',
		'blocks/**/*.php',
		'page-templates/**/*.php',
		'template-parts/**/*.php',
		'dist/scripts/**/*.js',
		'dist/styles/**/*.css'
	],
});


mix.webpackConfig({
	stats: 'minimal',
	devtool: mix.inProduction() ? false : 'source-map',
	performance: { hints: false },
	externals: { jquery: 'jQuery' },
});

mix.autoload({
	jquery: ['$', 'window.jQuery'],
});

mix.js('assets/scripts/project.js', 'scripts')
	//.js('assets/scripts/acf-map.js', 'scripts')
	.js('assets/scripts/home-map.js', 'scripts')
	.js('assets/scripts/contact-map.js', 'scripts')
	.sass('assets/styles/style.scss', 'styles')
	.sass( 'assets/styles/editor-style.scss', 'styles' )
	.options({ processCssUrls: true })
	/* .polyfill({
		enabled: true,
		useBuiltIns: "usage",
		targets: "firefox 50, IE 11"
	}) */
	.copyWatched('assets/images/**', 'dist/images', { base: 'assets/images' })

;

mix.scripts('assets/scripts/infobox.js', 'dist/scripts/infobox.js');

glob.sync('blocks/**/block.scss').map( function( file ) {
	mix.sass(file, `blocks/${ path.basename(path.dirname(file)) }/styles/block.css`);
});

mix.copy('node_modules/@accessible360/accessible-slick/slick/fonts', 'dist/fonts')
.copy('node_modules/@accessible360/accessible-slick/slick/ajax-loader.gif', 'dist')

mix.sourceMaps(! mix.inProduction());
