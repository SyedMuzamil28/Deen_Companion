const statusEl = document.getElementById("locationStatus");
const cardsEl = document.getElementById("prayerCards");

let countdownInterval = null;
function getPrayerSettings() {
  return {
    method: localStorage.getItem("rc_calc_method") || "2",
    asr: localStorage.getItem("rc_asr_method") || "0"
  };
}


// ----------------------
// Convert 24h → 12h
// ----------------------
function to12Hour(time24) {
  if (!time24) return "";

  const parts = time24.split(":");
  let hours = parseInt(parts[0]);
  const minutes = parts[1];

  const ampm = hours >= 12 ? "PM" : "AM";
  hours = hours % 12;
  hours = hours ? hours : 12;

  return `${hours}:${minutes} ${ampm}`;
}

// ----------------------
// Convert time string to Date
// ----------------------
function parseTimeToDate(timeStr) {
  const [hourStr, minuteStr] = timeStr.split(":");
  const now = new Date();

  return new Date(
    now.getFullYear(),
    now.getMonth(),
    now.getDate(),
    parseInt(hourStr),
    parseInt(minuteStr),
    0
  );
}

// ----------------------
// Countdown Logic
// ----------------------
function startCountdown(timings) {
  const countdownEl = document.getElementById("countdownBox");
  if (!countdownEl) return;

  if (countdownInterval) {
    clearInterval(countdownInterval);
  }

  function update() {
    const now = new Date();
    let maghrib = parseTimeToDate(timings.Maghrib);
    let fajr = parseTimeToDate(timings.Fajr);

    // If Fajr already passed today, set it for next day
    if (now > fajr) {
      fajr.setDate(fajr.getDate() + 1);
    }

    let target;
    let label;

    if (now < maghrib) {
      target = maghrib;
      label = "⏳ Time left for Iftar";
    } else {
      target = fajr;
      label = "⏳ Time left for Fajr";
    }

    const diff = target - now;

    if (diff <= 0) {
      countdownEl.innerText = "It's time!";
      return;
    }

    const hours = Math.floor(diff / (1000 * 60 * 60));
    const minutes = Math.floor((diff / (1000 * 60)) % 60);
    const seconds = Math.floor((diff / 1000) % 60);

    countdownEl.innerText =
      `${label}: ${hours}h ${minutes}m ${seconds}s`;
  }

  update();
  countdownInterval = setInterval(update, 1000);
}

// ----------------------
// Render Prayer Cards
// ----------------------
function renderCards(times) {
  const names = [
    { key: "Imsak", label: "Sehri Ends (Imsak)" },
    { key: "Fajr", label: "Fajr" },
    { key: "Dhuhr", label: "Dhuhr" },
    { key: "Asr", label: "Asr" },
    { key: "Maghrib", label: "Maghrib (Iftar)" },
    { key: "Isha", label: "Isha" }
  ];

  cardsEl.innerHTML = "";

  names.forEach(p => {
    const time = to12Hour(times[p.key]);
    if (!time) return;

    const card = document.createElement("div");
    card.className = "bg-slate-800 rounded-2xl p-5 shadow";

    card.innerHTML = `
      <div class="text-slate-400 text-sm mb-2">${p.label}</div>
      <div class="text-2xl font-bold text-yellow-400">${time}</div>
    `;

    cardsEl.appendChild(card);
  });
}

// ----------------------
// Fetch Prayer Times
// ----------------------
function fetchPrayerTimes(lat, lng) {
  const today = new Date();
  const day = today.getDate();
  const month = today.getMonth() + 1;
  const year = today.getFullYear();

  const s = getPrayerSettings();
const url = `https://api.aladhan.com/v1/timings/${day}-${month}-${year}?latitude=${lat}&longitude=${lng}&method=${s.method}&school=${s.asr}`;

  fetch(url)
    .then(res => res.json())
    .then(data => {
      if (data.code !== 200) {
        statusEl.innerText = "Failed to fetch prayer times.";
        return;
      }

      const timings = data.data.timings;

      statusEl.innerText = "Location detected successfully.";
      renderCards(timings);

      // ✅ START COUNTDOWN (You forgot this before)
      startCountdown(timings);
    })
    .catch(() => {
      statusEl.innerText = "Error fetching prayer times.";
    });
}

// Hyderabad, India fallback when location denied or unavailable (Ramadan Lite)
var FALLBACK_LAT = 17.3850;
var FALLBACK_LNG = 78.4867;

function initLocation() {
  function useFallback() {
    if (statusEl) statusEl.innerText = "Using Hyderabad, India. Allow location for your city.";
    fetchPrayerTimes(FALLBACK_LAT, FALLBACK_LNG);
  }

  if (!navigator.geolocation) {
    useFallback();
    return;
  }

  navigator.geolocation.getCurrentPosition(
    function (position) {
      var lat = position.coords.latitude;
      var lng = position.coords.longitude;
      fetchPrayerTimes(lat, lng);
    },
    useFallback,
    { enableHighAccuracy: true, timeout: 10000 }
  );
}

initLocation();
