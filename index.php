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
    <link rel="stylesheet" href="css/style.css">
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

        <button class="refresh-button" type="button" id="refreshButton">
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

    <script src="js/script.js"></script>
</body>
</html>