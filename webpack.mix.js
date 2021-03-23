const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.babelConfig({
    "plugins": [
        ["import", { libraryName: "antd", style: "css" }]
    ]
})
mix.extract();
mix.ts('resources/js/app.js', 'public/js').react()
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
        require('autoprefixer'),
    ])
    .webpackConfig(require('./webpack.config'));

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
