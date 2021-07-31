const mix = require('laravel-mix');
const exec = require('child_process').exec;
const glob = require('globby');
require('laravel-mix-bundle-analyzer');

// List here the common vendor modules that must be
// loaded in a separated chunk
const COMMON_VENDOR = [
    'popper.js',
    'bootstrap',
    'jquery',
    'i18next',
    'i18next-xhr-backend',
    'screenfull',
    'js-storage',
    'moment',
    'axios'
];

/**
 * Add support to use glob to compile multiple files at once
 * @param  pattern  glob pattern
 * @param  fn       callback for each file found
 */
const mixGlob = (pattern, fn) => glob.sync(pattern).forEach(fn);

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 */

mix.options({
    terser: {
        terserOptions: {
            mangle: {
                reserved: ['$super'] // rickshaw production fix
            }
        }
    }
});

mix.extend('insertCSSAt', (webpackConfig, position) => {
    const cssRegex = /\.css$/.toString();
    const cssRule = webpackConfig.module.rules.find(r => r.test.toString() === cssRegex);
    cssRule.loaders[0] = {
        loader: 'style-loader',
        options: {
            insertAt: position
        }
    };
});

// Set globals for external plugins
mix.autoload({
    jquery: ['$', 'window.jQuery', 'jQuery'],
    moment: ['window.moment', 'moment'],
    raphael: ['Raphael'] // required by morris.js
});

// Custom required webpack config
mix.webpackConfig(webpack => {
    return {
        module: {
            rules: [
                {
                    // Fix for flot resize
                    test: /jquery\.flot\.resize\.js$/,
                    use: ['imports-loader?this=>window']
                }
            ]
        }
    };
});

mix
    // App Scripts
    .js('resources/js/app.js', 'public/js')
    // Bootstrap Styles
    .sass('resources/sass/bootstrap.scss', 'public/css')
    // App Styles
    .sass('resources/sass/app.scss', 'public/css')
    // Themes
    .sass('resources/sass/themes/theme-a.scss', 'public/css')
    .sass('resources/sass/themes/theme-b.scss', 'public/css')
    .sass('resources/sass/themes/theme-c.scss', 'public/css')
    .sass('resources/sass/themes/theme-d.scss', 'public/css')
    .sass('resources/sass/themes/theme-e.scss', 'public/css')
    .sass('resources/sass/themes/theme-f.scss', 'public/css')
    .sass('resources/sass/themes/theme-g.scss', 'public/css')
    .sass('resources/sass/themes/theme-h.scss', 'public/css')
    // Vendor Styles
    .sass('resources/sass/vendor.scss', 'public/css')
    // Prepare RTL Styles for processing
    .copy('public/css/bootstrap.css', 'public/css/bootstrap-rtl.css')
    .copy('public/css/app.css', 'public/css/app-rtl.css')
    .extract(COMMON_VENDOR);

// Compile modules Javascript
// By doing this we can request modules separately on each page where it's used
// instead of bundling all files together within the app.js
mixGlob('resources/js/angle/modules/charts/*.js', (src, dst) => mix.js(src, 'public/js'));
mixGlob('resources/js/angle/modules/maps/*.js', (src, dst) => mix.js(src, 'public/js'));
mixGlob('resources/js/angle/modules/forms/*.js', (src, dst) => mix.js(src, 'public/js'));
mixGlob('resources/js/angle/modules/pages/*.js', (src, dst) => mix.js(src, 'public/js'));
mixGlob('resources/js/angle/modules/tables/*.js', (src, dst) => mix.js(src, 'public/js'));
mixGlob('resources/js/angle/modules/extras/*.js', (src, dst) => mix.js(src, 'public/js'));
mixGlob('resources/js/angle/modules/elements/*.js', (src, dst) => mix.js(src, 'public/js'));

// Generate RTL version of stylesheets
mix.then(() => {
    exec('npm run rtlcss -- public/css/app-rtl.css public/css/app-rtl.css');
    exec('npm run rtlcss -- public/css/bootstrap-rtl.css public/css/bootstrap-rtl.css');
});

// Insert importe CSS at the top
// node_modules styles doesn't override app styles
mix.insertCSSAt('top');

// Uncomment to trigger bundleAnalyzer
// if (mix.isWatching()) mix.bundleAnalyzer();

// https://laravel.com/docs/5.8/mix#versioning-and-cache-busting
if (mix.inProduction()) {
    mix.version();
}
