(function() {
  var KEY_DONE_DAYS = "deen_ramadan_done_days";
  var KEY_START = "deen_ramadan_start";

  function todayKey() {
    var d = new Date();
    return d.getFullYear() + "-" + String(d.getMonth() + 1).padStart(2, "0") + "-" + String(d.getDate()).padStart(2, "0");
  }

  function getStartDate() {
    return localStorage.getItem(KEY_START) || "";
  }

  function setStartDate(iso) {
    localStorage.setItem(KEY_START, iso);
  }

  function getDoneDays() {
    var raw = localStorage.getItem(KEY_DONE_DAYS);
    if (!raw) return [];
    try { return JSON.parse(raw); } catch (e) { return []; }
  }

  function setDoneDays(arr) {
    localStorage.setItem(KEY_DONE_DAYS, JSON.stringify(arr));
  }

  function dayIndex(isoStart, isoToday) {
    var s = new Date(isoStart + "T00:00:00");
    var t = new Date(isoToday + "T00:00:00");
    var diff = Math.floor((t - s) / (24 * 60 * 60 * 1000));
    return diff + 1;
  }

  function updateProgress() {
    var today = todayKey();
    var start = getStartDate();
    if (!start) {
      start = today;
      setStartDate(start);
    }
    var dayNum = dayIndex(start, today);
    if (dayNum < 1) dayNum = 1;
    if (dayNum > 30) dayNum = 30;

    var done = getDoneDays();
    if (!done.includes(dayNum)) {
      var cb = document.getElementById("quranDoneToday");
      if (cb) cb.checked = false;
    } else {
      var cb = document.getElementById("quranDoneToday");
      if (cb) cb.checked = true;
    }

    var completed = done.filter(function(d) { return d >= 1 && d <= 30; }).length;
    var pct = Math.round((completed / 30) * 100);

    var bar = document.getElementById("ramadanProgressBar");
    var text = document.getElementById("ramadanProgressText");
    var label = document.getElementById("ramadanDayLabel");
    if (bar) bar.style.width = pct + "%";
    if (text) text.textContent = completed + "/30";
    if (label) label.textContent = "Day " + dayNum + " of 30";
  }

  var quranCb = document.getElementById("quranDoneToday");
  if (quranCb) {
    quranCb.addEventListener("change", function() {
      var today = todayKey();
      var start = getStartDate() || today;
      var dayNum = dayIndex(start, today);
      if (dayNum < 1 || dayNum > 30) return;
      var done = getDoneDays();
      if (quranCb.checked) {
        if (!done.includes(dayNum)) done.push(dayNum);
        done.sort(function(a,b) { return a - b; });
      } else {
        done = done.filter(function(d) { return d !== dayNum; });
      }
      setDoneDays(done);
      updateProgress();
    });
  }

  updateProgress();
})();
