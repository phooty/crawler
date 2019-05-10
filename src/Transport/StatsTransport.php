<?php
namespace Phooty\Crawler\Transport;

class StatsTransport extends BaseTransport
{
    protected $fields = [
        'games',
        'kicks',
        'marks',
        'handballs',
        'disposals',
        'average_disposals',
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
    ];
}
