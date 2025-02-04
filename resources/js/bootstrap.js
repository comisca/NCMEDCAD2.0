/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';

// import Livewire from '@livewire/livewire';  // Importa Livewire
// import Alpine from 'alpinejs';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    encrypted: false,
    cluster: 'mt1',
    enabledTransports: ['ws']
});
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     wsHost: import.meta.env.VITE_PUSHER_HOST || `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT || 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT || 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME || 'https') === 'https',
//     enabledTransports: ['ws', 'wss']
// });
// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     wsHost: import.meta.env.VITE_PUSHER_HOST || 'localhost',
//     wsPort: import.meta.env.VITE_PUSHER_PORT || 6001,
//     wssPort: import.meta.env.VITE_PUSHER_PORT || 6001,
//     forceTLS: false,
//     encrypted: false,
//     enabledTransports: ['ws'],
//     cluster: 'mt1',
//     disableStats: true,
//     auth: {
//         headers: {
//             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
//         }
//     }
// });

// Agregar manejo de errores
window.Echo.connector.pusher.connection.bind('error', (error) => {
    console.error('Error de conexión:', error);
});

window.Echo.connector.pusher.connection.bind('state_change', (states) => {
    console.log('Estado de conexión:', states);
});
// try {
//     window.Echo = new Echo({
//         broadcaster: 'reverb',
//         key: import.meta.env.VITE_REVERB_APP_KEY,
//         wsHost: window.location.hostname,
//         wsPort: 443,
//         wssPort: 443,
//         forceTLS: true,
//         encrypted: true,
//         disableStats: true,
//         enabledTransports: ['ws', 'wss'],
//         auth: {
//             headers: {
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
//             }
//         }
//     });
//
//     // Agregar manejador de errores
//     window.Echo.connector.pusher.connection.bind('error', function (error) {
//         console.error('Echo connection error:', error);
//     });
// } catch (error) {
//     console.error('Error initializing Echo:', error);
// }

// window.Echo = new Echo({
//     broadcaster: 'reverb',
//     key: import.meta.env.VITE_REVERB_APP_KEY,
//     wsHost: import.meta.env.VITE_REVERB_HOST,
//     wsPort: import.meta.env.VITE_REVERB_PORT,
//     forceTLS: false,
//     disableStats: true,
// });


//
// import Pusher from 'pusher-js';
//
// // window.Pusher = require('pusher-js');
//
// import Echo from 'laravel-echo';
//
// window.Echo = new Echo({
//     broadcaster: 'reverb',
//     key: import.meta.env.VITE_REVERB_APP_KEY,
//     wsHost: import.meta.env.VITE_REVERB_HOST,  // Debe ser "localhost" o "laravel.test"
//     wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
//     wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });


// // Inicializa Alpine.js
// window.Alpine = Alpine;
// Alpine.start();
//
// // Inicializa Livewire
// Livewire.start();
/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
