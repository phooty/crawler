<?php
namespace Phooty\Crawler\Factory;

use Phooty\Orm\Entities\Player;

class PlayerFactory extends BaseFactory
{
    public function build(array $data = [])
    {
        /* if (isset($data['player'])) {
            $name = explode(',', $data['player'], 2);
            $data['surname'] = $name[0];
            !isset($name[1]) ?: $data['given_names'] = $name[1];
        } */
        $player = new Player();
        $player->setGivenNames(trim($data['given_names']) ?? '');
        $player->setSurname(trim($data['surname']) ?? '');
        $player->setPriorPlayers($data['prior_players'] ?? 0);
        return $player;
    }
}
