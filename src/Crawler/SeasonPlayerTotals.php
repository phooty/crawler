<?php
namespace Phooty\Crawler\Crawler;

use Symfony\Component\DomCrawler\Crawler;
use Illuminate\Contracts\Container\Container;
use Phooty\Crawler\Mappings\PlayerSeasonTotals;
use Phooty\Crawler\Support\CrawlerUtils;
use Phooty\Crawler\Support\TeamResolver;
use Phooty\Crawler\Mappings\Mapping;
use Phooty\Crawler\Support\MappingUtils;
use Phooty\Crawler\Results;
use Phooty\Crawler\Processor\Node\TeamFromTableHeading;
use Phooty\Crawler\Processor\Node\GetPriorPlayers;
use Phooty\Crawler\Support\OrmUtil;
use Phooty\Orm\Entities\Team;
use Phooty\Orm\Entities\Player;
use Phooty\Orm\Entities\RosterPlayer;

/**
 * Crawls the HTML from a Season totals page from afltables.com
 * 
 * @todo Split methods/tidy up - too much here
 */
class SeasonPlayerTotals extends BaseCrawler
{
    /**
     * Resolver for Team names/locations
     *
     * @var TeamResolver
     */
    private $teamResolver;

    private $team = false;

    private $season;

    private $orm;

    public function __construct(Container $container, Mapping $mapping = null)
    {
        parent::__construct($container, $mapping ?? new PlayerSeasonTotals);
        $this->orm = $this->container->make(OrmUtil::class);
    }

    /**
     * @inheritDoc
     */
    public function crawl(string $html): Results
    {
        $crawler = new Crawler($html);
        if (!isset($this->season)) {
            $this->season = CrawlerUtils::getSeasonFromTitle($crawler);
        }
        $filter = $crawler->filter('table');
        
        foreach ($filter as $el) {
            if ($el->childNodes->count() > 2) {
                $this->crawlNodes($el->childNodes); 
            }
        }
        return $this->result();
    }

    /**
     * Crawls through nodes and attempts to pass data to the appropiate
     * handlers.
     * 
     * Nodes are expected to be table rows.
     *
     * @param \DomNodeList $nodes
     * @return void
     */
    protected function crawlNodes(\DOMNodeList $nodes)
    {
        foreach ($nodes as $node) {
            if (($children = $node->childNodes)->count() > 2
                && false !== $this->team
            ) {
                
                $this->processPlayerData($children);

            } elseif(TeamFromTableHeading::isValid($node)) {
                
                $team = $this->resolveTeam(
                    $this->processor(
                        TeamFromTableHeading::class
                    )->process($node)
                );
                $this->team = $team;
                $this->result()->teams()->add($team);
                
            }
        }
    }

    protected function processPlayerData(\DOMNodeList $nodes)
    {
        foreach ($nodes as $child) {
            $data = MappingUtils::mapNode($child, $this->mappings);
            if (!isset($data['player'])) {
                break;
            }
            $player = [];
            $name = explode(',', $data['player'], 2);
            $player['surname'] = trim($name[0]);
            !isset($name[1]) ?: $player['given_names'] = trim($name[1]);
            $player['prior_players'] = $this->processor(
                GetPriorPlayers::class
            )->process($child);
            $model = $this->resolvePlayer($player);
            
            $this->result()->players()->add($model);
            $this->result()->rosters()->add($this->resolveRosterPlayer($model));
        }
    }

    private function resolveTeam(array $data)
    {
        return $this->orm->find(Team::class, $data, function (array $data) {
            return $this->factory('team')->build($data);;
        });
    }

    private function resolvePlayer(array $data)
    {
        return $this->orm->find(Player::class, $data, function (array $data) {
            return $this->factory('player')->build($data);
        });
    }

    private function resolveRosterPlayer(Player $player)
    {
        $data = [
            'player' => $player,
            'team' => $this->team,
            'season' => $this->season
        ];
        return $this->orm->find(
            RosterPlayer::class,
            $data,
            function (array $data) {
                return $this->factory('roster.player')->build($data);
            }
        );
    }

    protected function orm()
    {
        return $this->orm;
    }
}
