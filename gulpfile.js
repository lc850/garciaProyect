const elixir = require('laravel-elixir')
require('laravel-elixir-imagemin');

elixir(function(mix) {
    mix.styles([
        'AdminLTE.css',
        'bootstrap.min.css',
        '_all-skins.min.css',
        'sweetalert.min.css',
        'font-awesome.min.css',
        'ionicons.min.css'
    ]);
});

elixir(function(mix) {
    mix.scripts([
        'angular.min.js',
        'app/app.js',
        'bootstrap.min.js',
        'app.min.js',
        'jquery.slimscroll.min.js',
        'sweetalert.min.js',
        'jquery-ui.min.js'
    ]);
});

elixir(function(mix) {
 
    mix.imagemin({
        optimizationLevel: 3
    });
});