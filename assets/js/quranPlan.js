const KEY_PLAN_START = "rc_quran_plan_start";   // ISO date
const KEY_DONE = "rc_quran_plan_done_days";     // JSON array of day numbers done (1..30)

const planCard = document.getElementById("planCard");
const bar = document.getElementById("progressBar");
const txt = document.getElementById("progressText");

function todayISO() {
  const d = new Date();
  const y = d.getFullYear();
  const m = String(d.getMonth() + 1).padStart(2, "0");
  const day = String(d.getDate()).padStart(2, "0");
  return `${y}-${m}-${day}`;
}

function getStartDate() {
  return localStorage.getItem(KEY_PLAN_START) || "";
}

function setStartDate(iso) {
  localStorage.setItem(KEY_PLAN_START, iso);
}

function loadDone() {
  const raw = localStorage.getItem(KEY_DONE);
  if (!raw) return [];
  try { return JSON.parse(raw); } catch { return []; }
}

function saveDone(arr) {
  localStorage.setItem(KEY_DONE, JSON.stringify(arr));
}

function daysBetween(startISO, endISO) {
  const s = new Date(startISO + "T00:00:00");
  const e = new Date(endISO + "T00:00:00");
  const diff = e - s;
  return Math.floor(diff / (1000 * 60 * 60 * 24));
}

function clamp(n, min, max) {
  return Math.max(min, Math.min(max, n));
}

function render() {
  // If start date not set, default to today (user can change later)
  let start = getStartDate();
  if (!start) {
    start = todayISO();
    setStartDate(start);
  }

  const today = todayISO();
  const dayIndex = daysBetween(start, today) + 1; // day 1..n
  const dayNo = clamp(dayIndex, 1, 30);
  const juzNo = dayNo; // Ramadan: Day 1 -> Juz 1, ..., Day 30 -> Juz 30

  let done = loadDone();
  const isDone = done.includes(dayNo);

  planCard.innerHTML = `
    <div class="flex items-start justify-between gap-4">
      <div>
        <div class="text-slate-300 text-sm mb-1">Today’s Target</div>
        <div class="text-3xl font-bold text-yellow-400">Juz ${juzNo}</div>
        <div class="text-slate-300 text-sm mt-2">
          Tip: Split into 2 sessions (after Fajr + after Asr/Maghrib) for consistency.
        </div>
        <div class="text-slate-500 text-xs mt-3">
          Plan start: <span class="text-slate-300">${start}</span>
        </div>
      </div>

      <div class="text-right">
        <button id="toggleDoneBtn"
          class="${isDone ? "bg-slate-700 text-white" : "bg-yellow-400 text-black"} font-semibold px-5 py-3 rounded-xl hover:opacity-90 transition">
          ${isDone ? "↩ Mark as Not Done" : "✅ Mark Done"}
        </button>

        <button id="changeStartBtn"
          class="mt-3 bg-slate-900 border border-slate-700 text-white font-semibold px-5 py-3 rounded-xl hover:opacity-90 transition">
          ✏ Change Start Date
        </button>
      </div>
    </div>
  `;

  document.getElementById("toggleDoneBtn").addEventListener("click", () => {
    let updated = loadDone();
    if (updated.includes(dayNo)) {
      updated = updated.filter(x => x !== dayNo);
    } else {
      updated.push(dayNo);
      updated = [...new Set(updated)].sort((a,b) => a-b);
    }
    saveDone(updated);
    render();
  });

  document.getElementById("changeStartBtn").addEventListener("click", () => {
    const newStart = prompt("Enter plan start date (YYYY-MM-DD):", start);
    if (!newStart) return;

    // basic validation
    if (!/^\d{4}-\d{2}-\d{2}$/.test(newStart)) {
      alert("Invalid format. Use YYYY-MM-DD");
      return;
    }

    setStartDate(newStart);
    render();
  });

  // Progress
  done = loadDone();
  const completed = done.length;
  const pct = Math.round((completed / 30) * 100);

  if (bar) bar.style.width = `${pct}%`;
  if (txt) txt.innerText = `${completed}/30 days completed`;
}

render();
