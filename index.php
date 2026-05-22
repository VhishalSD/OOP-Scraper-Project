<?php

// Load the Scraper class and create a new scraper object.
require_once 'classes/Scraper.php';

$scraper = new Scraper();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KNMI Luchtvaart Weerdata</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Syne:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Reset default spacing and use border-box sizing for predictable layouts. */
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /* Store reusable colors and shadows in CSS variables. */
        :root {
            --bg:        #f0f2f5;
            --surface:   #ffffff;
            --border:    #dde1e8;
            --accent:    #1a56db;
            --accent-lt: #e8effe;
            --text-head: #0f172a;
            --text-body: #374151;
            --text-meta: #6b7280;
            --pre-bg:    #f8f9fb;
            --pre-border:#e2e6ed;
            --badge-bg:  #1a56db;
            --badge-txt: #ffffff;
            --shadow:    0 1px 3px rgba(0,0,0,.07), 0 4px 16px rgba(0,0,0,.06);
        }

        /* Main page layout. */
        body {
            font-family: 'Syne', sans-serif;
            background-color: var(--bg);
            color: var(--text-body);
            min-height: 100vh;
            padding: 2.5rem 1.5rem 4rem;
        }

        /* Header with title, source information and refresh action. */
        .site-header {
            max-width: 1200px;
            margin: 0 auto 2.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            border-bottom: 2px solid var(--border);
            padding-bottom: 1.25rem;
        }

        .header-icon {
            width: 42px;
            height: 42px;
            background: var(--accent);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .header-icon svg {
            width: 22px;
            height: 22px;
            fill: none;
            stroke: #fff;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .header-text h1 {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--text-head);
            letter-spacing: -.02em;
            line-height: 1.2;
        }

        .header-text p {
            font-size: .8rem;
            color: var(--text-meta);
            margin-top: .2rem;
            font-family: 'DM Mono', monospace;
        }

        /* Reloads the page so the scraper fetches fresh KNMI data. */
        .refresh-button {
            margin-left: auto;
            border: none;
            background: var(--accent);
            color: #ffffff;
            font-family: 'DM Mono', monospace;
            font-size: .72rem;
            font-weight: 500;
            padding: .65rem .9rem;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color .2s ease, transform .2s ease;
        }

        .refresh-button:hover {
            background: #1648b8;
            transform: translateY(-1px);
        }

        /* Responsive grid for the three weather information cards. */
        .cards-grid {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
        }

        @media (max-width: 900px) {
            .cards-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Card styling for each KNMI weather section. */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            box-shadow: var(--shadow);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            transition: box-shadow .2s ease, transform .2s ease;
        }

        .card:hover {
            box-shadow: 0 2px 6px rgba(0,0,0,.08), 0 8px 28px rgba(0,0,0,.1);
            transform: translateY(-2px);
        }

        .card-header {
            padding: 1.25rem 1.25rem 1.2rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: .75rem;
        }

        .card-badge {
            font-family: 'DM Mono', monospace;
            font-size: .65rem;
            font-weight: 500;
            letter-spacing: .08em;
            text-transform: uppercase;
            background: var(--badge-bg);
            color: var(--badge-txt);
            padding: .25rem .55rem;
            border-radius: 5px;
            flex-shrink: 0;
        }

        .card-badge.taf {
            background: #0e7490;
        }

        .card-badge.metar {
            background: #065f46;
        }

        .card-title {
            font-size: .95rem;
            font-weight: 600;
            color: var(--text-head);
            line-height: 1.3;
            flex: 1;
            min-width: 0;
            overflow-wrap: anywhere;
        }

        .card-body {
            padding: 1rem 1.25rem 1.25rem;
            flex: 1;
        }

        /* Keeps the scraped aviation weather text readable and scrollable. */
        .card-body pre {
            font-family: 'DM Mono', monospace;
            font-size: .72rem;
            line-height: 1.7;
            color: var(--text-body);
            background: var(--pre-bg);
            border: 1px solid var(--pre-border);
            border-radius: 8px;
            padding: .9rem 1rem;
            white-space: pre-wrap;
            word-break: break-word;
            overflow-x: auto;
            max-height: 540px;
            overflow-y: auto;
        }

        .card-body pre::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        .card-body pre::-webkit-scrollbar-track {
            background: transparent;
        }

        .card-body pre::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 10px;
        }

        /* Footer shows when the live data was last loaded. */
        .site-footer {
            max-width: 1200px;
            margin: 2.5rem auto 0;
            text-align: center;
            font-family: 'DM Mono', monospace;
            font-size: .72rem;
            color: var(--text-meta);
        }
    </style>
</head>
<body>
    <!-- Page header with project title and refresh button. -->
    <header class="site-header">
        <div class="header-icon">
            <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M22 16.5L12 2 2 16.5l10-3 10 3z"/>
                <path d="M12 2v19M5 20h14"/>
            </svg>
        </div>
        <div class="header-text">
            <h1>KNMI Luchtvaart Weerdata</h1>
            <p>Bron: knmi.nl &nbsp;·&nbsp; OOP Scraper Project</p>
        </div>

        <button class="refresh-button" type="button" onclick="window.location.reload();">
            Refresh data
        </button>
    </header>

    <!-- Main content with the three scraped KNMI sections. -->
    <main class="cards-grid">
        <article class="card">
            <div class="card-header">
                <span class="card-badge">bulletin</span>
                <h2 class="card-title">Algemeen Luchtvaartweer</h2>
            </div>
            <div class="card-body">
                <pre><?= htmlspecialchars($scraper->toonAlgemeenInfo()) ?></pre>
            </div>
        </article>

        <article class="card">
            <div class="card-header">
                <span class="card-badge taf">TAF</span>
                <h2 class="card-title">TAF Vliegveldverwachtingen</h2>
            </div>
            <div class="card-body">
                <pre><?= htmlspecialchars($scraper->toonTAFInfo()) ?></pre>
            </div>
        </article>

        <article class="card">
            <div class="card-header">
                <span class="card-badge metar">METAR</span>
                <h2 class="card-title">METAR Vliegveldwaarnemingen</h2>
            </div>
            <div class="card-body">
                <pre><?= htmlspecialchars($scraper->toonMetarInfo()) ?></pre>
            </div>
        </article>
    </main>

    <!-- Footer with the latest page load timestamp. -->
    <footer class="site-footer">
        <p>Laatst bijgewerkt: <?= date('d-m-Y H:i:s') ?> &nbsp;·&nbsp; Data live opgehaald via KNMI</p>
    </footer>
</body>
</html>