<?php
namespace Phooty\Crawler\Crawler;

use Phooty\Crawler\Results;

interface Crawler
{
    public function crawl(string $html): Results;
}
