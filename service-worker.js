const CACHE_NAME = "dc-cache-v5";


const ASSETS = [
  "/",
  "/index.php",
  "/assets/js/timer.js",
  "/assets/js/tracker.js",
  "/assets/js/duas.js",
  "/assets/js/quran.js",
  "/assets/js/surah.js"
];

self.addEventListener("install", (event) => {
  event.waitUntil(
    caches.open(CACHE_NAME).then((cache) => cache.addAll(ASSETS)).catch(() => {})
  );
  self.skipWaiting();
});

self.addEventListener("activate", (event) => {
  event.waitUntil(self.clients.claim());
});

self.addEventListener("fetch", (event) => {
  // Network-first for PHP pages (so updates show)
  event.respondWith(
    fetch(event.request)
      .then((res) => {
        const copy = res.clone();
        caches.open(CACHE_NAME).then((cache) => cache.put(event.request, copy)).catch(() => {});
        return res;
      })
      .catch(() => caches.match(event.request))
  );
});
