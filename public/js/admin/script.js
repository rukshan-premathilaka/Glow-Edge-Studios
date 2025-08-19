// Highlight active nav item by filename
(function () {
  const file = location.pathname.split("/").pop() || "index.html";
  document.querySelectorAll(".nav a").forEach(a => {
    const href = a.getAttribute("href");
    if (href && href.endsWith(file)) a.classList.add("active");
  });
})();

// Profile dropdown
document.querySelectorAll(".profile-wrap").forEach(wrap => {
  const dd = wrap.querySelector(".dropdown");
  wrap.addEventListener("click", (e) => {
    e.stopPropagation();
    dd.style.display = dd.style.display === "block" ? "none" : "block";
  });
});
window.addEventListener("click", () =>
  document.querySelectorAll(".dropdown").forEach(d => (d.style.display = "none"))
);

// Generic action handlers (demo)
function flash(msg){ alert(msg); }




