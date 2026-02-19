const titleEl = document.getElementById("surahTitle");
const metaEl = document.getElementById("surahMeta");
const ayahEl = document.getElementById("ayahList");

const qariSelect = document.getElementById("qariSelect");
const playAllBtn = document.getElementById("playAllBtn");
const stopBtn = document.getElementById("stopBtn");
const repeatModeEl = document.getElementById("repeatMode");
const playbackRateEl = document.getElementById("playbackRate");
const resumeBtn = document.getElementById("resumeBtn");
const toggleTranslationBtn = document.getElementById("toggleTranslation");

const surahNo = window.SURAH_NO || 1;

const KEY_LAST = "rc_quran_last";
const KEY_REPEAT = "rc_quran_repeat";
const KEY_RATE = "rc_quran_rate";
const KEY_SHOW_TR = "rc_quran_show_tr";

function escapeHtml(str) {
  return String(str).replace(/[&<>"']/g, s => ({
    "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#39;"
  }[s]));
}

const player = new Audio();
player.preload = "none";

let currentlyPlayingCard = null;
let currentlyPlayingAyahNo = null;
let playAllMode = false;
let playQueue = [];
let currentIndex = -1;

let cachedTextSurah = null;
let cachedTrSurah = null;

let lastRenderedCardsByAyah = {};
let audioUrlByAyah = {};
let translationByAyah = {};

function getRepeatMode(){ return localStorage.getItem(KEY_REPEAT) || "off"; }
function setRepeatMode(v){ localStorage.setItem(KEY_REPEAT, v); }
function getRate(){ return parseFloat(localStorage.getItem(KEY_RATE) || "1"); }
function setRate(v){ localStorage.setItem(KEY_RATE, String(v)); }
function getShowTr(){ return (localStorage.getItem(KEY_SHOW_TR) || "0") === "1"; }
function setShowTr(v){ localStorage.setItem(KEY_SHOW_TR, v ? "1" : "0"); }

function applyRate(){ player.playbackRate = getRate(); }

function setPlayingUI(card, isPlaying) {
  if (!card) return;
  card.classList.toggle("ring-2", isPlaying);
  card.classList.toggle("ring-yellow-400", isPlaying);
  const badge = card.querySelector("[data-audio-badge]");
  if (badge) badge.innerText = isPlaying ? "🔊 Playing" : "▶ Tap to listen";
}

function scrollToCard(card){ card?.scrollIntoView({ behavior:"smooth", block:"center" }); }

function saveLastPosition(ayahNo) {
  const edition = qariSelect ? qariSelect.value : "ar.alafasy";
  localStorage.setItem(KEY_LAST, JSON.stringify({ surahNo, ayahNo, edition }));
}

function stopPlayback() {
  playAllMode = false; playQueue = []; currentIndex = -1;
  player.pause(); player.currentTime = 0;
  if (currentlyPlayingCard) setPlayingUI(currentlyPlayingCard, false);
  currentlyPlayingCard = null; currentlyPlayingAyahNo = null;
}

function playAyah(card, ayahNo, url, shouldScroll = true) {
  if (currentlyPlayingCard && currentlyPlayingCard !== card) setPlayingUI(currentlyPlayingCard, false);

  if (currentlyPlayingCard === card && !player.paused) {
    player.pause(); setPlayingUI(card, false); return;
  }

  currentlyPlayingCard = card;
  currentlyPlayingAyahNo = ayahNo;
  saveLastPosition(ayahNo);

  player.src = url;
  applyRate();

  player.play().then(() => {
    setPlayingUI(card, true);
    if (shouldScroll) scrollToCard(card);
  }).catch(() => {
    setPlayingUI(card, false);
    alert("Audio couldn't play. Tap again or allow audio playback.");
  });
}

player.addEventListener("ended", () => {
  const repeat = getRepeatMode();

  if (repeat === "ayah" && currentlyPlayingAyahNo != null) {
    const ay = currentlyPlayingAyahNo;
    const card = lastRenderedCardsByAyah[ay];
    const url = audioUrlByAyah[ay];
    if (card && url) { playAllMode = false; currentIndex = -1; playAyah(card, ay, url, true); return; }
  }

  if (playAllMode) {
    currentIndex++;
    if (currentIndex < playQueue.length) {
      const next = playQueue[currentIndex];
      playAyah(next.card, next.ayahNo, next.url, true);
      return;
    } else {
      if (repeat === "surah" && playQueue.length > 0) {
        currentIndex = 0;
        const first = playQueue[0];
        playAyah(first.card, first.ayahNo, first.url, true);
        return;
      }
      playAllMode = false; currentIndex = -1;
    }
  }

  if (currentlyPlayingCard) setPlayingUI(currentlyPlayingCard, false);
});

function fetchTextSurah() {
  if (cachedTextSurah) return Promise.resolve(cachedTextSurah);
  return fetch(`https://api.alquran.cloud/v1/surah/${surahNo}/quran-uthmani`)
    .then(r=>r.json()).then(d=>{ if(!d||d.code!==200) throw 0; cachedTextSurah=d.data; return cachedTextSurah; });
}

// English translation: Pickthall (clear). You can change to en.sahih later.
function fetchTranslationSurah() {
  if (cachedTrSurah) return Promise.resolve(cachedTrSurah);
  return fetch(`https://api.alquran.cloud/v1/surah/${surahNo}/en.pickthall`)
    .then(r=>r.json()).then(d=>{ if(!d||d.code!==200) throw 0; cachedTrSurah=d.data; return cachedTrSurah; });
}

function fetchAudioSurah(edition) {
  return fetch(`https://api.alquran.cloud/v1/surah/${surahNo}/${edition}`)
    .then(r=>r.json()).then(d=>{ if(!d||d.code!==200) throw 0; return d.data; });
}

function renderSurah(textSurah, trSurah, audioSurah, editionLabel) {
  const s = textSurah;
  const t = trSurah;

  titleEl.innerText = `${s.number}. ${s.englishName} — ${s.name}`;
  metaEl.innerText = `${s.englishNameTranslation} • ${s.revelationType} • ${s.numberOfAyahs} ayahs • Qari: ${editionLabel}`;

  ayahEl.innerHTML = "";
  lastRenderedCardsByAyah = {};
  audioUrlByAyah = {};
  translationByAyah = {};

  // map translation by ayah
  t.ayahs.forEach(x => { translationByAyah[x.numberInSurah] = x.text; });

  // map audio by ayah
  const audioByAyahNo = {};
  audioSurah.ayahs.forEach(x => { audioByAyahNo[x.numberInSurah] = x.audio; });

  const queue = [];
  const showTr = getShowTr();
  if (toggleTranslationBtn) toggleTranslationBtn.innerText = showTr ? "🌐 Hide Translation" : "🌐 Show Translation";

  s.ayahs.forEach(ayah => {
    const ayahNo = ayah.numberInSurah;
    const url = audioByAyahNo[ayahNo] || "";
    const tr = translationByAyah[ayahNo] || "";

    const card = document.createElement("div");
    card.className = "bg-slate-800 rounded-2xl p-5 shadow cursor-pointer hover:bg-slate-700 transition";
    card.dataset.ayah = String(ayahNo);

    card.innerHTML = `
      <div class="flex items-start justify-between gap-4">
        <div class="arabic text-2xl leading-relaxed text-right flex-1">
          ${escapeHtml(ayah.text)}
          <span class="text-yellow-400 text-base align-middle">﴿${ayahNo}﴾</span>
        </div>
        <div class="text-slate-300 text-xs whitespace-nowrap" data-audio-badge>
          ${url ? "▶ Tap to listen" : "No audio"}
        </div>
      </div>

      <div class="mt-3 text-slate-200 text-sm leading-relaxed ${showTr ? "" : "hidden"}" data-tr>
        ${escapeHtml(tr)}
      </div>
    `;

    if (url) {
      card.addEventListener("click", () => {
        playAllMode = false; currentIndex = -1; playQueue = [];
        playAyah(card, ayahNo, url, true);
      });
      queue.push({ card, ayahNo, url });
      audioUrlByAyah[ayahNo] = url;
    }

    lastRenderedCardsByAyah[ayahNo] = card;
    ayahEl.appendChild(card);
  });

  return queue;
}

async function loadSurahWithQari(edition) {
  stopPlayback();
  titleEl.innerText = "Loading...";
  metaEl.innerText = "Fetching Quran text, translation and audio…";
  ayahEl.innerHTML = `<div class="text-slate-300">Loading…</div>`;

  const editionLabel = qariSelect?.options[qariSelect.selectedIndex]?.textContent || edition;

  try {
    const [textSurah, trSurah, audioSurah] = await Promise.all([
      fetchTextSurah(),
      fetchTranslationSurah(),
      fetchAudioSurah(edition)
    ]);

    playQueue = renderSurah(textSurah, trSurah, audioSurah, editionLabel);
  } catch {
    titleEl.innerText = "Failed to load Surah.";
    metaEl.innerText = "Check your internet connection and try again.";
    ayahEl.innerHTML = "";
  }
}

// Buttons
playAllBtn?.addEventListener("click", () => {
  if (!playQueue || playQueue.length === 0) return;
  playAllMode = true; currentIndex = 0;
  const first = playQueue[0];
  playAyah(first.card, first.ayahNo, first.url, true);
});

stopBtn?.addEventListener("click", stopPlayback);

repeatModeEl && (repeatModeEl.value = getRepeatMode());
repeatModeEl?.addEventListener("change", () => setRepeatMode(repeatModeEl.value));

playbackRateEl && (playbackRateEl.value = String(getRate()));
playbackRateEl?.addEventListener("change", () => { setRate(playbackRateEl.value); applyRate(); });

toggleTranslationBtn?.addEventListener("click", () => {
  const v = !getShowTr();
  setShowTr(v);
  document.querySelectorAll("[data-tr]").forEach(el => el.classList.toggle("hidden", !v));
  toggleTranslationBtn.innerText = v ? "🌐 Hide Translation" : "🌐 Show Translation";
});

resumeBtn?.addEventListener("click", () => {
  const raw = localStorage.getItem(KEY_LAST);
  if (!raw) return alert("No last position saved yet.");
  try {
    const last = JSON.parse(raw);
    if (parseInt(last.surahNo,10) !== surahNo) { window.location.href = `surah.php?no=${last.surahNo}`; return; }

    const ay = parseInt(last.ayahNo,10);
    const card = lastRenderedCardsByAyah[ay];
    const url = audioUrlByAyah[ay];
    if (!card || !url) return alert("Saved ayah audio not available.");

    const savedEdition = last.edition || (qariSelect ? qariSelect.value : "ar.alafasy");
    if (qariSelect && qariSelect.value !== savedEdition) {
      qariSelect.value = savedEdition;
      loadSurahWithQari(savedEdition).then(() => {
        const card2 = lastRenderedCardsByAyah[ay];
        const url2 = audioUrlByAyah[ay];
        if (card2 && url2) playAyah(card2, ay, url2, true);
      });
    } else {
      playAyah(card, ay, url, true);
    }
  } catch { alert("Could not read saved position."); }
});

// init
applyRate();
loadSurahWithQari(qariSelect ? qariSelect.value : "ar.alafasy");
