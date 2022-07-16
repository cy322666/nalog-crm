// import Echo from "laravel-echo";
// import Echo from "laravel-echo";

import("echo.js");

import("https://js.pusher.com/4.1/pusher.min.js");

console.log('ws');

// window.Pusher = import('pusher-js');



// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: '9qtxjw.iSf78w',
//     wsHost: 'realtime-pusher.ably.io',
//     wsPort: 443,
//     disableStats: true,
//     encrypted: true,
// });

Echo.private('tasks.17')
    .listen('TaskFailedPush', (e) => {
        alert(e.message.message);
    });
/*
// window.Echo.channel('tasks.17');
//
// .listen('tasks.17', (e) => {
//     console.log("event received")
//     console.log(e)
// })



// window.Echo.private(`tasks.${taskId}`)
//     .listen('TaskFailedPush', (e) => {
//         console.log(e.task);
//     });*/
