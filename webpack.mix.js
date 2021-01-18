const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
const MomentLocalesPlugin = require('moment-locales-webpack-plugin');
const FontminPlugin = require('fontmin-webpack')

require('laravel-mix-criticalcss');
require('laravel-mix-bundle-analyzer');

mix
    .webpackConfig({
        plugins: [
            new MomentLocalesPlugin(),
            new FontminPlugin({
                autodetect: true,
            }),
        ]
    })
    .sass('resources/scss/coeliac.scss', 'public/assets/css')
    .js('resources/js/coeliac.js', 'public/assets/js')
    .vue()
    .options({
        processCssUrls: false,
        postCss: [tailwindcss('tailwind.config.js')],
        uglify: {
            comments: false,
        }
    })
    .extract()
    .webpackConfig({
        output: {
            chunkFilename: 'assets/js/[name].js?id=[chunkhash]',
        },
    })
    .criticalCss({
        enabled: true,
        paths: {
            base: 'http://coeliac.test/',
            templates: './public/assets/css/',
            suffix: '_critical'
        },
        urls: [
            { url: '', template: 'home' },
        ],
        options: {
            minify: mix.inProduction(),
        },
    })
    .version();

if (!mix.inProduction()) {
    mix.sourceMaps();
}

if (mix.inProduction()) {
    mix.bundleAnalyzer();
}
