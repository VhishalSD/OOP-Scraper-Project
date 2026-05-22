<?php

class Scraper
{
    // Store the KNMI URLs used by the scraper.
    private string $generalUrl;
    private string $tafUrl;
    private string $metarUrl;

    // Set the KNMI URLs when a new Scraper object is created.
    public function __construct()
    {
        $this->generalUrl = 'https://www.knmi.nl/nederland-nu/luchtvaart/weerbulletin-kleine-luchtvaart';
        $this->tafUrl = 'https://www.knmi.nl/nederland-nu/luchtvaart/vliegveldverwachtingen';
        $this->metarUrl = 'https://www.knmi.nl/nederland-nu/luchtvaart/vliegveldwaarnemingen';
    }

    // Fetch the HTML source from the given URL.
    private function getHtml(string $url): string
    {
        // Use a browser-like request so KNMI returns the normal public page content.
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'header' => "User-Agent: Mozilla/5.0\r\nAccept: text/html\r\n",
                'timeout' => 10,
            ],
        ]);

        $html = file_get_contents($url, false, $context);

        if ($html === false) {
            return 'Could not load data from KNMI.';
        }

        return $html;
    }

    // Extract the aviation weather text from the fetched HTML.
    private function getPreText(string $html): string
    {
        // First try to find real pre tags, as described in the assignment.
        if (preg_match('/<pre[^>]*>(.*?)<\/pre>/s', $html, $matches)) {
            return trim($matches[1]);
        }

        // KNMI can also show the aviation text as normal HTML content.
        // This fallback removes HTML tags and extracts the aviation text from the page.
        $plainText = html_entity_decode(strip_tags($html));
        $startPosition = strpos($plainText, 'ZCZC');

        if ($startPosition === false) {
            return 'No aviation weather text found.';
        }

        $aviationText = substr($plainText, $startPosition);
        $endMarkers = ['Pagina delen', 'Meer informatie', 'Volg ons op social media'];

        foreach ($endMarkers as $marker) {
            $endPosition = strpos($aviationText, $marker);

            if ($endPosition !== false) {
                $aviationText = substr($aviationText, 0, $endPosition);
                break;
            }
        }

        return trim($aviationText);
    }

    // Return the general aviation weather bulletin.
    public function toonAlgemeenInfo(): string
    {
        $html = $this->getHtml($this->generalUrl);

        return $this->getPreText($html);
    }

    // Return the TAF forecast information.
    public function toonTAFInfo(): string
    {
        $html = $this->getHtml($this->tafUrl);

        return $this->getPreText($html);
    }

    // Return the METAR current weather observations.
    public function toonMetarInfo(): string
    {
        $html = $this->getHtml($this->metarUrl);

        return $this->getPreText($html);
    }
}