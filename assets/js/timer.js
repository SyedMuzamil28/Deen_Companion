document.addEventListener("DOMContentLoaded", () => {
    function getPrayerSettings() {
  return {
    method: localStorage.getItem("rc_calc_method") || "2",
    asr: localStorage.getItem("rc_asr_method") || "0"
  };
}

  const iftarEl = document.getElementById("iftarCountdown");
  const sehriEl = document.getElementById("sehriCountdown");
  const iftarTimeEl = document.getElementById("iftarTime");
  const sehriTimeEl = document.getElementById("sehriTime");
  const imsakTimeEl = document.getElementById("imsakTime");

  const nextNameEl = document.getElementById("nextPrayerName");
  const nextTimeEl = document.getElementById("nextPrayerTime");
  const nextCdEl = document.getElementById("nextPrayerCountdown");

  const locationHintEl = document.getElementById("locationHint");

  // If dashboard doesn't have these, stop silently
  if (!iftarEl || !sehriEl) return;

  let intervalId = null;

  function to12Hour(time24) {
    if (!time24) return "";
    // remove possible timezone suffix like "05:12 (IST)"
    const clean = String(time24).split(" ")[0];
    const [hh, mm] = clean.split(":");
    let h = parseInt(hh, 10);
    const ampm = h >= 12 ? "PM" : "AM";
    h = h % 12;
    h = h ? h : 12;
    return `${h}:${mm} ${ampm}`;
  }

  function parseTimeToDate(timeStr) {
    const clean = String(timeStr).split(" ")[0];
    const [h, m] = clean.split(":");
    const now = new Date();
    return new Date(now.getFullYear(), now.getMonth(), now.getDate(), parseInt(h, 10), parseInt(m, 10), 0);
  }

  function formatDiff(ms) {
    if (ms <= 0) return "00:00:00";
    const total = Math.floor(ms / 1000);
    const hh = String(Math.floor(total / 3600)).padStart(2, "0");
    const mm = String(Math.floor((total % 3600) / 60)).padStart(2, "0");
    const ss = String(total % 60).padStart(2, "0");
    return `${hh}:${mm}:${ss}`;
  }

  function getNextPrayer(timings) {
    const order = ["Fajr", "Dhuhr", "Asr", "Maghrib", "Isha"];

    const now = new Date();
    for (const key of order) {
      const t = parseTimeToDate(timings[key]);
      if (now < t) {
        return { name: key, time: t, raw: timings[key] };
      }
    }

    // If all passed, next is tomorrow Fajr
    const fajr = parseTimeToDate(timings.Fajr);
    fajr.setDate(fajr.getDate() + 1);
    return { name: "Fajr", time: fajr, raw: timings.Fajr };
  }

  function startTimers(timings, metaText) {
    // show fetched meta (city/timezone) if we have it
    if (locationHintEl && metaText) locationHintEl.innerText = metaText;

    // show exact times (so users can verify with Ramadan card)
    if (iftarTimeEl) iftarTimeEl.innerText = `Maghrib: ${to12Hour(timings.Maghrib)}`;
    if (sehriTimeEl) sehriTimeEl.innerText = `Fajr: ${to12Hour(timings.Fajr)}`;
    if (imsakTimeEl) imsakTimeEl.innerText = `Imsak: ${to12Hour(timings.Imsak)}`;

    if (intervalId) clearInterval(intervalId);

    function update() {
      const now = new Date();

      // IFTAR countdown (to today's Maghrib)
      const maghrib = parseTimeToDate(timings.Maghrib);
      const iftarDiff = maghrib - now;
      iftarEl.innerText = iftarDiff > 0 ? formatDiff(iftarDiff) : "Iftar passed";

      // SEHRI countdown (to next Fajr)
      let fajr = parseTimeToDate(timings.Fajr);
      if (now > fajr) fajr.setDate(fajr.getDate() + 1);
      const sehriDiff = fajr - now;
      sehriEl.innerText = formatDiff(sehriDiff);

      // NEXT PRAYER
      const next = getNextPrayer(timings);
      const nextDiff = next.time - now;

      if (nextNameEl) nextNameEl.innerText = next.name;
      if (nextTimeEl) nextTimeEl.innerText = to12Hour(next.raw);
      if (nextCdEl) nextCdEl.innerText = formatDiff(nextDiff);
    }

    update();
    intervalId = setInterval(update, 1000);
  }

  function fetchPrayerTimes(lat, lng) {
    const today = new Date();
    const day = today.getDate();
    const month = today.getMonth() + 1;
    const year = today.getFullYear();

    // method=2 (ISNA) — good default. We'll add method selector later to match local masjid cards.
    const s = getPrayerSettings();
const url =
  `https://api.aladhan.com/v1/timings/${day}-${month}-${year}` +
  `?latitude=${lat}&longitude=${lng}&method=${s.method}&school=${s.asr}`;

    fetch(url)
      .then(r => r.json())
      .then(data => {
        if (!data || data.code !== 200) {
          iftarEl.innerText = "Error";
          sehriEl.innerText = "Error";
          if (nextCdEl) nextCdEl.innerText = "Error";
          return;
        }

        const timings = data.data.timings;

        // Helpful trust text (timezone from API)
        const meta = data.data.meta;
        const metaText = meta
          ? `Location-based • TZ: ${meta.timezone} • Method: ${meta.method?.name || "Default"}`
          : "Location-based timings";

        startTimers(timings, metaText);
      })
      .catch(() => {
        iftarEl.innerText = "No location";
        sehriEl.innerText = "No location";
        if (nextCdEl) nextCdEl.innerText = "No location";
      });
  }

  // Hyderabad, India fallback when location denied or unavailable (Ramadan Lite)
  var FALLBACK_LAT = 17.3850;
  var FALLBACK_LNG = 78.4867;

  function useFallback() {
    if (locationHintEl) locationHintEl.innerText = "Using Hyderabad, India (allow location in Settings for your city).";
    fetchPrayerTimes(FALLBACK_LAT, FALLBACK_LNG);
  }

  if (!navigator.geolocation) {
    useFallback();
    return;
  }

  navigator.geolocation.getCurrentPosition(
    pos => fetchPrayerTimes(pos.coords.latitude, pos.coords.longitude),
    useFallback,
    { enableHighAccuracy: true, timeout: 10000 }
  );
});
