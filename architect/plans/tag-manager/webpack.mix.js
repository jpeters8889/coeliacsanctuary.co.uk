let mix = require('laravel-mix');

mix.setPublicPath('dist')
    .sass('resources/plan.scss', '')
    .js('resources/plan.js', '');
