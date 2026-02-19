const box = document.getElementById("storyBox");
let age = "kids";

async function loadStory() {
  box.innerHTML = `<p class="text-slate-300">Loading story...</p>`;

  const res = await fetch(`api/stories.php?age=${age}`);
  const data = await res.json();

  if (!data) {
    box.innerHTML = `<p class="text-slate-300">No story published yet.</p>`;
    return;
  }

  box.innerHTML = `
    <h2 class="text-xl font-bold text-yellow-400 mb-2">${data.title}</h2>

    ${data.thumbnail_url ? `
      <img src="${data.thumbnail_url}" class="w-full rounded-2xl mb-4" alt="thumbnail">
    ` : ""}

    <div class="text-slate-200 leading-relaxed whitespace-pre-line mb-6">
      ${escapeHtml(data.full_text)}
    </div>

    ${data.audio_url ? `
      <div class="bg-slate-900 rounded-2xl p-4 mb-4">
        <div class="font-semibold mb-2">🎧 Listen</div>
        <audio controls class="w-full">
          <source src="${data.audio_url}" type="audio/mpeg">
        </audio>
      </div>
    ` : ""}

    ${data.video_url ? `
      <div class="bg-slate-900 rounded-2xl p-4 mb-4">
        <div class="font-semibold mb-2">🎥 Watch</div>
        <video controls class="w-full rounded-xl">
          <source src="${data.video_url}" type="video/mp4">
        </video>
      </div>
    ` : ""}

    ${data.moral ? `
      <div class="bg-slate-900 rounded-2xl p-4 mb-3">
        <div class="font-semibold mb-1">✅ Moral</div>
        <div class="text-slate-300">${escapeHtml(data.moral)}</div>
      </div>
    ` : ""}

    ${data.action_tip ? `
      <div class="bg-slate-900 rounded-2xl p-4">
        <div class="font-semibold mb-1">🎯 Action for today</div>
        <div class="text-slate-300">${escapeHtml(data.action_tip)}</div>
      </div>
    ` : ""}
  `;
}

function escapeHtml(str) {
  return String(str ?? "").replace(/[&<>"']/g, s => ({
    "&":"&amp;","<":"&lt;",">":"&gt;",'"':"&quot;","'":"&#039;"
  }[s]));
}

document.getElementById("kidsBtn").addEventListener("click", () => {
  age = "kids";
  document.getElementById("kidsBtn").className = "px-4 py-2 rounded-xl bg-yellow-400 text-black font-semibold";
  document.getElementById("adultBtn").className = "px-4 py-2 rounded-xl bg-slate-900 text-white";
  loadStory();
});

document.getElementById("adultBtn").addEventListener("click", () => {
  age = "adult";
  document.getElementById("adultBtn").className = "px-4 py-2 rounded-xl bg-yellow-400 text-black font-semibold";
  document.getElementById("kidsBtn").className = "px-4 py-2 rounded-xl bg-slate-900 text-white";
  loadStory();
});

loadStory();
