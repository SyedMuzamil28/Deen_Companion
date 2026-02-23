(function() {
  var KEY = "deen_theme";
  var dark = "dark";
  var light = "light";
  function get() { return localStorage.getItem(KEY) || dark; }
  function set(v) {
    localStorage.setItem(KEY, v);
    document.documentElement.classList.toggle("light-mode", v === light);
    var meta = document.querySelector('meta[name="theme-color"]');
    if (meta) meta.setAttribute("content", v === light ? "#e8e6d9" : "#166534");
    updateIcons();
  }
  function toggle() {
    var next = get() === dark ? light : dark;
    set(next);
    return next;
  }
  function updateIcons() {
    var isLight = get() === light;
    var sun = document.getElementById("iconSun");
    var moon = document.getElementById("iconMoon");
    if (sun) sun.classList.toggle("hidden", !isLight);
    if (moon) moon.classList.toggle("hidden", isLight);
  }
  document.documentElement.classList.toggle("light-mode", get() === light);
  if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", updateIcons);
  else updateIcons();
  document.getElementById("themeToggle")?.addEventListener("click", toggle);
  window.deenTheme = { get: get, set: set, toggle: toggle };
})();
