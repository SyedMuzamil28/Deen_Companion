// --- Sample Duas (will move to DB later) ---
const DUAS = [
  {
    id: "sehri_1",
    category: "sehri",
    arabic: "وَبِصَوْمِ غَدٍ نَّوَيْتُ مِنْ شَهْرِ رَمَضَانَ",
    meaning: "I intend to keep the fast for tomorrow in the month of Ramadan."
  },
  {
    id: "iftar_1",
    category: "iftar",
    arabic: "اللَّهُمَّ إِنِّي لَكَ صُمْتُ وَبِكَ آمَنْتُ",
    meaning: "O Allah, I fasted for You and I believe in You."
  },
  {
    id: "general_1",
    category: "general",
    arabic: "رَبِّ زِدْنِي عِلْمًا",
    meaning: "My Lord, increase me in knowledge."
  }
];

// --- Helpers ---
function activeMemberId() {
  return localStorage.getItem("rc_active_member_id") || "default";
}

function favKey() {
  return `ramadan_dua_favs_${activeMemberId()}`;
}

function loadFavs() {
  const raw = localStorage.getItem(favKey());
  if (!raw) return [];
  try { return JSON.parse(raw); } catch { return []; }
}

function saveFavs(favs) {
  localStorage.setItem(favKey(), JSON.stringify(favs));
}

// --- Render ---
const listEl = document.getElementById("duaList");
let currentFilter = "all";

function render() {
  const favs = loadFavs();
  listEl.innerHTML = "";

  DUAS.filter(d => currentFilter === "all" || d.category === currentFilter)
      .forEach(d => {
        const isFav = favs.includes(d.id);

        const card = document.createElement("div");
        card.className = "bg-slate-800 rounded-2xl p-6 shadow";

        card.innerHTML = `
          <div class="flex items-start justify-between gap-4">
            <div>
              <div class="arabic text-xl font-semibold mb-2">${d.arabic}</div>
              <div class="text-slate-300 text-sm">${d.meaning}</div>
              <div class="mt-3 text-xs text-slate-400 uppercase">${d.category}</div>
            </div>
            <button class="favBtn text-2xl ${isFav ? "text-yellow-400" : "text-slate-500"}"
                    data-id="${d.id}">
              ★
            </button>
          </div>
        `;

        listEl.appendChild(card);
      });

  // Wire fav buttons
  document.querySelectorAll(".favBtn").forEach(btn => {
    btn.addEventListener("click", () => {
      const id = btn.dataset.id;
      let favs = loadFavs();
      favs = favs.includes(id) ? favs.filter(x => x !== id) : [...favs, id];
      saveFavs(favs);
      render();
    });
  });
}

// Filters
document.querySelectorAll(".filterBtn").forEach(btn => {
  btn.addEventListener("click", () => {
    currentFilter = btn.dataset.filter;
    document.querySelectorAll(".filterBtn").forEach(b => {
      b.classList.remove("bg-yellow-400","text-black");
      b.classList.add("bg-slate-800");
    });
    btn.classList.add("bg-yellow-400","text-black");
    render();
  });
});

// Init
render();
