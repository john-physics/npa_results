const CACHE_NAME = 'npa-results-static-v2';

const STATIC_ASSETS = [
    '/manifest.json',
    '/images/pwa-192.png',
    '/images/pwa-512.png'
];


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
 * Activate
 */
self.addEventListener('activate', event => {

    event.waitUntil(

        caches.keys().then(keys => {

            return Promise.all(

                keys
                    .filter(key => key !== CACHE_NAME)
                    .map(key => caches.delete(key))

            );

        }).then(() => self.clients.claim())

    );

});


/*
 * Fetch
 */
self.addEventListener('fetch', event => {

    const request = event.request;

    /*
     * Only handle GET requests.
     *
     * POST, PUT, DELETE, etc. are NEVER cached.
     */
    if (request.method !== 'GET') {
        return;
    }


    /*
     * Page/navigation requests
     *
     * Your application uses a PHP router, so:
     *
     * /results
     * /student
     * /dashboard
     * /admin/exams
     *
     * may all execute PHP internally.
     *
     * Therefore we NEVER cache documents.
     */
    if (request.mode === 'navigate') {

        event.respondWith(

            fetch(request)
                .catch(() => {

                    return new Response(
                        `
                        <!DOCTYPE html>
                        <html lang="en">
                        <head>
                            <meta charset="UTF-8">
                            <meta name="viewport"
                                  content="width=device-width, initial-scale=1.0">
                            <meta name="theme-color"
                        content="#E4CAD5">
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

                                .offline {
                       max-width: 420px;
                          padding: 30px;
                                }

                                .icon {
                          font-size: 55px;
                         margin-bottom: 15px;
                                }

                                h1 {
                      margin-bottom: 10px;
                                }

                                p {
                          line-height: 1.6;
                         color: #666;
                                }

                                button {
                             border: 0;
                        padding: 12px 22px;
                        border-radius: 8px;
                                    background: #8a1f45;
                        color: white;
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
                                    NPA Results could not connect to the
                                    server. Please check your Internet
                                    connection and try again.
                                </p>

                                <button onclick="location.reload()">
                                    Try Again
                                </button>

                            </div>

                        </body>
                        </html>
                        `,
                        {
                            status: 503,
                            headers: {
                    'Content-Type': 'text/html; charset=UTF-8'
                            }
                        }
                    );

                })

        );

        return;
    }


    /*
     * Static assets
     *
     * Cache CSS, JavaScript, images, fonts, icons, etc.
     */
    const destination = request.destination;

    const staticTypes = [
        'style',
        'script',
        'image',
        'font'
    ];


    if (
        staticTypes.includes(destination) ||
        new URL(request.url).pathname === '/manifest.json'
    ) {

        event.respondWith(

            caches.match(request)
                .then(cachedResponse => {

                    if (cachedResponse) {
                        return cachedResponse;
                    }

                    return fetch(request)
                        .then(response => {

                            /*
                             * Only cache successful responses.
                             */
                            if (
                                response &&
                                response.ok &&
                                response.type === 'basic'
                            ) {

                                const responseClone =
                                    response.clone();

                                caches.open(CACHE_NAME)
                                    .then(cache => {
                                        cache.put(
                                            request,
                                            responseClone
                                        );
                                    });

                            }

                        return response;

                        });

                })

        );

    }

});