let mix = require('laravel-mix');

mix.setPublicPath('dist')
    .sass('resources/page.scss', '')
    .js('resources/page.js', '');
