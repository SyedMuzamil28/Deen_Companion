let selectedRating = 0;

const stars = document.querySelectorAll("#stars span");
const note = document.getElementById("note");
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
  document.getElementById("dayLabel").innerText =
    "Reflection for " + new Date().toDateString();
}

stars.forEach(star => {
  star.addEventListener("click", () => {
    selectedRating = parseInt(star.dataset.val);
    updateStars();
  });
});

function updateStars() {
  stars.forEach((star, index) => {
    star.style.opacity = index < selectedRating ? "1" : "0.3";
  });
}

function saveReflection() {
  const data = {
    rating: selectedRating,
    note: note.value
  };
  localStorage.setItem(todayKey(), JSON.stringify(data));
  msg.innerText = "✅ Reflection saved";
  setTimeout(() => msg.innerText = "", 2000);
}

function loadReflection() {
  const raw = localStorage.getItem(todayKey());
  if (!raw) return;
  try {
    const data = JSON.parse(raw);
    selectedRating = data.rating || 0;
    note.value = data.note || "";
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
            ${escapeHtml(data.text || "")}
          </div>
        </div>
        <div class="text-yellow-400 text-lg">
          ${"★".repeat(data.rating || 0)}
        </div>
      </div>
    `;

    item.addEventListener("click", () => {
      textEl.value = data.text || "";
      rating = data.rating || 0;
      renderStars();
      msg.innerText = `Loaded reflection from ${date}`;
      setTimeout(() => msg.innerText = "", 2000);
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

