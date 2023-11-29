import "flowbite";
import Alpine from "alpinejs";
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'cdedc2f3ecdd50cccf3a',
    cluster: 'us2',
    forceTLS: true
});

window._ = require("lodash");
window.axios = require("axios");
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
window.Alpine = Alpine;
Alpine.start();
