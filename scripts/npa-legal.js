(() => {
  'use strict';

  const DATA_URL = '/data/npa-legal.json';
  const TABS = ['terms', 'privacy', 'rules', 'support'];
  const SITE_NAME = 'Newphase Academy';

  const contentEl = document.getElementById('content');
  const tocEl = document.getElementById('toc');
  let data = null;
  let observer = null;

  /* ---------- helpers ---------- */
  function el(tag, props = {}, children = []) {
    const node = document.createElement(tag);
    Object.entries(props).forEach(([key, value]) => {
      if (value === undefined || value === null) return;
      if (key === 'class') node.className = value;
      else if (key === 'text') node.textContent = value;
      else node.setAttribute(key, value);
    });
    [].concat(children).forEach((child) => {
      if (child) node.appendChild(typeof child === 'string' ? document.createTextNode(child) : child);
    });
    return node;
  }

  function formatDate(iso) {
    if (!iso) return '';
    const date = new Date(iso + 'T00:00:00');
    if (isNaN(date)) return iso;
    return new Intl.DateTimeFormat(undefined, { year: 'numeric', month: 'long', day: 'numeric' }).format(date);
  }

  function safeHref(href) {
    return /^(mailto:|tel:|https?:)/i.test(href || '') ? href : '#';
  }

  /* ---------- renderers ---------- */
  function renderHead(doc) {
    const meta = el('div', { class: 'meta' });
    if (doc.version) meta.appendChild(el('span', { class: 'pill', text: 'Version ' + doc.version }));
    if (doc.effectiveDate) meta.appendChild(el('span', { class: 'pill', text: 'Effective ' + formatDate(doc.effectiveDate) }));
    if (doc.lastUpdated) meta.appendChild(el('span', { class: 'pill', text: 'Updated ' + formatDate(doc.lastUpdated) }));

    const printBtn = el('button', { class: 'btn', type: 'button', text: 'Print or save as PDF' });
    printBtn.addEventListener('click', () => window.print());

    return el('header', { class: 'doc-head' }, [
      el('h1', { text: doc.title }),
      el('p', { text: doc.summary }),
      meta,
      el('div', { class: 'tools' }, printBtn)
    ]);
  }

  function renderSection(section) {
    const node = el('section', { class: 'section', id: section.id });
    node.appendChild(el('h2', { text: section.title }));
    (section.paragraphs || []).forEach((text) => node.appendChild(el('p', { text })));
    if (section.items && section.items.length) {
      node.appendChild(el('ul', {}, section.items.map((text) => el('li', { text }))));
    }
    if (section.note) node.appendChild(el('p', { class: 'note', text: section.note }));
    return node;
  }

  function renderLegal(doc) {
    const panel = el('div', { class: 'panel' }, (doc.sections || []).map(renderSection));
    return [renderHead(doc), panel];
  }

  function renderSupport(doc) {
    const parts = [renderHead(doc)];

    if (doc.security) {
      const s = doc.security;
      const box = el('section', { class: 'security', id: 'security' }, [
        el('h2', { text: s.title }),
        ...(s.paragraphs || []).map((text) => el('p', { text }))
      ]);
      if (s.contact) {
        box.appendChild(el('div', { class: 'big' }, el('a', { href: safeHref(s.contact.href), text: s.contact.value })));
        if (s.contact.hours) box.appendChild(el('div', { class: 'hours', text: s.contact.label + ': ' + s.contact.hours }));
      }
      parts.push(box);
    }

    const panel = el('div', { class: 'panel' });

    if (doc.contacts && doc.contacts.length) {
      const cards = doc.contacts.map((c) => el('div', { class: 'contact' }, [
        el('h3', { text: c.label }),
        el('p', { text: c.description }),
        el('a', { href: safeHref(c.href), text: c.value }),
        c.hours ? el('span', { class: 'hours', text: c.hours }) : null
      ]));
      panel.appendChild(el('section', { class: 'section', id: 'contact' }, [
        el('h2', { text: 'Contact us' }),
        el('div', { class: 'contacts' }, cards)
      ]));
    }

    if (doc.priorities && doc.priorities.length) {
      const table = el('table', {}, [
        el('thead', {}, el('tr', {}, [
          el('th', { scope: 'col', text: 'Priority' }),
          el('th', { scope: 'col', text: 'Examples' }),
          el('th', { scope: 'col', text: 'First response' })
        ])),
        el('tbody', {}, doc.priorities.map((p) => el('tr', {}, [
          el('th', { scope: 'row', text: p.level }),
          el('td', { text: p.example }),
          el('td', { text: p.response })
        ])))
      ]);
      panel.appendChild(el('section', { class: 'section', id: 'response-times' }, [
        el('h2', { text: 'Response times' }),
        el('div', { class: 'table-scroll' }, table)
      ]));
    }

    if (doc.faqs && doc.faqs.length) {
      panel.appendChild(el('section', { class: 'section', id: 'faq' }, [
        el('h2', { text: 'Common questions' }),
        ...doc.faqs.map((f) => el('details', {}, [el('summary', { text: f.q }), el('p', { text: f.a })]))
      ]));
    }

    parts.push(panel);
    return parts;
  }

  /* ---------- table of contents + scroll spy ---------- */
  function buildToc(tab) {
    tocEl.innerHTML = '';
    if (observer) observer.disconnect();

    const sections = contentEl.querySelectorAll('section[id]');
    sections.forEach((section) => {
      const title = section.querySelector('h2');
      if (!title) return;
      const link = el('a', { href: '#' + tab + '/' + section.id, 'data-target': section.id, text: title.textContent });
      link.addEventListener('click', (event) => {
        event.preventDefault();
        history.replaceState(null, '', '#' + tab + '/' + section.id);
        section.scrollIntoView();
      });
      tocEl.appendChild(el('li', {}, link));
    });

    if (!('IntersectionObserver' in window)) return;
    observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        tocEl.querySelectorAll('a').forEach((a) => {
          a.classList.toggle('active', a.dataset.target === entry.target.id);
        });
      });
    }, { rootMargin: '-90px 0px -65% 0px' });
    sections.forEach((section) => observer.observe(section));
  }

  /* ---------- routing: #terms, #privacy/retention, #support/faq ---------- */
  function parseHash() {
    const [tab, section] = location.hash.replace('#', '').split('/');
    return { tab: TABS.includes(tab) ? tab : 'terms', section: section || '' };
  }

  function show() {
    if (!data) return;
    const { tab, section } = parseHash();

    document.querySelectorAll('.tab').forEach((button) => {
      button.setAttribute('aria-selected', String(button.dataset.tab === tab));
    });
    contentEl.setAttribute('aria-labelledby', 'tab-' + tab);

    const doc = data[tab];
    contentEl.innerHTML = '';
    if (!doc) {
      contentEl.appendChild(el('div', { class: 'state error', text: 'This section is not available.' }));
      tocEl.innerHTML = '';
      return;
    }

    const nodes = tab === 'support' ? renderSupport(doc) : renderLegal(doc);
    nodes.forEach((node) => contentEl.appendChild(node));
    document.title = doc.title + ' | ' + SITE_NAME;
    buildToc(tab);

    const target = section && document.getElementById(section);
    if (target) target.scrollIntoView();
    else window.scrollTo(0, 0);
  }


  /* ---------- theme toggle (dark is the default) ---------- */
  const THEME_KEY = 'npa-legal-theme';
  const themeBtn = document.getElementById('theme-toggle');

  function applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    if (!themeBtn) return;
    const label = theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode';
    themeBtn.setAttribute('aria-label', label);
    themeBtn.setAttribute('title', label);
  }

  applyTheme(document.documentElement.getAttribute('data-theme') === 'light' ? 'light' : 'dark');

  if (themeBtn) {
    themeBtn.addEventListener('click', () => {
      const next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
      applyTheme(next);
      try { localStorage.setItem(THEME_KEY, next); } catch (e) { /* storage blocked: theme still switches */ }
    });
  }


  /* ---------- start ---------- */
  const yearEl = document.getElementById('year');
  if (yearEl) yearEl.textContent = new Date().getFullYear();

  document.querySelectorAll('.tab').forEach((button) => {
    button.addEventListener('click', () => {
      if (button.dataset.tab === 'home') {
        window.location.href = '/home';
        return;
      }
      location.hash = button.dataset.tab;
    });
  });
  window.addEventListener('hashchange', show);

  fetch(DATA_URL, { cache: 'no-cache' })
    .then((response) => {
      if (!response.ok) throw new Error('HTTP ' + response.status);
      return response.json();
    })
    .then((json) => { data = json; show(); })
    .catch(() => {
      contentEl.innerHTML = '';
      contentEl.appendChild(el('div', {
        class: 'state error',
        text: 'We could not load this page. Refresh, or contact the school office if it keeps happening.'
      }));
    });
})();
