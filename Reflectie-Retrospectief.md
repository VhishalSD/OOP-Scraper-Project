# Reflectie en Retrospectief

## Leerdoel

In dit project heb ik geleerd hoe ik een webscraper kan bouwen met PHP en OOP. De scraper haalt live luchtvaartweerdata van de KNMI-website en toont deze op een overzichtelijke manier. Ik heb geoefend met classes, methodes en het verwerken van HTML-gegevens.

## Retrospective / Reflectie

Tijdens dit project heb ik een kleine OOP-scraper gemaakt in PHP. Het doel was om een herbruikbare `Scraper` class te bouwen die luchtvaartweerdata van de KNMI-website ophaalt en toont op een webpagina.

### Wat ging goed?

Ik heb de projectstructuur netjes opgezet met `index.php` en een aparte `classes/Scraper.php`. De scraping-logica staat daardoor niet door de HTML heen, maar in een eigen class. Ook heb ik de drie onderdelen van de opdracht verwerkt: algemeen luchtvaartweer, TAF-informatie en METAR-informatie. De data wordt live opgehaald en overzichtelijk weergegeven in drie kaarten.

### Wat heb ik geleerd?

Ik heb beter geleerd hoe een class verantwoordelijkheden kan scheiden. `index.php` is verantwoordelijk voor de weergave, terwijl `Scraper.php` verantwoordelijk is voor het ophalen en verwerken van de data. Ook heb ik geleerd dat scraping afhankelijk is van de HTML-structuur van een externe website. Daarom heb ik foutafhandeling getest, zodat de pagina niet crasht wanneer data niet gevonden wordt.

### Verbinding met NAVLOG

Dit project sluit inhoudelijk aan op mijn NAVLOG-project, omdat beide projecten werken met luchtvaartinformatie zoals KNMI, TAF en METAR. Het verschil is dat NAVLOG een grotere applicatie is met vluchten, legs, berekeningen en databasegebruik, terwijl dit project bewust klein is gehouden. In dit project ligt de focus specifiek op één herbruikbare OOP `Scraper` class die externe luchtvaartdata ophaalt en verwerkt.

Door dit scraper-project heb ik beter begrepen hoe ik externe data apart kan ophalen en verwerken zonder de hoofdapplicatie te vervuilen. Die aanpak kan later ook nuttig zijn in grotere projecten zoals NAVLOG.

### Wat kon beter?

In het begin stond de data niet direct goed op de pagina, omdat de KNMI-tekst niet altijd als gewone `<pre>`-tag werd opgehaald. Dit heb ik opgelost door een fallback te maken die de luchtvaarttekst vanaf `ZCZC` uit de pagina haalt. Ook heb ik later de UI verbeterd met betere kaarttitels, een refresh-knop en een duidelijke laatst-bijgewerkt-tijd.

### Conclusie

Dit project is klein, maar laat goed zien dat ik OOP kan toepassen in PHP. Ik heb een herbruikbare `Scraper` class gemaakt, live data opgehaald van een externe bron, foutafhandeling getest en de output netjes weergegeven in een responsive webpagina.