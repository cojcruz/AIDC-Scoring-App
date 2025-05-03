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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .js('resources/js/admin_app.js', 'public/js')
    .js('resources/js/categories_app.js', 'public/js')
    .js('resources/js/live_app.js', 'public/js')
    .js('resources/js/scoring_app.js','public/js')
    .js('resources/js/judgescoring_app.js','public/js');
 module.exports = {
    resolve: {
        extensions: ['*', '.js', '.vue', '.json']
    }
 }