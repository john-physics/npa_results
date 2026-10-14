/*
 * NPA Results service worker
 *
 * Bump CACHE_NAME on every deploy that changes cached files.
 */
const CACHE_NAME = 'npa-results-static-v3';
const CACHE_PREFIX = 'npa-results-';

/*
 * Pre-cached on install. Every file listed here MUST exist on the
 * server, otherwise cache.addAll() fails and the worker won't install.
 */
const STATIC_ASSETS = [
    '/npa-manifest.json',
    '/images/pwa-192.png',
    '/images/pwa-512.png'
];

/*
 * Only these paths may ever be cached (adjust to your real folders).
 * Everything else goes straight to the network, so private content
 * such as student photos, uploads or API responses is never stored.
 */
const CACHEABLE_PATHS = [
    '/css/',
    '/js/',
    '/scripts/',
    '/fonts/',
    '/images/'
];

/*
 * Never cached, even if they sit under a cacheable path.
 */
const NEVER_CACHE_PATHS = [
    '/api/',
    '/uploads/',
    '/images/uploads/',
  // '/images/students/'
];

const STATIC_TYPES = ['style', 'script', 'image', 'font'];


function isCacheable(url, request) {

    if (url.origin !== self.location.origin) {
        return false;
    }

    const path = url.pathname;

    if (NEVER_CACHE_PATHS.some(p => path.startsWith(p))) {
        return false;
    }

    if (path === '/npa-manifest.json') {
        return true;
    }

    return (
        STATIC_TYPES.includes(request.destination) &&
        CACHEABLE_PATHS.some(p => path.startsWith(p))
    );
}


/*
 * Serve from cache immediately, refresh the cache in the background.
 * Users get fast loads and pick up updated files on the next visit.
 */
async function staleWhileRevalidate(event) {

    const request = event.request;
    const cache = await caches.open(CACHE_NAME);
    const cached = await cache.match(request);

    const network = fetch(request)
        .then(response => {

            if (response.ok && response.type === 'basic') {
                cache.put(request, response.clone());
            }

            return response;
        })
        .catch(() => null);

    if (cached) {
        event.waitUntil(network);
        return cached;
    }

    const response = await network;

    return response || Response.error();
}


const OFFLINE_PAGE = `<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#E4CAD5">
    <title>NPA Results - Offline</title>
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
            text-align: center;
            background: #f5f5f5;
            color: #333;
        }
        .offline { max-width: 420px; padding: 30px; }
        .icon { font-size: 55px; margin-bottom: 15px; }
        h1 { margin-bottom: 10px; }
        p { line-height: 1.6; color: #666; }
        button {
            border: 0;
            padding: 12px 22px;
            border-radius: 8px;
            background: #8a1f45;
            color: #fff;
            font-size: 15px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="offline">
        <div class="icon">📡</div>
        <h1>You are offline</h1>
        <p>
            NPA Results could not connect to the server.
            Please check your Internet connection and try again.
        </p>
        <button onclick="location.reload()">Try Again</button>
    </div>
</body>
</html>`;


/*
 * Install
 */
self.addEventListener('install', event => {

    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(STATIC_ASSETS))
            .then(() => self.skipWaiting())
    );

});


/*
 * Activate: remove old NPA caches only
 */
self.addEventListener('activate', event => {

    event.waitUntil(
        caches.keys()
            .then(keys => Promise.all(
                keys
                    .filter(key =>
                        key.startsWith(CACHE_PREFIX) && key !== CACHE_NAME
                    )
                    .map(key => caches.delete(key))
            ))
            .then(() => self.clients.claim())
    );

});


/*
 * Fetch
 */
self.addEventListener('fetch', event => {

    const request = event.request;

    /*
     * Only GET requests are handled. POST, PUT, DELETE etc. always
     * go to the network untouched.
     */
    if (request.method !== 'GET') {
        return;
    }

    /*
     * Pages (PHP router output) are never cached.
     * Offline fallback only.
     */
    if (request.mode === 'navigate') {

        event.respondWith(
            fetch(request).catch(() =>
                new Response(OFFLINE_PAGE, {
                    status: 503,
                    headers: { 'Content-Type': 'text/html; charset=UTF-8' }
                })
            )
        );

        return;
    }

    /*
     * Partial (range) requests are not cacheable.
     */
    if (request.headers.has('range')) {
        return;
    }

    /*
     * Static assets on the allow-list only.
     * Anything else is left to the browser.
     */
    if (isCacheable(new URL(request.url), request)) {
        event.respondWith(staleWhileRevalidate(event));
    }

});
