<?php
namespace Phooty\Crawler;

use Illuminate\Support\Collection;

class Results
{
    /**
     * Player results
     *
     * @var Collection
     */
    protected $players;

    /**
     * Team results
     *
     * @var Collection
     */
    protected $teams;

    /**
     * Roster results
     *
     * @var Collection
     */
    protected $rosters;

    public function players(): Collection
    {
        isset($this->players) ?: $this->players = new Collection();
        return $this->players;
    }

    public function teams(): Collection
    {
        isset($this->teams) ?: $this->teams = new Collection();
        return $this->teams;
    }

    public function rosters(): Collection
    {
        isset($this->rosters) ?: $this->rosters = new Collection();
        return $this->rosters;
    }
}
