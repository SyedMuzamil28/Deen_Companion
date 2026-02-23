(function() {
  var DUAS = [
    { id: "sehri_1", category: "sehri", section: "Sehri", arabic: "وَبِصَوْمِ غَدٍ نَّوَيْتُ مِنْ شَهْرِ رَمَضَانَ", meaning: "I intend to keep the fast for tomorrow in the month of Ramadan." },
    { id: "sehri_2", category: "sehri", section: "Sehri", arabic: "نَوَيْتُ أَنْ أَصُومَ غَداً عَنْ أَدَاءِ فَرْضِ شَهْرِ رَمَضَانَ هَذِهِ السَّنَةِ", meaning: "I intend to observe the fast of Ramadan tomorrow this year." },
    { id: "iftar_1", category: "iftar", section: "Iftar", arabic: "اللَّهُمَّ إِنِّي لَكَ صُمْتُ وَبِكَ آمَنْتُ وَعَلَيْكَ تَوَكَّلْتُ وَعَلَى رِزْقِكَ أَفْطَرْتُ", meaning: "O Allah, I fasted for You, I believe in You, I put my trust in You and I break my fast with Your provision." },
    { id: "iftar_2", category: "iftar", section: "Iftar", arabic: "ذَهَبَ الظَّمَأُ وَابْتَلَّتِ الْعُرُوقُ وَثَبَتَ الْأَجْرُ إِنْ شَاءَ اللَّهُ", meaning: "Thirst is gone, the veins are moistened and the reward is confirmed, if Allah wills." },
    { id: "general_1", category: "general", section: "General", arabic: "رَبِّ زِدْنِي عِلْمًا", meaning: "My Lord, increase me in knowledge." },
    { id: "general_2", category: "general", section: "General", arabic: "رَبَّنَا آتِنَا فِي الدُّنْيَا حَسَنَةً وَفِي الْآخِرَةِ حَسَنَةً وَقِنَا عَذَابَ النَّارِ", meaning: "Our Lord, give us good in this world and good in the Hereafter, and protect us from the punishment of the Fire." }
  ];

  var KEY_FAV = "deen_dua_favs";
  function loadFavs() {
    try { return JSON.parse(localStorage.getItem(KEY_FAV) || "[]"); } catch (e) { return []; }
  }
  function saveFavs(arr) { localStorage.setItem(KEY_FAV, JSON.stringify(arr)); }

  var listEl = document.getElementById("duaList");
  var currentFilter = "all";

  function escapeHtml(str) {
    return String(str).replace(/[&<>"']/g, function(s) { return { "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;" }[s]; });
  }

  function render() {
    if (!listEl) return;
    var favs = loadFavs();
    var list = currentFilter === "all" ? DUAS : DUAS.filter(function(d) { return d.category === currentFilter; });
    listEl.innerHTML = "";
    list.forEach(function(d) {
      var isFav = favs.indexOf(d.id) !== -1;
      var card = document.createElement("div");
      card.className = "card p-5";
      card.style.background = "var(--bg-card)";
      card.style.borderColor = "var(--border)";
      card.innerHTML =
        '<div class="flex items-start justify-between gap-3">' +
          '<div class="flex-1 min-w-0">' +
            '<span class="text-xs font-medium uppercase" style="color:var(--accent);">' + escapeHtml(d.section || d.category) + '</span>' +
            '<div class="arabic text-lg mt-2 leading-relaxed">' + escapeHtml(d.arabic) + '</div>' +
            '<div class="text-sm mt-2" style="color:var(--text-muted);">' + escapeHtml(d.meaning) + '</div>' +
          '</div>' +
          '<button type="button" class="favBtn text-xl flex-shrink-0 p-1" data-id="' + escapeHtml(d.id) + '" aria-label="Favorite">' + (isFav ? "★" : "☆") + '</button>' +
        '</div>';
      listEl.appendChild(card);
      var btn = card.querySelector(".favBtn");
      if (btn) {
        btn.style.color = isFav ? "var(--accent)" : "var(--text-muted)";
        btn.addEventListener("click", function() {
          var id = btn.getAttribute("data-id");
          var f = loadFavs();
          var i = f.indexOf(id);
          if (i === -1) f.push(id); else f.splice(i, 1);
          saveFavs(f);
          render();
        });
      }
    });
  }

  document.querySelectorAll(".filterBtn").forEach(function(btn) {
    btn.addEventListener("click", function() {
      currentFilter = btn.getAttribute("data-filter") || "all";
      document.querySelectorAll(".filterBtn").forEach(function(b) {
        b.style.background = "";
        b.style.color = "";
      });
      btn.style.background = "var(--accent)";
      btn.style.color = "#fff";
      render();
    });
  });

  document.querySelectorAll(".filterBtn").forEach(function(b) {
    if ((b.getAttribute("data-filter") || "all") === currentFilter) {
      b.style.background = "var(--accent)";
      b.style.color = "#fff";
    }
  });
  render();
})();
