var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Additional elixir tasks & modules
 |--------------------------------------------------------------------------
 */
require('laravel-elixir-remove');

/*
 |--------------------------------------------------------------------------
 | The build process
 |--------------------------------------------------------------------------
 */
elixir(function (mix) {

    /*
     |--------------------------------------------------------------------------
     | Enable some nice stuff
     |--------------------------------------------------------------------------
     |
     | Set browserSync.proxy to your local dev domain name
     */
    mix.browserSync({
        proxy: 'laralabs.dev'
    });

    /*
     |--------------------------------------------------------------------------
     | Copy required files from vendor directories to public
     |--------------------------------------------------------------------------
     */
    // mix
    // .copy(
    //     'bower_components/font-awesome/fonts',
    //     'public/build/fonts/font-awesome')
    // .copy(
    //     'bower_components/bootstrap-sass/assets/javascripts/bootstrap.min.js',
    //     'public/js/vendor/bootstrap')
    //     .copy(
    //         'bower_components/bootstrap-sass/assets/fonts/bootstrap',
    //         'public/build/fonts/bootstrap');

    /*
     |--------------------------------------------------------------------------
     | Frontend assets
     |--------------------------------------------------------------------------
     |
     | Based on Bootstrap + Bootswatch skin
     |
     | 1. Process SCSS stylesheets
     | 2. Combine pre-processed CSS files
     | 3. Combine pre-processed JS files
     */
    mix
        .sass([
                'frontend/app.scss'
            ],
            'resources/assets/css/tmp/frontend/app-sass.css')
        .styles([
                'tmp/frontend/app-sass.css'
            ],
            'public/assets/css/frontend/app.css')
        .scripts([
                // Bootstrap
                '../../../bower_components/bootstrap-sass/assets/javascripts/bootstrap/affix.js',
                '../../../bower_components/bootstrap-sass/assets/javascripts/bootstrap/alert.js',
                '../../../bower_components/bootstrap-sass/assets/javascripts/bootstrap/button.js',
                '../../../bower_components/bootstrap-sass/assets/javascripts/bootstrap/carousel.js',
                '../../../bower_components/bootstrap-sass/assets/javascripts/bootstrap/collapse.js',
                '../../../bower_components/bootstrap-sass/assets/javascripts/bootstrap/dropdown.js',
                '../../../bower_components/bootstrap-sass/assets/javascripts/bootstrap/modal.js',
                '../../../bower_components/bootstrap-sass/assets/javascripts/bootstrap/popover.js',
                '../../../bower_components/bootstrap-sass/assets/javascripts/bootstrap/scrollspy.js',
                '../../../bower_components/bootstrap-sass/assets/javascripts/bootstrap/tab.js',
                '../../../bower_components/bootstrap-sass/assets/javascripts/bootstrap/tooltip.js',
                '../../../bower_components/bootstrap-sass/assets/javascripts/bootstrap/transition.js',

                // App
                'frontend/app.js'
            ],
            'public/assets/js/frontend/app.js');

    /*
     |--------------------------------------------------------------------------
     | Backend assets
     |--------------------------------------------------------------------------
     |
     | Based on Bootstrap + AdminLTE
     |
     | 1. Process SCSS stylesheets
     | 2. Combine pre-processed CSS files
     | 3. Combine pre-processed JS files
     */
    mix
        .sass([
                'backend/app.scss'
            ],
            'resources/assets/css/tmp/backend/app-sass.css')
        .styles([
                // Admin LTE + bundled Bootstrap
                '../../../bower_components/admin-lte/bootstrap',
                '../../../bower_components/admin-lte/dist/css/AdminLTE.css',
                '../../../bower_components/admin-lte/dist/css/skins/skin-black-light.css',

                // App
                'tmp/backend/app-sass.css'
            ],
            'public/assets/css/backend/app.css')
        .scripts([
                // Admin LTE + bundled Bootstrap

                // App
                'backend/app.js'
            ],
            'public/assets/js/backend/app.js');

    /*
     |--------------------------------------------------------------------------
     | Apply version control to prevent cache problems
     |--------------------------------------------------------------------------
     */
    mix.version([
        // Frontend
        "assets/css/frontend/app.css",
        "assets/js/frontend/app.js",

        // Backend
        "assets/css/backend/app.css",
        "assets/js/backend/app.js"]);

    /*
     |--------------------------------------------------------------------------
     | Clean-up temporary files
     |--------------------------------------------------------------------------
     */
    mix.remove([
        'resources/assets/css/tmp',
        'public/assets/css',
        'public/assets/js'])
});
