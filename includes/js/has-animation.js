// Has Animation — iframe-safe (WP 7+ block canvas)

function initAnimations() {
  const elements = document.querySelectorAll(".has-animation:not(.visible)");

  if (!elements.length) {
    return;
  }

  const isMobile = window.matchMedia("(max-width: 768px)").matches;
  const thresholdValue = isMobile ? 0.1 : 0.3;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("visible");
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: thresholdValue });

  elements.forEach((el) => observer.observe(el));
}

function runInitAnimations() {
  initAnimations();
}

if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", runInitAnimations);
} else {
  runInitAnimations();
}

if (window.wp && wp.domReady) {
  wp.domReady(runInitAnimations);
}

let initTimeout;
const domObserver = new MutationObserver(() => {
  clearTimeout(initTimeout);
  initTimeout = setTimeout(runInitAnimations, 100);
});

if (document.body) {
  domObserver.observe(document.body, { childList: true, subtree: true });
} else {
  document.addEventListener("DOMContentLoaded", () => {
    if (document.body) {
      domObserver.observe(document.body, { childList: true, subtree: true });
    }
  });
}
