const KEY_METHOD = "rc_calc_method";
const KEY_ASR = "rc_asr_method";

function loadPrayerSettings() {
  return {
    method: localStorage.getItem(KEY_METHOD) || "2", // default ISNA
    asr: localStorage.getItem(KEY_ASR) || "0"        // default Shafi
  };
}

function savePrayerSettings(method, asr) {
  localStorage.setItem(KEY_METHOD, String(method));
  localStorage.setItem(KEY_ASR, String(asr));
}

document.addEventListener("DOMContentLoaded", () => {
  const methodEl = document.getElementById("calcMethod");
  const asrEl = document.getElementById("asrMethod");
  const btn = document.getElementById("savePrayerSettings");
  const msg = document.getElementById("settingsMsg");

  if (!methodEl || !asrEl || !btn) return;

  const current = loadPrayerSettings();
  methodEl.value = current.method;
  asrEl.value = current.asr;

  btn.addEventListener("click", () => {
    savePrayerSettings(methodEl.value, asrEl.value);
    if (msg) msg.innerText = "✅ Saved. Go to Prayer/Dashboard and refresh.";
    setTimeout(() => { if (msg) msg.innerText = ""; }, 3000);
  });
});
