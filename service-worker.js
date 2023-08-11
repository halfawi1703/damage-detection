const CACHE_NAME = 'my-pwa-cache-v1';
const urlsToCache = [
    '/',
    '/assets/fonts/font-awesome/css/all.min.css',
    '/assets/css/app.min.css',
    '/assets/css/globals.min.css',
    '/assets/css/main.min.css',
    '/assets/js/jquery.min.js',
    '/assets/js/simple.money.format.js',
    '/assets/js/app.min.js',
    '/assets/js/init.js',
    '/assets/js/select2.min.js',
    '/assets/js/jquery.dataTables.min.js',
    '/assets/js/dataTables.bootstrap4.min.js'

    // ...Tambahkan URL lain yang ingin di-cache
];

self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(urlsToCache))
    );
});

self.addEventListener('fetch', event => {
    event.respondWith(
        caches.match(event.request)
            .then(response => response || fetch(event.request))
    );
});
