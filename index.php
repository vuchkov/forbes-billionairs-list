<?php

require 'vendor/autoload.php';

use Symfony\Component\Panther\PantherTestCase;

class ForbesScraper extends PantherTestCase
{
    public function scrapeForbesBillionaires()
    {
        // Start the headless browser
        $client = self::createPantherClient();

        // Navigate to the Forbes Real-Time Billionaires page
        $crawler = $client->request('GET', 'https://www.forbes.com/real-time-billionaires/');

        // Wait for JavaScript content to load (adjust timeout if needed)
        $client->waitFor('.table__row', 10); // Adjust selector to target the billionaire rows

        // Extract data
        $rows = $crawler->filter('.table__row')->each(function ($row) {
            return [
                'rank' => $row->filter('.rank')->text(),
                'name' => $row->filter('.name')->text(),
                'net_worth' => $row->filter('.net-worth')->text(),
                'industry' => $row->filter('.industry')->text(),
            ];
        });

        // Print the extracted data
        print_r($rows);
    }
}

// Run the scraper
$scraper = new ForbesScraper();
$scraper->scrapeForbesBillionaires();
