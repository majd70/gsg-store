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

mix.js('resources/js/app.js', 'public/js')//بتعمل كومبايل لملف الابب دوت جافاسكريبت الموجود ب مجلد الريسورس ومن ثم نسخهها ل فولدر الببلك بمجل\ الجافا سكريبت
    .postCss('resources/css/app.css', 'public/css', [ //نفس الي فوق بس لملفات السي اس اس
        //
    ]);
