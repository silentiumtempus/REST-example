<?php
declare(strict_types=1);

namespace App\Factory;

use App\Entity\TeamEntity;
use App\Entity\LeagueEntity;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class TeamFactory
 * @package App\Factory
 */
class TeamFactory
{
    private $em;

    /**
     * TeamFactory constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $name
     * @param string $strip
     * @param LeagueEntity $leagueEntity
     * @return TeamEntity
     */
    public function prepareNewTeamWithData(
        string $name = null,
        string $strip = null,
        LeagueEntity $leagueEntity = null
    ): TeamEntity
    {
        $team = new TeamEntity();
        $team
            ->setName($name)
            ->setStrip($strip)
            ->setLeague($leagueEntity);
        $this->em->persist($team);

        return $team;
    }

    /**
     * @param array $teamsData
     * @param $leagueEntity
     */
    public function createTeamsSetWithData(array $teamsData, $leagueEntity): void
    {
        foreach ($teamsData as $name => $strip) {
            $this->prepareNewTeamWithData($name, $strip, $leagueEntity);
        }
        $this->em->flush();
    }
}
