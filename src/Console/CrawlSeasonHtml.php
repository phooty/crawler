<?php
namespace Phooty\Crawler\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Phooty\Crawler\Client;
use Phooty\Crawler\Crawler\SeasonPlayerTotals;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Contracts\Container\Container;
use Doctrine\ORM\EntityManager;

class CrawlSeasonHtml extends Command
{
    /**
     * The container instance
     *
     * @var Container
     */
    private $container;

    /**
     * The EntityManager instance
     *
     * @var EntityManager
     */
    private $em;

    private $players_persisted = 0;

    private $teams_persisted = 0;
    
    private $roster_spots_persisted = 0;
    
    public function __construct(Container $container)
    {
        $this->container = $container;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('crawl:season:html')
            ->setDescription(
                'Crawl html data for a single season from a locally stored file.'
            )
            ->addArgument(
                'filename',
                InputArgument::REQUIRED,
                'Path to locally stored season html file'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('filename');

        if (!file_exists($fn = getcwd().'/'.$path)
            && !file_exists($fn = $fn.'.html')
        ) {
            $output->writeln('<error>Could not locate '.$path.'</error>');
            return;
        }

        $output->writeln('Located file...');
        $output->writeln('Reading content...');
        $html = file_get_contents($fn);

        
        $crawler = $this->container->make(SeasonPlayerTotals::class);
        $output->writeln('Crawling html...');
        $result = $crawler->crawl($html);
        $players = $result->players()->all();
        $this->em = $this->container->make(EntityManager::class);

        foreach ($players as &$player) {
            if (null === $player->getId()) {
                $player = $this->em->persist($player);
                $this->players_persisted++;
            }
        }
        foreach ($result->teams()->all() as &$team) {
            if (null === $team->getId()) {
                $team = $this->em->persist($team);
                $this->teams_persisted++;
            }
        }
        
        foreach ($result->rosters()->all() as &$rosterPlayer) {
            if (null === $rosterPlayer->getId()) {
                $rosterPlayer = $this->em->persist($rosterPlayer);
                $this->roster_spots_persisted++;
            }
        }
        $this->em->flush();
        $output->writeln("Stored {$this->players_persisted} new players.");
        $output->writeln("Stored {$this->teams_persisted} new teams.");
        $output->writeln("Stored {$this->roster_spots_persisted} new roster spots.");
    }

}
