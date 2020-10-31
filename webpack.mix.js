const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
const webpack = require('webpack');

mix
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
    .webpackConfig({
        plugins: [
            new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/),
        ]
    })
    .extract([
        '@fortawesome/fontawesome-svg-core',
        '@fortawesome/free-brands-svg-icons',
        '@fortawesome/free-regular-svg-icons',
        '@fortawesome/free-solid-svg-icons',
        '@fortawesome/vue-fontawesome',
        'axios',
        'portal-vue',
        'vanilla-lazyload',
        'vue',
        'vue-toasted',
    ])
    .version();

if (!mix.inProduction()) {
    mix.sourceMaps();
}
