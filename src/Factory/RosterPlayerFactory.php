<?php
namespace Phooty\Crawler\Factory;

use Phooty\Orm\Entities\RosterPlayer;

class RosterPlayerFactory extends BaseFactory
{
    public function build(array $data = [])
    {
        if (!isset($data['player'], $data['season'], $data['team'])) {
            throw new \LogicException("Invalid parameters!");
        }
        $rosterPlayer = new RosterPlayer();
        $rosterPlayer->setPlayer($data['player']);
        $rosterPlayer->setSeason($data['season']);
        $rosterPlayer->setTeam($data['team']);
        return $rosterPlayer;
    }
}
