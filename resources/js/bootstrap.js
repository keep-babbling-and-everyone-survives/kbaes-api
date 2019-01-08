
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from "laravel-echo"
window.io = require('socket.io-client');

// Have this in case you stop running your laravel echo server

if (typeof io !== 'undefined') {
  window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001',
    transports: ['websocket', 'polling', 'flashsocket'],
    auth: {
      headers: {
        Authorization: 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImIwMGYxOTc2MjI0Mjg1YzM2ZjAyZTFiMWJhMGI4YTUxMjI2MTNjZWE5YzBjM2IxM2ZlMGVjYmQ3MzdkZWVkNmNkZjc0MzdkYmZjZDUwMTRjIn0.eyJhdWQiOiIyIiwianRpIjoiYjAwZjE5NzYyMjQyODVjMzZmMDJlMWIxYmEwYjhhNTEyMjYxM2NlYTljMGMzYjEzZmUwZWNiZDczN2RlZWQ2Y2RmNzQzN2RiZmNkNTAxNGMiLCJpYXQiOjE1NDY5NDU5OTMsIm5iZiI6MTU0Njk0NTk5MywiZXhwIjoxNTc4NDgxOTkzLCJzdWIiOiIxIiwic2NvcGVzIjpbIioiXX0.JGHe8qMEzsMK2-y9lB-PmRtOWH5T2neFdh36ZnHdjLUufSsSWw-lUbQbSKyuYJJ59ItAVfkGklP83l7hy0IuvxhwgS65V90JrqF_BZtjVE6zYlRfls_yKSHOkGR07RNHYEuf-1YOcELZJsJqFL30bPGorvPuWeTWcMm37HDLGslbgiU1FLrMUptjId9poT0Ri_NKJ4VaB9p2amEgownU1nuFDmfFGtBaVtR7e6HM_o14cvAqfsOoxOjYqsUTDTfMmiUbq-QtUmt8C0nAwxoW0wMr9Yvk1EfH_qcz_psQHe1OA3wmwLVwIvgx573SvbVcF_JgnXa3w8UL4qo9F4ineGPSpvO3_7_wKHglq6l0mIh5oa4rDCuO626Vjv7lGnepJ7qnKSPFHq0SMucXT0tBr_yGJCt3XAtpPLQOxcV_dpkOlh9G9rvdeJqXQQEQkMQBtyV-Rh1hrDsAUW8WuDjnWifAilpHQzZb4Xscd-eFJ6vGeaxYGF9N1dnmwjqR1vHkRHRgWkE4X_xB90IZLDO0arIK0jQfVJIh7pOShn0W_dHuR2nzGM-ZLe7BRAxNCsS6GhqVEs01Y40MJL_9266f99tNq1RRe3OHNWAu1hApJFn4R67gXII4PcWIGFDDaPW2Uei81xqfymcW5gEyiMYRHWqbxuRK6swhprArfZ0VYac'
      }
    }
  });
}
