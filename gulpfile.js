var elixir = require('laravel-elixir');

elixir(function (mix) {

    /**
     * Copy required files from vendor directories to public
     */
    // mix
    // .copy(
    //     'node_modules/font-awesome/fonts',
    //     'public/build/fonts/font-awesome')
    // .copy(
    //     'node_modules/bootstrap-sass/assets/fonts/bootstrap',
    //     'public/build/fonts/bootstrap')
    // .copy(
    //     'node_modules/bootstrap-sass/assets/javascripts/bootstrap.min.js',
    //     'public/js/vendor/bootstrap');

    /**
     * Process frontend SCSS stylesheets
     * Combine pre-processed frontend CSS files
     */
    mix
        .sass([
                'frontend/app.scss'
            ],
            'resources/assets/css/frontend/app.css')
        .styles([
                'frontend/app.css'
            ],
            'public/css/frontend/app.css');

    /**
     * Process backend SCSS stylesheets
     * Combine pre-processed backend CSS files
     */
    mix
        .sass([
                'backend/app.scss'
            ],
            'resources/assets/css/backend/app.css')
        .styles([
                'backend/app.css'
            ],
            'public/css/backend/app.css');

    /**
     * Combine frontend scripts
     */
    mix.scripts([
            'frontend/app.js'
        ],
        'public/js/frontend/app.js');

    /**
     * Combine backend scripts
     */
    mix.scripts([
            'backend/app.js'
        ],
        'public/js/backend/app.js');

    /**
     * Apply version control
     */
    mix.version([
        "public/css/frontend/app.css",
        "public/js/frontend/app.js",
        "public/css/backend/app.css",
        "public/js/backend/app.js"]);
});
