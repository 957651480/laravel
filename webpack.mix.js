const mix = require('laravel-mix');



mix.webpackConfig({
    resolve: {
        alias: {
            'BE': path.resolve(__dirname, 'resources/backend'),
        },
    },
})
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/backend/admin.js', 'public/backend/js');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
