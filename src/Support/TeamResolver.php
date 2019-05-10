<?php
namespace Phooty\Crawler\Support;

class TeamResolver
{
    private $teams;

    private $aliases;

    public function __construct(array $teams, array $aliases)
    {
        $this->teams = $teams;
        $this->aliases = $aliases;
    }

    /**
     * Resolve a team.
     * 
     * Returns false if no team is resolved.
     *
     * @param string $team
     * @return array|bool
     */
    public function resolve(string $team)
    {
        switch ($team) {
            case isset($this->teams[strtoupper($team)]):
                $team = $this->teams[strtoupper($team)];
                break;
            case (isset($this->historical)
                && isset($this->historical[strtoupper($team)])
            ):
                $team = $this->historical[strtoupper($team)];
                break;
            case isset($this->aliases[strtolower($team)]):
                $team = $this->resolve($this->aliases[strtolower($team)]);
                break;
            default:
                $team = false;
        }
        return $team;
    }
}
