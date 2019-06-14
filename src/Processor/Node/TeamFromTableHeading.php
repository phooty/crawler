<?php
namespace Phooty\Crawler\Processor\Node;

use Phooty\Support\TeamResolver;

class TeamFromTableHeading implements NodeProcessor
{
    protected const TEAM_HEADING = "/(\[Game by Game\]\#PlayerGMKIMKHBDIDAGLBHHOTKRBIFCLCGFFFABRCPUPCMMI1\%BOGA\%PSU)$/";

    protected $teamResolver;

    public function __construct(TeamResolver $teamResolver)
    {
        $this->teamResolver = $teamResolver;
    }

    /**
     * Process DOMNode
     *
     * @param \DOMNode $node
     * @return mixed
     */
    public function process(\DOMNode $node)
    {
        $team = trim(preg_replace(static::TEAM_HEADING, '', $node->textContent)
        );
        $teamData = $this->teamResolver->resolve($team);
        if (!$teamData) {
            throw new \LogicException('Invalid team: '.$team);
        }
        return $teamData;
    }

    public static function isValid(\DOMNode $node)
    {
        return preg_match(static::TEAM_HEADING, $node->textContent);
    }
}
