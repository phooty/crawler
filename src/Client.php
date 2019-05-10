<?php
namespace Phooty\Crawler;

use GuzzleHttp\Client as GuzzleClient;

class Client extends GuzzleClient
{
    public const BASE_URI = 'https://afltables.com/afl/';

    public function getSeason(int $season)
    {
        // validate season
        return $this->request(
            'GET',
            static::BASE_URI . 'stats/' . $season . '.html'
        );
    }

    public function getMatches(int $season)
    {
        // validate season
        return $this->request(
            'GET',
            static::BASE_URI . 'seas/' . $season . '.html'
        );
    }

    public function getPlayer(string $name)
    {
        $a = substr($name, 0, 1);
        return $this->request(
            'GET',
            static::BASE_URI . 'stats/players/' . $a . '/' . $name . '.html'
        );
    }
}
