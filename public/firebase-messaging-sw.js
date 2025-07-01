// Import Firebase scripts
importScripts('https://www.gstatic.com/firebasejs/9.0.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.0.0/firebase-messaging-compat.js');

// Cache setup
const CACHE_NAME = 'offline-v1';
const TINYMCE_CACHE = 'tinymce-cache';
const filesToCache = [
    '/',
    '/login',
    '/offline.html',
    '/mahasiswa',
    '/admin'
];

// Firebase config
firebase.initializeApp({
    apiKey: "AIzaSyCL3nHwRTAm3jKBGHWHEg-i7qmRMqzF7os",
    authDomain: "newp-9d3b2.firebaseapp.com",
    projectId: "newp-9d3b2",
    storageBucket: "newp-9d3b2.appspot.com",
    messagingSenderId: "755855234479",
    appId: "1:755855234479:web:cadff0206a6ff07f354b5a"
});

const messaging = firebase.messaging();

// Install: cache static files
self.addEventListener('install', event => {
    event.waitUntil(
        (async () => {
            const cache = await caches.open(CACHE_NAME);
            try {
                await cache.addAll(filesToCache);
                console.log('[ServiceWorker] Cached static assets');
            } catch (error) {
                console.error('[ServiceWorker] Failed to cache:', error);
            }
        })()
    );
    self.skipWaiting();
});

// Activate: claim clients
self.addEventListener('activate', event => {
    event.waitUntil(self.clients.claim());
    console.log('[ServiceWorker] Activated');
});

// Fetch handler
self.addEventListener('fetch', event => {
    if (event.request.method !== 'GET') return;

    const requestUrl = event.request.url;

    // Handle TinyMCE CDN resources
    if (requestUrl.includes('cdn.tiny.cloud')) {
        event.respondWith(
            caches.match(event.request).then(cachedResponse => {
                if (cachedResponse) return cachedResponse;
                return fetch(event.request).then(networkResponse => {
                    return caches.open(TINYMCE_CACHE).then(cache => {
                        cache.put(event.request, networkResponse.clone());
                        return networkResponse;
                    });
                });
            })
        );
        return;
    }

    // General fetch: cache then network, with fallback to offline
    event.respondWith(
        fetch(event.request)
            .then(response => {
                if (response && response.status === 200) {
                    const resClone = response.clone();
                    caches.open(CACHE_NAME).then(cache => cache.put(event.request, resClone));
                    return response;
                } else {
                    throw new Error('Network response not OK');
                }
            })
            .catch(() => {
                return caches.match(event.request)
                    .then(cached => cached || caches.match('/offline.html'));
            })
    );
});

// Firebase background message handler
messaging.onBackgroundMessage(payload => {
    const { title, body, image } = payload.notification;
    const options = {
        body,
        icon: image || '/logo.png',
        data: payload.data
    };
    self.registration.showNotification(title, options);
});

// Push fallback (non-Firebase push)
self.addEventListener('push', event => {
    const data = event.data?.json() || {};
    self.registration.showNotification(data.title, {
        body: data.body,
        icon: data.icon || '/icon.png',
        data: { url: data.url }
    });
});

// Notification click handler
self.addEventListener('notificationclick', event => {
    event.notification.close();
    event.waitUntil(
        clients.openWindow(event.notification.data?.url || '/')
    );
});
