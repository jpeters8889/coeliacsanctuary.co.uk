let mix = require('laravel-mix');

mix.setPublicPath('dist')
    .sass('resources/card.scss', '')
    .js('resources/card.js', '');
