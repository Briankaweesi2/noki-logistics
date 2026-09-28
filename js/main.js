/* Noki Logistics – Main JS (v2) */
(function () {
  'use strict';

  /* ─── Header scroll shadow ─── */
  const header = document.getElementById('site-header');
  if (header) {
    const onScroll = () => header.classList.toggle('scrolled', window.scrollY > 40);
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  /* ─── Mobile menu + overlay ─── */
  const toggle  = document.getElementById('menu-toggle');
  const nav     = document.getElementById('primary-nav');
  const overlay = document.getElementById('nav-overlay');
  function closeMenu() {
    if (!nav) return;
    nav.classList.remove('open');
    toggle && toggle.classList.remove('active');
    overlay && overlay.classList.remove('open');
    toggle && toggle.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  }
  if (toggle && nav) {
    toggle.addEventListener('click', () => {
      const open = nav.classList.toggle('open');
      toggle.classList.toggle('active', open);
      overlay && overlay.classList.toggle('open', open);
      toggle.setAttribute('aria-expanded', open);
      document.body.style.overflow = open ? 'hidden' : '';
    });
    overlay && overlay.addEventListener('click', closeMenu);
    // Mobile: tapping a parent (Who We Are / Services) expands its submenu; tapping a real link closes the panel.
    nav.querySelectorAll('a').forEach((a) => {
      a.addEventListener('click', (e) => {
        if (window.innerWidth > 768) return;
        const li = a.parentElement;
        const hasChildren = li && li.querySelector(':scope > .mega, :scope > .sub-menu');
        if (hasChildren) {
          e.preventDefault();            // don't navigate — just expand/collapse
          li.classList.toggle('mobile-open');
        } else {
          closeMenu();                   // real link — let it navigate, then close
        }
      });
    });
    window.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeMenu(); });
  }

  /* ─── Hero slider ─── */
  (function () {
    const slider = document.getElementById('hero-slider');
    if (!slider) return;
    const slides = Array.from(slider.querySelectorAll('.hero-slide'));
    const dots   = Array.from(slider.querySelectorAll('.hero-dot'));
    if (slides.length < 2) return;
    let current = 0, timer = null;
    const INTERVAL = 6000;

    function go(n) {
      current = (n + slides.length) % slides.length;
      slides.forEach((s, i) => s.classList.toggle('active', i === current));
      dots.forEach((d, i) => d.classList.toggle('active', i === current));
    }
    function next() { go(current + 1); }
    function start() { stop(); timer = setInterval(next, INTERVAL); }
    function stop() { if (timer) clearInterval(timer); }

    dots.forEach((d) => d.addEventListener('click', () => { go(+d.dataset.slide); start(); }));
    const prevBtn = document.getElementById('hero-prev');
    const nextBtn = document.getElementById('hero-next');
    prevBtn && prevBtn.addEventListener('click', () => { go(current - 1); start(); });
    nextBtn && nextBtn.addEventListener('click', () => { next(); start(); });
    slider.addEventListener('mouseenter', stop);
    slider.addEventListener('mouseleave', start);
    // basic swipe on touch
    let sx = null;
    slider.addEventListener('touchstart', (e) => { sx = e.touches[0].clientX; }, { passive: true });
    slider.addEventListener('touchend', (e) => {
      if (sx === null) return;
      const dx = e.changedTouches[0].clientX - sx;
      if (Math.abs(dx) > 50) { dx < 0 ? next() : go(current - 1); start(); }
      sx = null;
    }, { passive: true });
    start();
  })();

  /* ─── Counter animation ─── */
  function animateCounter(el) {
    const target = parseFloat(el.dataset.target);
    const suffix = el.dataset.suffix || '';
    if (isNaN(target)) return;
    const duration = 1800, start = performance.now();
    const finish = () => { el.textContent = target.toLocaleString() + suffix; };
    function step(now) {
      const p = Math.min((now - start) / duration, 1);
      const ease = 1 - Math.pow(1 - p, 3);
      el.textContent = Math.floor(ease * target).toLocaleString() + suffix;
      if (p < 1) requestAnimationFrame(step);
      else finish();
    }
    requestAnimationFrame(step);
    // Safety net: guarantee the final value even if rAF is throttled (background tab / offscreen).
    setTimeout(finish, duration + 250);
  }

  /* ─── Scroll reveal + counters via IntersectionObserver ─── */
  const reveals  = document.querySelectorAll('[data-aos]');
  const counters = document.querySelectorAll('.counter');
  if ('IntersectionObserver' in window) {
    if (reveals.length) {
      const ro = new IntersectionObserver((entries) => {
        entries.forEach((en) => {
          if (en.isIntersecting) { en.target.classList.add('in'); ro.unobserve(en.target); }
        });
      }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
      reveals.forEach((el, i) => {
        el.style.transitionDelay = ((i % 4) * 0.08) + 's';
        ro.observe(el);
      });
    }
    if (counters.length) {
      const co = new IntersectionObserver((entries) => {
        entries.forEach((en) => {
          if (en.isIntersecting) { animateCounter(en.target); co.unobserve(en.target); }
        });
      }, { threshold: 0.5 });
      counters.forEach((c) => co.observe(c));
    }
  } else {
    reveals.forEach((el) => el.classList.add('in'));
    counters.forEach((c) => { c.textContent = c.dataset.target + (c.dataset.suffix || ''); });
  }

  /* ─── Quote/contact form — submits straight to Formspree ─── */
  const FORMSPREE_ENDPOINT = 'https://formspree.io/f/mlgqobzw';
  const contactForm = document.getElementById('contact-form');
  if (contactForm) {
    const defaultBtnLabel = 'Get My Free Quote';
    contactForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      if (!contactForm.checkValidity()) {
        contactForm.reportValidity();
        return;
      }
      const btn = contactForm.querySelector('[type="submit"]');
      const msg = contactForm.querySelector('.form-msg');
      const orig = btn ? btn.innerHTML : '';
      if (btn) { btn.disabled = true; btn.innerHTML = 'Sending…'; }

      const fields = Object.fromEntries(new FormData(contactForm).entries());

      try {
        const res = await fetch(FORMSPREE_ENDPOINT, {
          method: 'POST',
          headers: { Accept: 'application/json' },
          body: new FormData(contactForm),
        });

        if (res.ok) {
          if (msg) {
            msg.className = 'form-msg show success';
            msg.textContent = "Thank you! We've received your request and will get back to you shortly. We've also opened WhatsApp if you'd like a faster reply.";
          }
          contactForm.reset();

          // Build the WhatsApp deep-link client-side from the submitted fields.
          const lines = ['New quote request', `Name: ${fields.name || ''}`, `Phone: ${fields.phone || ''}`, `Service: ${fields.subject || ''}`];
          if (fields.origin) lines.push(`Origin: ${fields.origin}`);
          if (fields.destination) lines.push(`Destination: ${fields.destination}`);
          if (fields.cargo) lines.push(`Cargo: ${fields.cargo}`);
          lines.push(`Message: ${fields.message || ''}`);
          const waUrl = `https://wa.me/${nokiData.whatsapp}?text=${encodeURIComponent(lines.join('\n'))}`;
          window.open(waUrl, '_blank', 'noopener');
        } else {
          if (msg) { msg.className = 'form-msg show error'; msg.textContent = 'Sorry, something went wrong. Please call or WhatsApp us instead.'; }
        }
      } catch {
        if (msg) { msg.className = 'form-msg show error'; msg.textContent = 'Network error. Please try again or call us.'; }
      } finally {
        if (btn) { btn.disabled = false; btn.innerHTML = defaultBtnLabel || orig; }
      }
    });
  }

  /* ─── AJAX Newsletter ─── */
  const newsletterForm = document.getElementById('newsletter-form');
  if (newsletterForm) {
    newsletterForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const msg = newsletterForm.parentElement.querySelector('.msg');
      const data = new FormData(newsletterForm);
      data.append('action', 'noki_newsletter');
      data.append('nonce', nokiData.nonce);
      try {
        const res = await fetch(nokiData.ajaxurl, { method: 'POST', body: data });
        const json = await res.json();
        if (msg) { msg.textContent = json.data.message; msg.style.color = json.success ? '#86efac' : '#fca5a5'; }
        if (json.success) newsletterForm.reset();
      } catch { /* silent */ }
    });
  }

  /* ─── FAQ accordion ─── */
  document.querySelectorAll('.faq-item .faq-q').forEach((q) => {
    q.addEventListener('click', () => {
      const item = q.closest('.faq-item');
      const ans = item.querySelector('.faq-a');
      const isOpen = item.classList.contains('open');
      // single-open behaviour
      document.querySelectorAll('.faq-item.open').forEach((openItem) => {
        if (openItem !== item) {
          openItem.classList.remove('open');
          openItem.querySelector('.faq-a').style.maxHeight = null;
        }
      });
      if (isOpen) {
        item.classList.remove('open');
        ans.style.maxHeight = null;
      } else {
        item.classList.add('open');
        ans.style.maxHeight = ans.scrollHeight + 'px';
      }
    });
  });

  /* ─── Quote/service type pre-select from URL (?type= or ?quote-type=) ─── */
  const params = new URLSearchParams(window.location.search);
  const qType = params.get('type') || params.get('quote-type');
  const qSelect = document.getElementById('quote-type');
  if (qType && qSelect) {
    const opt = qSelect.querySelector(`option[value="${qType}"]`);
    if (opt) opt.selected = true;
  }


  /* ─── Fleet slider ─── */
  (function () {
    const slider = document.getElementById('fleet-slider');
    if (!slider) return;
    const slides = Array.from(slider.querySelectorAll('.fleet-slide'));
    const dots   = Array.from(slider.querySelectorAll('.fleet-dot'));
    if (slides.length < 2) return;

    let current = 0;
    let timer = null;
    const INTERVAL = 5200;

    function go(n) {
      current = (n + slides.length) % slides.length;
      slides.forEach((slide, i) => slide.classList.toggle('active', i === current));
      dots.forEach((dot, i) => dot.classList.toggle('active', i === current));
    }
    function next() { go(current + 1); }
    function stop() { if (timer) clearInterval(timer); }
    function start() { stop(); timer = setInterval(next, INTERVAL); }

    dots.forEach((dot) => dot.addEventListener('click', () => { go(+dot.dataset.slide); start(); }));
    const prev = document.getElementById('fleet-prev');
    const nextBtn = document.getElementById('fleet-next');
    prev && prev.addEventListener('click', () => { go(current - 1); start(); });
    nextBtn && nextBtn.addEventListener('click', () => { next(); start(); });

    slider.addEventListener('mouseenter', stop);
    slider.addEventListener('mouseleave', start);
    slider.addEventListener('focusin', stop);
    slider.addEventListener('focusout', start);

    let touchX = null;
    slider.addEventListener('touchstart', (e) => { touchX = e.touches[0].clientX; }, { passive: true });
    slider.addEventListener('touchend', (e) => {
      if (touchX === null) return;
      const delta = e.changedTouches[0].clientX - touchX;
      if (Math.abs(delta) > 45) delta < 0 ? next() : go(current - 1);
      touchX = null;
      start();
    }, { passive: true });

    start();
  })();

})();
