var CACHE_NAME = "deen-ramadan-v1";
var ASSETS = [
  "index.php",
  "dashboard.php",
  "prayer.php",
  "qibla.php",
  "quran.php",
  "duas.php",
  "settings.php",
  "manifest.json",
  "assets/css/app.css",
  "assets/js/theme.js",
  "assets/js/timer.js",
  "assets/js/prayer.js",
  "assets/js/qibla.js",
  "assets/js/quran.js",
  "assets/js/duas.js",
  "assets/js/ramadan.js",
  "assets/js/prayerSettings.js",
  "assets/js/surah.js"
];

self.addEventListener("install", function(e) {
  e.waitUntil(
    caches.open(CACHE_NAME).then(function(cache) {
      return cache.addAll(ASSETS).catch(function() {});
    }).then(function() { return self.skipWaiting(); })
  );
});

self.addEventListener("activate", function(e) {
  e.waitUntil(
    caches.keys().then(function(keys) {
      return Promise.all(keys.map(function(k) {
        if (k !== CACHE_NAME) return caches.delete(k);
      }));
    }).then(function() { return self.clients.claim(); })
  );
});

self.addEventListener("fetch", function(e) {
  if (e.request.method !== "GET") return;
  e.respondWith(
    fetch(e.request)
      .then(function(res) {
        var clone = res.clone();
        caches.open(CACHE_NAME).then(function(cache) { cache.put(e.request, clone); }).catch(function() {});
        return res;
      })
      .catch(function() { return caches.match(e.request); })
  );
});
