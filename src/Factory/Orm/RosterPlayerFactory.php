<?php
namespace Phooty\Crawler\Factory\Orm;

use Phooty\Orm\Entities\RosterPlayer;

class RosterPlayerFactory extends BaseFactory
{
    public function build(array $data = [])
    {
        //dd($data);
        if (!isset($data['player'], $data['season'], $data['team'], $data['number'])) {
            throw new \LogicException("Invalid parameters!");
        }
        $rosterPlayer = new RosterPlayer();
        $rosterPlayer->setNumber($data['number']);
        $rosterPlayer->setPlayer($data['player']);
        $rosterPlayer->setSeason($data['season']);
        $rosterPlayer->setTeam($data['team']);
        return $rosterPlayer;
    }
}
