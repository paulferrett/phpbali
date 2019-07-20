<?php

namespace App\Helper;

use Psr\Log\LoggerInterface;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;

class MeetupHelper
{
    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Example function to get the count for meetup attendees.
     *
     * NOTE this is not a good way to scrape the internet! If the HTML structure of this page changes,
     * this will break. It's just a simple example :)
     *
     * This method also doesn't have good error handling. There are a number of exceptions that could be thrown
     * that are not handled gracefully.
     */
    public function getNextMeetupParticipantCount(): int
    {
        $this->logger->info("Getting participant count from phpbali.com");

        $client = HttpClient::create();
        $fetch = $client->request('GET', 'https://phpbali.com', [
            'timeout' => 10,
        ]);

        $html = $fetch->getContent();

        $dom = new Crawler($html);
        $participants = $dom
            ->filterXPath('//h1[text()="PARTISIPAN"]')
            ->nextAll()
            ->getNode(1)->childNodes
            ->item(1)
            ->firstChild
            ->textContent;

        return (int)$participants;
    }
}
