function loadMembers() {
  const raw = localStorage.getItem("rc_members");
  if (!raw) return [];
  try { return JSON.parse(raw); } catch { return []; }
}
function getActiveId() {
  return localStorage.getItem("rc_active_member_id") || "";
}

const members = loadMembers();
const activeId = getActiveId();
const active = members.find(m => m.id === activeId);

const el = document.getElementById("activeMemberName");
if (el) el.innerText = active ? `${active.emoji || "🙂"} ${active.name}` : "Me";
