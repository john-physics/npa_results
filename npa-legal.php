<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name ="description" content="NPA legal and Policy">
<meta name ="keywords" content="NewPhase, Academy,legal,terms,policy,rules,ABC">
<meta name="author" content="John Ella">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="manifest" href="/npa-manifest.json">
<meta name="theme-color" content="#E4CAD5">

<meta name="mobile-web-app-capable" content="yes">

<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="NPA Results">
<link rel="apple-touch-icon" href="/images/pwa-192.png">

<title>NPA Legal and Policy</title>

<link rel="canonical" href="https://newphaseacademyresults.com.ng/npa-legal">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700;800;900&display=swap" rel="stylesheet">

  <script>
     
    /* Apply saved theme before first paint. Dark is the default. */
    (function () {
      var theme = 'light';
      try { if (localStorage.getItem('npa-legal-theme') === 'light') theme = 'light'; } catch (e) {}
      document.documentElement.setAttribute('data-theme', theme);
    })();
  </script>
  <style>
    /* ---------- Design tokens: dark is the default, light overrides it ---------- */
    :root {
      color-scheme: dark;
      --bg: #0c1622;
      --surface: #121f2e;
      --ink: #e8eff7;
      --ink-soft: #9db0c4;
      --line: #223449;
      --accent: #5aa5f5;
      --accent-ink: #08121d;
      --accent-tint: #15293f;
      --alert: #ff8f87;
      --alert-tint: #2b1716;
      --radius: 12px;
      --font: "Poppins",sans-serif;
    }
    :root[data-theme="light"] {
      color-scheme: light;
      --bg: #f4f7fb;
      --surface: #ffffff;
      --ink: #12263a;
      --ink-soft: #4b6075;
      --line: #dbe4ee;
      --accent: #1b74d8;
      --accent-ink: #ffffff;
      --accent-tint: #e6f1fd;
      --alert: #b3261e;
      --alert-tint: #fdeceb;
    }

    *, *::before, *::after { box-sizing: border-box; }
    html { scroll-behavior: smooth; scroll-padding-top: 88px; }
    body {
      margin: 0;
      background: var(--bg);
      color: var(--ink);
      font-family: var(--font);
      font-size: 16px;
      line-height: 1.6;
    }
    a { color: var(--accent); }
    :focus-visible { outline: 3px solid var(--accent); outline-offset: 2px; border-radius: 4px; }

    /* ---------- Top bar ---------- */
    .topbar {
  position: sticky; top: 0; z-index: 10;
      background: var(--surface);
      border-bottom: 1px solid var(--line);
    }
    .topbar-inner {
      width: 100%;
      max-width: 1120px; margin: 0 auto; padding: 0 20px;
      display: flex; align-items: center; gap: 24px; min-height: 40px; flex-wrap: wrap;
    }
    .brand { font-weight: 700; font-size: 18px; letter-spacing: -0.01em; white-space: nowrap; }
    .brand span { color: var(--ink-soft); font-weight: 500; }
    .brand img{
        position: relative;
        top:15px;
        width: 40px;
        height: 40px;
        border-radius: 10px;
    }
    .tabs { display: flex; 
       gap: 2px; 
       margin-left: auto; 
       overflow-x: auto; 
        scrollbar-width:none;
        flex-direction: row;
    }
  .tab {
  appearance: none; background: none; border: 0; cursor: pointer;
  font: inherit; font-weight: 600; color: var(--ink-soft);
  padding: 20px 14px 17px; border-bottom: 3px solid transparent;
  font-size: 14px;
  display: inline-block;
  white-space: nowrap;   /* stops words from wrapping */
  flex: 0 0 auto;  /* stops flex from shrinking the tabs */
 
}
    .tab:hover { color: var(--ink); }
    .tab[aria-selected="true"] { color: var(--accent); border-bottom-color: var(--accent); }

    /* ---------- Theme toggle ---------- */
    .theme-toggle {
      appearance: none; cursor: pointer; flex: none;
      width: 40px; height: 40px; padding: 0;
      display: inline-flex; align-items: center; justify-content: center;
      background: none; color: var(--ink-soft);
      border: 1px solid var(--line); border-radius: 999px;
    }
    .theme-toggle:hover { color: var(--accent); border-color: var(--accent); }
    .theme-toggle svg { width: 20px; height: 20px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
    /* Dark mode shows the sun (tap for light); light mode shows the moon (tap for dark) */
    .theme-toggle .icon-moon { display: none; }
    :root[data-theme="light"] .theme-toggle .icon-sun { display: none; }
    :root[data-theme="light"] .theme-toggle .icon-moon { display: block; }

    /* ---------- Layout ---------- */
    .wrap {
      max-width: 1120px; margin: 0 auto; padding: 32px 20px 80px;
      display: grid; grid-template-columns: 200px minmax(0, 1fr); gap: 40px;
    }
    .toc { position: sticky; top: 96px; align-self: start; max-height: calc(100vh - 120px); overflow-y: auto; }
    .toc-title { margin: 0 0 8px; font-size: 14px; font-weight: 700; color: var(--ink); }
    .toc ul { list-style: none; margin: 0; padding: 0; border-left: 2px solid var(--line); }
    .toc a {
      display: block; padding: 6px 12px; margin-left: -2px; border-left: 2px solid transparent;
      color: var(--ink-soft); text-decoration: none; font-size: 14px; line-height: 1.4;
    }
    .toc a:hover { color: var(--ink); }
    .toc a.active { color: var(--accent); border-left-color: var(--accent); font-weight: 600; }

    /* ---------- Document ---------- */
    .doc-head { margin-bottom: 28px; }
    .doc-head h1 { margin: 0 0 8px; font-size: 34px; line-height: 1.2; letter-spacing: -0.02em; }
    .doc-head p { margin: 0; color: var(--ink-soft); max-width: 62ch; }
    .meta { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 16px; }
    .pill {
      font-size: 13px; padding: 4px 10px; border-radius: 999px;
      background: var(--accent-tint); color: var(--accent); font-weight: 600;
    }
    .tools { margin-top: 16px; }
    .btn {
      font: inherit; font-size: 14px; font-weight: 600; cursor: pointer;
      padding: 8px 14px; border-radius: 8px; border: 1px solid var(--line);
      background: var(--surface); color: var(--ink);
    }
    .btn:hover { border-color: var(--accent); color: var(--accent); }

    .panel {
      background: var(--surface); 
      border: 1px solid var(--line);
      border-radius: var(--radius); 
      padding: 10px;
     position: relative;
      margin: 10px auto;
      width: 100%;
     
    }
    .section { padding: 10px 0; border-bottom: 1px solid var(--line);
    }
    .section:last-child { border-bottom: 0; }
    .section h2 { margin: 0 0 12px; font-size: 21px; line-height: 1.3; letter-spacing: -0.01em; }
    .section p { margin: 0 0 12px; max-width: 70ch; }
    .section ul { margin: 0 0 12px; padding-left: 20px; max-width: 50ch; }
    .section li { margin-bottom: 6px; }
    .note {
      margin: 14px 0 0; padding: 10px 14px; max-width: 50ch;
      background: var(--accent-tint); border-left: 4px solid var(--accent);
      border-radius: 0 8px 8px 0;
    }

    /* ---------- Support ---------- */
    .security {
      background: var(--alert-tint); border: 1px solid var(--alert);
      border-radius: var(--radius); padding: 10px ; margin-bottom: 20px;
    
        width: 100%;
    }
    .security h2 { margin: 0 0 8px; font-size: 21px; color: var(--alert); }
    .security p { margin: 0 0 14px; max-width: 70ch; }
    .security .big { font-size: 20px; font-weight: 700; color: var(--ink); }
    .security .hours { color: var(--ink-soft); font-size: 12px; }

    .contacts { 

        display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px; margin-top: 5px; }
    .contact {
  
        border: 1px solid var(--line); 
        border-radius: 10px; 
        padding: 18px;
        background: var(--bg);
        
    }
    .contact h3 { margin: 0 0 6px; font-size: 16px; }
    .contact p { margin: 0 0 12px; font-size: 14px; color: var(--ink-soft); }
    .contact a { font-weight: 600; word-break: break-word; }
    .contact .hours { display: block; margin-top: 6px; font-size: 13px; color: var(--ink-soft); }

    .table-scroll { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; font-size: 15px; min-width: 520px; }
    th, td { text-align: left; padding: 12px 14px; border-bottom: 1px solid var(--line); vertical-align: top; }
    th { font-size: 14px; color: var(--ink-soft); font-weight: 600; }

    details { border-bottom: 1px solid var(--line); }
    details:last-child { border-bottom: 0; }
    summary { cursor: pointer; padding: 14px 0; font-weight: 600; list-style: none; display: flex; justify-content: space-between; gap: 16px; }
    summary::-webkit-details-marker { display: none; }
    summary::after { content: "+"; font-weight: 400; font-size: 22px; line-height: 1; color: var(--accent); }
    details[open] summary::after { content: "\2212"; }
    details p { margin: 0 0 16px; color: var(--ink-soft); max-width: 70ch; }

    .state { padding: 48px 0; text-align: center; color: var(--ink-soft); }
    .state.error { color: var(--alert); }

    /* ---------- Responsive ---------- */
    @media (max-width: 900px) {
      .wrap {
          display: block;
       /* grid-template-columns: 1fr; gap: 20px; */ }
      .toc { position: static; max-height: none; }
      .toc ul { display: flex; flex-wrap: wrap; gap: 6px; border-left: 0; }
      .toc a { border: 1px solid var(--line); border-radius: 999px; margin: 0; padding: 4px 12px; }
      .toc a.active { border-color: var(--accent); }
      .theme-toggle { margin-left: auto; order: 2; }
      .tabs { margin-left: 0; width: 100%; order: 3; }
      .tab { padding: 12px 12px 10px; }
      .panel { padding: 5px 10px; width:100%; margin:10px auto;}
      .security{
        width:100%; margin:auto;  
        600; word-break: break-word;
      }
      .doc-head h1 {
        margin-top: 20px;  
          font-size: 28px; }
    }
    
    .footer { text-align: center; padding: 24px 20px; font-size: 14px; color:#fff; border-top: 1px solid var(--line); background: #222;
    width:100%}

    @media (prefers-reduced-motion: reduce) { html { scroll-behavior: auto; } }
    @media print {
      :root, :root[data-theme] {
        --bg: #fff; --surface: #fff; --ink: #000; --ink-soft: #333; --line: #ccc;
        --accent: #1b74d8; --accent-tint: #e6f1fd; --alert: #b3261e; --alert-tint: #fdeceb;
      }
      .topbar, .toc, .tools { display: none; }
      .wrap { display: block; padding: 0; }
      .panel { border: 0; padding: 0; }
      body { background: #fff; color: #000; }
    }
    
 .brand #npa{
     position: absolute;
     top: -5px;
     left: 20%;
 }
 
 .brand #legal{
    position: relative;
     top: -25px;
     left: 55%; 
     font-size: 14px;
     color: var(--ink-soft) ;
 }
 
 @media (min-width: 800px){
    
    
 .brand #npa{
     position: absolute;
     top: -5px;
     left: 8%;
 }
   
   .brand #legal{
    position: relative;
     top: -30px;
     left: 60%; 
     font-size: 14px;
     color: var(--ink-soft) ;
 } 
     
 }
 
 
  </style>
</head>
<body>
  <header class="topbar">
    <div class="topbar-inner">
      <div class="brand">
      <img src="/images/npa-logo.jpg">  
        <p id="npa">NewPhase Academy </p>
        <p id="legal">Legal & Policies</p>
          </div>
       <nav class="tabs" role="tablist" aria-label="Legal and policies">
        <button class="tab" role="tab" id="tab-home" data-tab="home" aria-selected="false">Home</button>
        <button class="tab" role="tab" id="tab-terms" data-tab="terms" aria-selected="false">Terms of Service</button>
        <button class="tab" role="tab" id="tab-privacy" data-tab="privacy" aria-selected="false">Privacy Policy</button>
        <button class="tab" role="tab" id="tab-rules" data-tab="rules" yyaria-selected="false">School Rules</button>
        <button class="tab" role="tab" id="tab-support" data-tab="support" aria-selected="false">Support</button>
      </nav>
      
      <button class="theme-toggle" id="theme-toggle" type="button" aria-label="Switch to light mode" title="Switch to light mode">
        <svg class="icon-sun" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg>
        <svg class="icon-moon" viewBox="0 0 24 24" aria-hidden="true"><path d="M21 12.79A9 9 0 1 1 11.21 3a7 7 0 0 0 9.79 9.79z"/></svg>
      </button>
    </div>
  </header>

  <main class="wrap">
    <nav class="toc" aria-label="On this page">
      <p class="toc-title">On this page</p>
      <ul id="toc"></ul>
    </nav>
    <div id="content" role="tabpanel" aria-live="polite">
      <div class="state">Loading...</div>
    </div>
  </main>


 <footer class="footer">
    Newphase Academy &copy; <span id="year">2026</span>, All Rights Reserved.
  </footer>

  <script src="/scripts/npa-legal.js?v=5"></script>
</body>
</html>
