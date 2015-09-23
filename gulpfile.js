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
    // fonts
    mix.copy('resources/assets/libs/bootstrap/fonts', 'public/build/fonts');

    // textbook
    mix.sass('textbook.scss', './public/build/css/textbook.css');

    mix.styles([
        '../libs/jquery-ui/themes/smoothness/jquery-ui.min.css',
        '../libs/bootstrap-select/dist/css/bootstrap-select.min.css',
        '../libs/sortable/css/sortable-theme-minimal.css',
        '../libs/zoom.js/css/zoom.css',
        '../libs/dropzone/dist/min/dropzone.min.css',
        '../libs/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
        '../../../public/build/css/textbook.css'
    ], 'public/build/css/textbook.css');

    mix.scriptsIn('resources/assets/js', 'public/build/js/textbook.js');

    mix.scripts([
        '../libs/html5shiv/dist/html5shiv.min.js',
        '../libs/respond/dest/respond.min.js',
        '../libs/jquery/dist/jquery.min.js',
        '../libs/jquery-ui/jquery-ui.min.js',
        '../libs/bootstrap/dist/js/bootstrap.min.js',
        '../libs/bootstrap-select/dist/js/bootstrap-select.min.js',
        '../libs/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js',
        '../libs/sortable/js/sortable.min.js',
        '../libs/zoom.js/js/zoom.js',
        '../libs/moment/min/moment.min.js',
        '../libs/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
        '../libs/dropzone/dist/min/dropzone.min.js',
        '../libs-paid/formvalidation-dist-v0.6.3/dist/js/formValidation.min.js',
        '../libs-paid/formvalidation-dist-v0.6.3/dist/js/framework/bootstrap.min.js',
        '../../../public/build/js/textbook.js'
    ], 'public/build/js/textbook.js');



    // admin
    mix.sass('admin.scss', './public/build/css/admin.css');

    // express
    mix.sass('express.scss', './public/build/css/express.css');
});
