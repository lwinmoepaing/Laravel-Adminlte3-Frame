window._ = require("lodash");

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require("popper.js").default;
    window.$ = window.jQuery = require("jquery");

    // For Adminlte3 Dependencies
    window.NProgress = require("nprogress");
    window.FastClick = require("fastclick");
    window.Chart = require("chart.js");
    window.skycons = require("skycons");
    window.Gauge = require("gaugeJS");
    window.moment = require("moment");
    // For Date Plugin for AdminLte3
    require("datejs");

    // Jquery Plugins
    require("icheck");
    require("flot");
    require("flot-pie");
    require("./adminlte3/jquery.flot.time");
    require("./adminlte3/jquery.flot.stack");
    require("./adminlte3/jquery.flot.resize");
    require("./adminlte3/jquery.flot.orderBars");
    require("./adminlte3/jquery.flot.spline");
    require("./adminlte3/jquery.flot.curvedlines");

    // Jquery Vmap
    require("jqvmap");

    // Jquery DateRange Picker
    require("daterangepicker");

    // Bootstrap v4.x.x
    require("bootstrap");
    require("bootstrap-progressbar/bootstrap-progressbar.min");

    // Need jquery DateTimeBootstrap4 Picker
    require("tempusdominus-bootstrap-4/build/js/tempusdominus-bootstrap-4.js");
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require("axios");

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });
