const listEl = document.getElementById("surahList");

function escapeHtml(str) {
  return String(str).replace(/[&<>"']/g, s => ({
    "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;"
  }[s]));
}

fetch("https://api.alquran.cloud/v1/surah")
  .then(r => r.json())
  .then(data => {
    if (!data || data.code !== 200) {
      listEl.innerHTML = `<div class="text-slate-300">Failed to load Quran.</div>`;
      return;
    }

    const surahs = data.data;
    listEl.innerHTML = "";

    surahs.forEach(s => {
      const card = document.createElement("a");
      card.href = `surah.php?no=${s.number}`;
      card.className = "bg-slate-800 rounded-2xl p-5 shadow hover:bg-slate-700 transition block";

      card.innerHTML = `
        <div class="flex items-center justify-between gap-4">
          <div>
            <div class="text-yellow-400 font-bold text-lg">
              ${s.number}. ${escapeHtml(s.englishName)}
            </div>
            <div class="text-slate-300 text-sm">
              ${escapeHtml(s.englishNameTranslation)} • ${escapeHtml(s.revelationType)} • ${s.numberOfAyahs} ayahs
            </div>
          </div>
          <div class="arabic text-2xl">${escapeHtml(s.name)}</div>
        </div>
      `;

      listEl.appendChild(card);
    });
  })
  .catch(() => {
    listEl.innerHTML = `<div class="text-slate-300">Network error loading Quran.</div>`;
  });

  