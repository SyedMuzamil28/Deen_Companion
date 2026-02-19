const KEY_MEMBERS = "rc_members";
const KEY_ACTIVE = "rc_active_member_id";
const API_FAMILY = "api/family.php";

function uid() {
  return "m_" + Math.random().toString(16).slice(2) + Date.now().toString(16);
}

function getActiveId() {
  return localStorage.getItem(KEY_ACTIVE) || "";
}
function setActiveId(id) {
  localStorage.setItem(KEY_ACTIVE, id);
}

async function loadMembers() {
  // Try DB first
  try {
    const res = await fetch(API_FAMILY, { method: "GET" });
    if (res.ok) {
      const dbMembers = await res.json();
      if (Array.isArray(dbMembers) && dbMembers.length) {
        const mapped = dbMembers.map(m => ({
          id: m.member_uid,
          name: m.name,
          emoji: m.emoji || "🙂"
        }));
        localStorage.setItem(KEY_MEMBERS, JSON.stringify(mapped));
        return mapped;
      }
    }
  } catch (e) {
    // ignore and fallback
  }

  // Fallback localStorage
  const raw = localStorage.getItem(KEY_MEMBERS);
  if (!raw) return [];
  try { return JSON.parse(raw); } catch { return []; }
}

async function saveMemberToDB(member) {
  try {
    await fetch(API_FAMILY, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        member_uid: member.id,
        name: member.name,
        emoji: member.emoji || "🙂"
      })
    });
  } catch (e) {
    // If DB fails, we still keep localStorage
  }
}

function saveMembersLocal(members) {
  localStorage.setItem(KEY_MEMBERS, JSON.stringify(members));
}

function flash(text) {
  const el = document.getElementById("addMsg");
  if (!el) return;
  el.innerText = text;
  setTimeout(() => (el.innerText = ""), 2500);
}

function escapeHtml(str) {
  return String(str).replace(/[&<>"']/g, s => ({
    "&": "&amp;", "<": "&lt;", ">": "&gt;", '"': "&quot;", "'": "&#039;"
  }[s]));
}

async function ensureDefaultMember() {
  let members = await loadMembers();

  if (members.length === 0) {
    const me = { id: uid(), name: "Me", emoji: "🙂" };
    members = [me];
    saveMembersLocal(members);
    setActiveId(me.id);
    await saveMemberToDB(me);
    flash("✅ Default member created");
  } else {
    if (!getActiveId()) setActiveId(members[0].id);
  }

  return members;
}

async function render() {
  const list = document.getElementById("membersList");
  if (!list) return;

  const members = await loadMembers();
  const activeId = getActiveId();

  list.innerHTML = "";

  members.forEach(m => {
    const isActive = m.id === activeId;

    const card = document.createElement("div");
    card.className =
      "bg-slate-900 rounded-2xl p-5 border " +
      (isActive ? "border-yellow-400" : "border-slate-800");

    card.innerHTML = `
      <div class="flex items-center justify-between gap-3">
        <div class="flex items-center gap-3">
          <div class="w-12 h-12 rounded-2xl bg-slate-800 grid place-items-center text-2xl">
            ${m.emoji || "🙂"}
          </div>
          <div>
            <div class="font-semibold text-lg">${escapeHtml(m.name)}</div>
            <div class="text-xs text-slate-400">${isActive ? "Active" : "Not active"}</div>
          </div>
        </div>

        <div class="flex items-center gap-2">
          <button class="setActiveBtn bg-yellow-400 text-black text-sm font-semibold px-3 py-2 rounded-xl hover:opacity-90"
                  data-id="${m.id}">
            ${isActive ? "Active" : "Set Active"}
          </button>
        </div>
      </div>
    `;

    list.appendChild(card);
  });

  document.querySelectorAll(".setActiveBtn").forEach(btn => {
    btn.addEventListener("click", async () => {
      setActiveId(btn.dataset.id);
      await render();
      flash("✅ Active member changed");
    });
  });
}

async function addMember() {
  const nameEl = document.getElementById("memberName");
  const emojiEl = document.getElementById("memberEmoji");
  const name = (nameEl?.value || "").trim();
  const emoji = (emojiEl?.value || "").trim();

  if (!name) return flash("⚠️ Please enter a name");

  const members = await loadMembers();
  const newMember = { id: uid(), name, emoji: emoji || "🙂" };

  // Save local first for instant UI
  members.push(newMember);
  saveMembersLocal(members);

  // If no active member yet, set this
  if (!getActiveId()) setActiveId(newMember.id);

  // Sync to DB
  await saveMemberToDB(newMember);

  if (nameEl) nameEl.value = "";
  if (emojiEl) emojiEl.value = "";

  await render();
  flash("✅ Member added");
}

document.getElementById("addMemberBtn")?.addEventListener("click", addMember);

// Init
(async function init() {
  await ensureDefaultMember();
  await render();
})();
