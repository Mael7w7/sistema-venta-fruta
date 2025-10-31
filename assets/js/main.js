// Smooth scroll for internal links
document.addEventListener('click', (e) => {
  const el = e.target.closest('a[href^="#"]');
  if (!el) return;
  const target = document.querySelector(el.getAttribute('href'));
  if (target) {
    e.preventDefault();
    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
});

// Collapse navbar on link click (mobile)
document.addEventListener('DOMContentLoaded', () => {
  const navLinks = document.querySelectorAll('.navbar .nav-link');
  const navbarCollapse = document.getElementById('navbarSupportedContent');
  navLinks.forEach((link) => {
    link.addEventListener('click', () => {
      if (navbarCollapse && navbarCollapse.classList.contains('show')) {
        const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
        if (bsCollapse) bsCollapse.hide();
      }
    });
  });
});


