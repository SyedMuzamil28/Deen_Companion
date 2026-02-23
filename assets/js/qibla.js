(function() {
  var KAABA_LAT = 21.4225;
  var KAABA_LNG = 39.8262;
  var HYDERABAD_LAT = 17.3850;
  var HYDERABAD_LNG = 78.4867;

  function toRad(x) { return x * Math.PI / 180; }
  function toDeg(x) { return x * 180 / Math.PI; }

  function bearing(fromLat, fromLon, toLat, toLon) {
    var dLon = toRad(toLon - fromLon);
    var y = Math.sin(dLon) * Math.cos(toRad(toLat));
    var x = Math.cos(toRad(fromLat)) * Math.sin(toRad(toLat)) - Math.sin(toRad(fromLat)) * Math.cos(toRad(toLat)) * Math.cos(dLon);
    var b = toDeg(Math.atan2(y, x));
    return (b + 360) % 360;
  }

  var needleEl = document.getElementById("qiblaNeedle");
  var degreesEl = document.getElementById("qiblaDegrees");
  var fallbackEl = document.getElementById("qiblaPermission");
  var degreesFallbackEl = document.getElementById("qiblaDegreesFallback");
  var compassWrap = document.getElementById("qiblaCompassWrap");

  var qiblaBearing = null;
  var userLat = HYDERABAD_LAT;
  var userLng = HYDERABAD_LNG;
  var compassHeading = 0;
  var useFallback = false;

  function setNeedle(deg) {
    if (!needleEl) return;
    needleEl.style.transform = "rotate(" + deg + "deg)";
    if (degreesEl) degreesEl.textContent = Math.round(deg) + "°";
  }

  function onOrientation(alpha) {
    if (qiblaBearing == null) return;
    compassHeading = alpha;
    var needleAngle = (qiblaBearing - alpha + 360) % 360;
    setNeedle(needleAngle);
  }

  function requestLocation() {
    if (!navigator.geolocation) {
      useFallback = true;
      qiblaBearing = bearing(HYDERABAD_LAT, HYDERABAD_LNG, KAABA_LAT, KAABA_LNG);
      setNeedle(0);
      if (fallbackEl) fallbackEl.classList.remove("hidden");
      if (degreesFallbackEl) degreesFallbackEl.textContent = Math.round(qiblaBearing) + "°";
      return;
    }
    navigator.geolocation.getCurrentPosition(
      function(pos) {
        userLat = pos.coords.latitude;
        userLng = pos.coords.longitude;
        qiblaBearing = bearing(userLat, userLng, KAABA_LAT, KAABA_LNG);
        if (typeof DeviceOrientationEvent !== "undefined" && DeviceOrientationEvent.requestPermission) {
          DeviceOrientationEvent.requestPermission().then(function(perm) {
            if (perm === "granted") startCompass();
            else { useFallback = true; showFallback(); }
          }).catch(function() { useFallback = true; showFallback(); });
        } else {
          startCompass();
        }
      },
      function() {
        useFallback = true;
        qiblaBearing = bearing(HYDERABAD_LAT, HYDERABAD_LNG, KAABA_LAT, KAABA_LNG);
        showFallback();
      },
      { enableHighAccuracy: true, timeout: 10000 }
    );
  }

  function showFallback() {
    if (fallbackEl) fallbackEl.classList.remove("hidden");
    if (degreesFallbackEl && qiblaBearing != null) degreesFallbackEl.textContent = Math.round(qiblaBearing) + "°";
    if (compassWrap) compassWrap.classList.add("hidden");
  }

  function startCompass() {
    if (window.DeviceOrientationEvent) {
      window.addEventListener("deviceorientation", function(e) {
        if (e.alpha != null) onOrientation(e.alpha);
      }, true);
    } else {
      useFallback = true;
      showFallback();
    }
  }

  requestLocation();
})();
