<?php
namespace Phooty\Crawler\Factory\Orm;

use Phooty\Orm\Entities\Roster;

class RosterFactory extends BaseFactory
{
    public function build(array $data = [])
    {
        if (!isset($data['team'], $data['season'])) {
            throw new \LogicException(
                "Rosters require both a team and a season to be specified."
            );
        }
        $roster = new Roster($data['players'] ?? []);
        $roster->setTeam($data['team']);
        $roster->setSeason($data['season']);
        return $roster;
    }
}
