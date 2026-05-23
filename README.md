# KNMI Luchtvaart Weerdata

Dit project is een kleine PHP OOP-webapplicatie die live weerinformatie voor de luchtvaart ophaalt van de KNMI-website.

De focus van dit project ligt op het maken van een herbruikbare `Scraper` class. De scraping-logica staat apart in `classes/Scraper.php`, zodat `index.php` schoon blijft en de class later ook in andere projecten gebruikt kan worden.

## Functies

- Algemeen luchtvaartweer ophalen
- TAF-informatie ophalen: vliegveldverwachtingen
- METAR-informatie ophalen: actuele vliegveldwaarnemingen
- Data live ophalen vanaf de KNMI-website
- Output tonen in drie overzichtelijke kaarten
- Responsive layout voor desktop en mobiel
- Refresh-knop om de live data opnieuw op te halen

## Technologie

- PHP
- Object Oriented Programming
- `file_get_contents()`
- HTML
- CSS
- JavaScript
- Geen frameworks

## Bestandsstructuur

```text
OOP-Scraper-Project/
├── index.php
├── README.md
├── Reflectie-Retrospectief.md
├── classes/
│   └── Scraper.php
├── css/
│   └── style.css
├── js/
│   └── script.js
└── screenshots/
    ├── 01-Trello.png
    ├── 02-Homepage.png
    ├── 03-Refresh.png
    ├── 04-Foutafhandeling.png
    ├── 05-Responsive.png
    ├── 06-Code-Scraper-Setup.png
    └── 07-Code-Scraper-Methods.png
```

De bestandsstructuur laat alleen echte bestanden en mappen zien. De methodes staan niet in de structuur, omdat methodes onderdeel zijn van de class in `Scraper.php`.

## Belangrijke bestanden

### `index.php`

Dit is de hoofdpagina van het project. Hier wordt de `Scraper` class ingeladen, wordt een object aangemaakt en worden de publieke methodes aangeroepen.

### `classes/Scraper.php`

Dit bestand bevat de scraping-logica. De class haalt de KNMI-pagina's op, zoekt de luchtvaartinformatie en geeft deze terug als tekst.

### `css/style.css`

Dit bestand bevat alle styling van de webpagina. Hierdoor blijft de styling gescheiden van de HTML en PHP in `index.php`.

### `js/script.js`

Dit bestand bevat de JavaScript voor de refresh-knop. De knop herlaadt de pagina, zodat de KNMI-data opnieuw live wordt opgehaald.

### `Reflectie-Retrospectief.md`

Dit bestand bevat mijn persoonlijke reflectie op het project. Hierin beschrijf ik wat goed ging, wat ik heb geleerd, wat beter kon en hoe dit project aansluit op mijn NAVLOG-project.

### `screenshots/`

Deze map bevat bewijsafbeeldingen van de planning, werkende applicatie, refresh-knop, foutafhandeling, responsive layout en code.

## Belangrijke methodes in `Scraper.php`

De `Scraper` class bevat drie publieke methodes die vanuit `index.php` worden gebruikt:

```php
toonAlgemeenInfo()
toonTAFInfo()
toonMetarInfo()
```

### `toonAlgemeenInfo()`

Haalt het algemene luchtvaartweer op.

### `toonTAFInfo()`

Haalt de TAF-informatie op. Dit zijn de vliegveldverwachtingen.

### `toonMetarInfo()`

Haalt de METAR-informatie op. Dit zijn de actuele vliegveldwaarnemingen.

## Hoe het werkt

De `Scraper` class bevat drie vaste KNMI-links:

- Weerbulletin luchtvaart
- Vliegveldverwachtingen / TAF
- Vliegveldwaarnemingen / METAR

Per onderdeel haalt de class de HTML van de KNMI-pagina op. Daarna wordt de relevante luchtvaarttekst uit de pagina gehaald en teruggegeven aan `index.php`.

In `index.php` wordt deze tekst veilig weergegeven met:

```php
htmlspecialchars()
```

Hierdoor wordt de opgehaalde tekst netjes en veilig in de browser getoond.

De refresh-knop staat in `index.php`, maar de JavaScript-logica staat apart in `js/script.js`.

```javascript
window.location.reload();
```

Hiermee wordt de pagina opnieuw geladen en wordt de KNMI-data opnieuw live opgehaald.

## Installatie

1. Plaats het project in de `htdocs` map van XAMPP:

```text
/Applications/XAMPP/xamppfiles/htdocs/OOP-Scraper-Project
```

2. Start Apache via XAMPP.

3. Open het project in de browser:

```text
http://localhost/OOP-Scraper-Project
```

4. Controleer of de drie onderdelen zichtbaar zijn:

- Algemeen Luchtvaartweer
- TAF Vliegveldverwachtingen
- METAR Vliegveldwaarnemingen

## Opmerkingen

Dit project is afhankelijk van de HTML-structuur van de KNMI-website. Als KNMI de pagina's aanpast, kan de scraper aangepast moeten worden.

Er is geen caching toegevoegd. De data wordt telkens live opgehaald wanneer de pagina wordt geladen of wanneer de refresh-knop wordt gebruikt.

## Leerdoel

Met dit project laat ik zien dat ik een kleine herbruikbare OOP-class kan maken die externe webpagina's uitleest, informatie verwerkt en de output netjes toont in een webpagina.