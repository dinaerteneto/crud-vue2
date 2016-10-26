const elixir = require('laravel-elixir');

require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */
var paths = {
	  'slicklab': './resources/assets/slicklab',
    'select2': './node_modules/select2/dist'
}

elixir(mix => {
    mix.sass('app.scss')
       .webpack('app.js')
       .scripts([
       		paths.select2 + "/js/select2.min.js",
          paths.slicklab + "/js/modernizr.min.js",
          paths.slicklab + "/js/jquery.nicescroll.js",
          paths.slicklab + "/js/slidebars.min.js",
          paths.slicklab + "/js/switchery/switchery.min.js",
          paths.slicklab + "/js/switchery/switchery-init.js",
       	])
       .styles([
       		paths.select2 + "/css/select2.min.css",
       		paths.slicklab + "/css/style-responsive.css",
       		paths.slicklab + "/css/style.css",
       	])
        .copy('resources/assets/slicklab/js', 'public/js')
        .copy('resources/assets/slicklab/css', 'public/css')
       	.copy('resources/assets/slicklab/img', 'public/img')
        .copy('resources/assets/slicklab/fonts', 'public/fonts');
});
