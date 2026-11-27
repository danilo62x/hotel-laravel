/* ===== PWA bootstrap — ensures theme-color meta + registers the service worker ===== */
/* The manifest <link> is added directly in the Blade <head>; this only handles SW. */
(function () {
  if (!document.querySelector('meta[name="theme-color"]')) {
    const meta = document.createElement('meta');
    meta.name = 'theme-color';
    meta.content = '#465fff';
    document.head.appendChild(meta);
  }
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      navigator.serviceWorker.register('/sw.js').catch(() => {});
    });
  }
})();
