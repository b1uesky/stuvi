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
    mix.sass('textbook.scss', './public/build/css/textbook.css');
    mix.sass('admin.scss', './public/build/css/admin.css');
    mix.sass('express.scss', './public/build/css/express.css');

    mix.styles([
        '../../../public/libs/jquery-ui/themes/smoothness/jquery-ui.min.css',
        '../../../public/libs/bootstrap-select/dist/css/bootstrap-select.min.css',
        '../../../public/libs/sortable/css/sortable-theme-minimal.css',
        '../../../public/libs/zoom.js/css/zoom.css',
        '../../../public/libs/dropzone/dist/min/dropzone.min.css',
        '../../../public/libs/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
        '../../../public/build/css/textbook.css'
    ], 'public/build/css/textbook.css');

    mix.scripts([
        '../../../public/libs/html5shiv/dist/html5shiv.min.js',
        '../../../public/libs/respond/dest/respond.min.js',
        '../../../public/libs/jquery/dist/jquery.min.js',
        '../../../public/libs/jquery-ui/jquery-ui.min.js',
        '../../../public/libs/bootstrap/dist/js/bootstrap.min.js',
        '../../../public/libs/bootstrap-select/dist/js/bootstrap-select.min.js',
        '../../../public/libs/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js',
        '../../../public/libs/sortable/js/sortable.min.js',
        '../../../public/libs/zoom.js/js/zoom.js',
        '../../../public/libs-paid/formvalidation-dist-v0.6.3/dist/js/formValidation.min.js',
        '../../../public/libs-paid/formvalidation-dist-v0.6.3/dist/js/framework/bootstrap.min.js'
    ], 'public/build/js/textbook.js');
});
