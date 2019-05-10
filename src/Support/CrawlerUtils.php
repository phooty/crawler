<?php
namespace Phooty\Crawler\Support;

use Symfony\Component\DomCrawler\Crawler;

class CrawlerUtils
{
    public static function getSeasonFromTitle(Crawler $crawler)
    {
        $title = $crawler->filter('title')->first()->text();
        return (int) preg_replace('/\D/', '', $title);
    }
}
