let selectedRating = 0;

const stars = document.querySelectorAll("#stars span");
const reflectionText = document.getElementById("reflectionText");
const msg = document.getElementById("msg");

function activeMemberId() {
  return localStorage.getItem("rc_active_member_id") || "default";
}

function todayKey() {
  const d = new Date();
  const date = d.toISOString().slice(0,10);
  return `ramadan_reflection_${activeMemberId()}_${date}`;
}

function setDayLabel() {
  var dayLabel = document.getElementById("dayLabel");
  if (dayLabel) dayLabel.innerText = "Reflection for " + new Date().toDateString();
}

stars.forEach(star => {
  star.addEventListener("click", () => {
    selectedRating = parseInt(star.dataset.star, 10);
    updateStars();
  });
});

function updateStars() {
  stars.forEach((star, index) => {
    star.style.opacity = index < selectedRating ? "1" : "0.3";
  });
}

function saveReflection() {
  const textEl = document.getElementById("reflectionText");
  const data = {
    rating: selectedRating,
    note: textEl ? textEl.value : "",
    text: textEl ? textEl.value : ""
  };
  localStorage.setItem(todayKey(), JSON.stringify(data));
  if (msg) msg.innerText = "✅ Reflection saved";
  setTimeout(() => { if (msg) msg.innerText = ""; }, 2000);
}

function loadReflection() {
  const textEl = document.getElementById("reflectionText");
  const raw = localStorage.getItem(todayKey());
  if (!raw) return;
  try {
    const data = JSON.parse(raw);
    selectedRating = data.rating || 0;
    if (textEl) textEl.value = data.note || data.text || "";
    updateStars();
  } catch {}
}

document.getElementById("saveReflection")
  .addEventListener("click", saveReflection);

// Init
setDayLabel();
loadReflection();
// ---- History ----
function loadHistory() {
  const list = document.getElementById("historyList");
  if (!list) return;

  const memberId = activeMemberId();
  const keys = Object.keys(localStorage)
    .filter(k => k.startsWith(`ramadan_reflection_${memberId}_`))
    .sort()
    .reverse();

  if (keys.length === 0) {
    list.innerHTML = `<p class="text-slate-400">No reflections yet.</p>`;
    return;
  }

  list.innerHTML = "";

  keys.forEach(key => {
    const date = key.split("_").pop();
    const data = JSON.parse(localStorage.getItem(key));

    const item = document.createElement("div");
    item.className = "bg-slate-900 rounded-xl p-4 cursor-pointer hover:bg-slate-800 transition";

    item.innerHTML = `
      <div class="flex items-center justify-between">
        <div>
          <div class="font-semibold">${date}</div>
          <div class="text-slate-400 truncate max-w-xs">
            ${escapeHtml(data.text || data.note || "")}
          </div>
        </div>
        <div class="text-yellow-400 text-lg">
          ${"★".repeat(data.rating || 0)}
        </div>
      </div>
    `;

    item.addEventListener("click", () => {
      var textEl = document.getElementById("reflectionText");
      if (textEl) textEl.value = data.text || data.note || "";
      selectedRating = data.rating || 0;
      updateStars();
      if (msg) msg.innerText = "Loaded reflection from " + date;
      setTimeout(() => { if (msg) msg.innerText = ""; }, 2000);
    });

    list.appendChild(item);
  });
}

// small helper
function escapeHtml(str) {
  return String(str).replace(/[&<>"']/g, s => ({
    "&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#039;"
  }[s]));
}

// Call history loader
loadHistory();

