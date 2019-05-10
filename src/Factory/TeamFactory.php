<?php
namespace Phooty\Crawler\Factory;

use Phooty\Orm\Entities\Team;

class TeamFactory extends BaseFactory
{
    public function build(array $data = [])
    {
        $team = new Team();
        $team->setCity(trim($data['city']) ?? '');
        $team->setName(trim($data['name']) ?? '');
        $team->setShort(trim($data['short']) ?? '');
        return $team;
    }
}
