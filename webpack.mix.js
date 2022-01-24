const mix = require("laravel-mix");

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

const PUB_JS_DIR = "public/js";
const PUB_CSS_DIR = "public/css";

const mixingJs = "resources/js/app.js";
const mixingScss = "resources/sass/app.scss";

mix
    .js(mixingJs, PUB_JS_DIR)
    .sass(mixingScss, PUB_CSS_DIR)
    .disableNotifications();
