(function() {
  var listEl = document.getElementById("surahList");
  var loadingEl = document.getElementById("surahLoading");
  var errorEl = document.getElementById("surahError");
  var searchEl = document.getElementById("surahSearch");
  var allSurahs = [];

  function escapeHtml(str) {
    return String(str).replace(/[&<>"']/g, function(s) {
      return { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[s];
    });
  }

  function render(list) {
    if (!listEl) return;
    listEl.innerHTML = "";
    list.forEach(function(s) {
      var card = document.createElement("a");
      card.href = "surah.php?no=" + s.number;
      card.className = "card p-5 block transition hover:opacity-90";
      card.style.background = "var(--bg-card)";
      card.style.borderColor = "var(--border)";
      card.innerHTML =
        '<div class="flex items-center justify-between gap-4">' +
          '<div class="min-w-0 flex-1">' +
            '<div class="font-bold text-lg truncate" style="color:var(--accent);">' + s.number + ". " + escapeHtml(s.englishName) + "</div>" +
            '<div class="text-sm truncate" style="color:var(--text-muted);">' + escapeHtml(s.englishNameTranslation) + " · " + s.numberOfAyahs + " ayahs</div>" +
          "</div>" +
          '<div class="arabic text-2xl flex-shrink-0">' + escapeHtml(s.name) + "</div>" +
        "</div>";
      listEl.appendChild(card);
    });
  }

  function filter() {
    var q = (searchEl && searchEl.value || "").trim().toLowerCase();
    var list = !q ? allSurahs : allSurahs.filter(function(s) {
      return s.englishName.toLowerCase().indexOf(q) !== -1 ||
             (s.englishNameTranslation && s.englishNameTranslation.toLowerCase().indexOf(q) !== -1) ||
             String(s.number) === q;
    });
    render(list);
  }

  fetch("https://api.alquran.cloud/v1/surah")
    .then(function(r) { return r.json(); })
    .then(function(data) {
      if (loadingEl) loadingEl.classList.add("hidden");
      if (!data || data.code !== 200) {
        if (errorEl) errorEl.classList.remove("hidden");
        return;
      }
      allSurahs = data.data || [];
      if (listEl) listEl.classList.remove("hidden");
      render(allSurahs);
      if (searchEl) searchEl.addEventListener("input", filter);
    })
    .catch(function() {
      if (loadingEl) loadingEl.classList.add("hidden");
      if (errorEl) errorEl.classList.remove("hidden");
    });
})();
