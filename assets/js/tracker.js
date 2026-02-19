const ids = [
  "fasting", "taraweeh", "quran",
  "fajr", "dhuhr", "asr", "maghrib", "isha"
];

function activeMemberId() {
  return localStorage.getItem("rc_active_member_id") || "default";
}

function todayKey() {
  const d = new Date();
  const y = d.getFullYear();
  const m = String(d.getMonth() + 1).padStart(2, "0");
  const day = String(d.getDate()).padStart(2, "0");
  return `ramadan_tracker_${activeMemberId()}_${y}-${m}-${day}`;
}

function setLabel() {
  const d = new Date();
  document.getElementById("todayLabel").innerText =
    d.toDateString(); // simple readable label
}

function getStateFromUI() {
  const state = {};
  ids.forEach(id => state[id] = document.getElementById(id).checked);
  return state;
}

function applyStateToUI(state) {
  ids.forEach(id => {
    document.getElementById(id).checked = !!state[id];
  });
  updateProgress();
}

function saveState() {
  localStorage.setItem(todayKey(), JSON.stringify(getStateFromUI()));
}

function loadState() {
  const raw = localStorage.getItem(todayKey());
  if (!raw) return null;
  try { return JSON.parse(raw); } catch { return null; }
}

function clearState() {
  localStorage.removeItem(todayKey());
}

function updateProgress() {
  const state = getStateFromUI();
  const total = ids.length;
  const done = ids.filter(id => state[id]).length;
  const percent = Math.round((done / total) * 100);

  document.getElementById("progressText").innerText = `${percent}%`;
  document.getElementById("progressBar").style.width = `${percent}%`;
}

function showMsg(text) {
  const el = document.getElementById("msg");
  el.innerText = text;
  setTimeout(() => { el.innerText = ""; }, 2500);
}

// Live update progress
ids.forEach(id => {
  document.addEventListener("change", (e) => {
    if (e.target && e.target.id === id) updateProgress();
  });
});

// Buttons
document.getElementById("saveBtn").addEventListener("click", () => {
  saveState();
  showMsg("✅ Saved for today");
});

document.getElementById("resetBtn").addEventListener("click", () => {
  ids.forEach(id => document.getElementById(id).checked = false);
  clearState();
  updateProgress();
  showMsg("♻️ Reset done");
});

// Init
setLabel();
const saved = loadState();
if (saved) applyStateToUI(saved);
else updateProgress();
