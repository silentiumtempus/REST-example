<?php
declare(strict_types=1);

namespace App\DataFixtures\ORM;

use App\Factory\LeagueFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

/**
 * Class LoadLeagueDataFixture
 * @package App\DataFixtures
 */
class LoadLeagueDataFixture extends Fixture implements OrderedFixtureInterface
{
    private $leagueFactory;
    private $defaultLeagueName;

    /**
     * LoadLeagueDataFixture constructor.
     * @param LeagueFactory $leagueFactory
     */
    public function __construct(LeagueFactory $leagueFactory)
    {
        $this->leagueFactory = $leagueFactory;
        $this->defaultLeagueName = 'UK Premier League';
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $leagueEntity = $this->leagueFactory->prepareNewLeagueByName($this->defaultLeagueName);

        $this->addReference('league', $leagueEntity);
    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return 1;
    }
}
