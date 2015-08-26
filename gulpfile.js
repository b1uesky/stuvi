var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Less
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function (mix) {
    mix.sass('main.scss', './public/css/main.css');

    mix.styles([
        '../libs/bootstrap/dist/css/bootstrap.min.css',
        '../libs/jquery-ui/themes/smoothness/jquery-ui.min.css',
        '../libs-paid/formvalidation-dist-v0.6.3/dist/css/formValidation.min.css',
        '../../../public/css/main.css'
    ], 'public/css/main.css');
});
