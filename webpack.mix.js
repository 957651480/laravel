const mix = require('laravel-mix');

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
/*mix.extract(['lodash'], 'js/lodash.js');
mix.extract(['axios'], 'js/axios.js');
mix.extract(['dayjs'], 'js/dayjs.js');
mix.extract(['popper.js', 'jquery'], 'js/jquery.js');
mix.extract(['bootstrap'], 'js/bootstrap.js');
mix.extract(['react'], 'js/react.js');
mix.extract(['react-dom'], 'js/react-dom.js');*/


mix.extract();

mix.js('resources/backend/main.js', 'public/js').react()
/*mix.css('node_modules/antd/dist/antd.css', 'public/css')*/
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ])
mix.webpackConfig(require('./webpack.config'));
if (mix.inProduction()) {
    mix.version();
} else {

    //mix.eslint();

    // Development settings
    mix
        .sourceMaps()
        .webpackConfig({
            devtool: 'eval-source-map', // Fastest for development
        });
}