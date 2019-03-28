<?php

namespace App\DataFixtures\ORM;

use App\Factory\TeamFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadTeamDataFixture extends Fixture implements OrderedFixtureInterface
{
    private $teamFactory;
    private $teams;

    /**
     * LoadTeamDataFixture constructor.
     * @param TeamFactory $teamFactory
     */
    public function __construct(TeamFactory $teamFactory)
    {
        $this->teamFactory = $teamFactory;
        $this->teams = [
            'Arsenal' => 'strip1',
            'Chelsea' => 'strip2',
            'Everton' => 'strip3',
            'Liverpool' => 'strip4',
            'Manchester United' => 'strip5',
            'Tottenham Hotspur' => 'strip6'
        ];
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $this->teamFactory->createTeamsSetWithData(
            $this->teams,
            $manager->merge($this->getReference('league'))
        );
    }

    /**
     * @return int
     */
    public function getOrder(): int
    {
        return 2;
    }

}