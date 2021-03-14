const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
const FontminPlugin = require('fontmin-webpack')

require('laravel-mix-bundle-analyzer');

mix
    .webpackConfig({
        plugins: [
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
    .extract([
        'vue',
        '@fortawesome',
        'vue-toasted',
        'axios',
        'in-viewport',
        'portal-vue',
    ])
    .extract(['v-tooltip'], 'tooltip')
    .webpackConfig({
        output: {
            chunkFilename: 'assets/js/[name].js?id=[chunkhash]',
        },
    })
    .version();

if (!mix.inProduction()) {
    mix.sourceMaps();
}

    mix.bundleAnalyzer();
