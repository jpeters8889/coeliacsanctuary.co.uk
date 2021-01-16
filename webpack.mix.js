const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
const MomentLocalesPlugin = require('moment-locales-webpack-plugin');
const FontminPlugin = require('fontmin-webpack')

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
            chunkFilename: 'assets/js/[name].js',
        },
    })
    .version();

if (!mix.inProduction()) {
    mix.sourceMaps();
}

if (!mix.inProduction()) {
    // mix.bundleAnalyzer();
}
