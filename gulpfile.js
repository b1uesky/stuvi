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
    mix.sass('textbook.scss', './public/css/textbook.css');
    mix.sass('admin.scss', './public/css/admin.css');
    mix.sass('express.scss', './public/css/express.css');

    mix.styles([
        '../../../public/libs/jquery-ui/themes/smoothness/jquery-ui.min.css',
        '../../../public/libs/bootstrap-select/dist/css/bootstrap-select.min.css',
        '../../../public/libs/sortable/css/sortable-theme-minimal.css',
        '../../../public/libs/zoom.js/css/zoom.css',
        '../../../public/libs/dropzone/dist/min/dropzone.min.css',
        '../../../public/libs/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
        '../../../public/css/textbook.css'
    ], 'public/css/textbook.css');
});
