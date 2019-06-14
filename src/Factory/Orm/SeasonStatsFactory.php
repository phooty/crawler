<?php
namespace Phooty\Crawler\Factory\Orm;

use Phooty\Orm\Entities\SeasonStats;

class SeasonStatsFactory extends BaseFactory
{
    /**
     * An array of valid keys for stats
     *
     * @var array
     */
    /* private static $valid = [
        'games',
        'kicks',
        'marks',
        'handballs',
        'disposals',
        //'average_disposals',
        'goals',
        'behinds',
        'hitouts',
        'tackles',
        'rebound_50',
        'inside_50',
        'clearances',
        'clangers',
        'frees_for',
        'frees_against',
        'brownlow_votes',
        'contested_possessions',
        'uncontested_possessions',
        'contested_marks',
        'marks_inside_50',
        'one_percenters',
        'bounces',
        'goal_assists',
        'time_on_ground',
    ]; */

    public function build(array $data = [])
    {
        $seasonStats = new SeasonStats();
        //dd($data);
        $seasonStats->setGames((int) $data['games']);
        $seasonStats->setKicks((int) $data['kicks']);
        $seasonStats->setMarks((int) $data['marks']);
        $seasonStats->setHandballs((int) $data['handballs']);
        $seasonStats->setDisposals((int) $data['disposals']);
        $seasonStats->setGoals((int) $data['goals']);
        $seasonStats->setBehinds((int) $data['behinds']);
        $seasonStats->setHitouts((int) $data['hitouts']);
        $seasonStats->setTackles((int) $data['tackles']);
        $seasonStats->setRebound50((int) $data['rebound_50']);
        $seasonStats->setInside50((int) $data['inside_50']);
        $seasonStats->setClearances((int) $data['clearances']);
        $seasonStats->setClangers((int) $data['clangers']);
        $seasonStats->setFreesFor((int) $data['frees_for']);
        $seasonStats->setFreesAgainst((int) $data['frees_against']);
        $seasonStats->setBrownlowVotes((int) $data['brownlow_votes']);
        $seasonStats->setContestedPossessions((int) $data['contested_possessions']);
        $seasonStats->setUncontestedPossessions((int) $data['uncontested_possessions']);
        $seasonStats->setContestedMarks((int) $data['contested_marks']);
        $seasonStats->setMarksInside50((int) $data['marks_inside_50']);
        $seasonStats->setOnePercenters((int) $data['one_percenters']);
        $seasonStats->setBounces((int) $data['bounces']);
        $seasonStats->setGoalAssists((int) $data['goal_assists']);
        $seasonStats->setTimeOnGround((float) $data['time_on_ground']);

        return $seasonStats;
    }
}
