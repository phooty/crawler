<?php
namespace Phooty\Crawler\Factory\Orm;

use Phooty\Orm\Entities\Player;

class PlayerFactory extends BaseFactory
{
    public function build(array $data = [])
    {
        $player = new Player();
        $player->setGivenNames(trim($data['given_names']) ?? '');
        $player->setSurname(trim($data['surname']) ?? '');
        $player->setPriorPlayers($data['prior_players'] ?? 0);
        return $player;
    }
}
