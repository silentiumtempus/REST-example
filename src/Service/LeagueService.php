<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\LeagueEntity;
use App\Factory\LeagueFactory;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class LeagueService
 * @package App\Service
 */
class LeagueService
{
    private $em;
    private $leagueRepository;
    private $leagueFactory;

    /**
     * LeagueService constructor.
     * @param EntityManagerInterface $em
     * @param LeagueFactory $leagueFactory
     */
    public function __construct(
        EntityManagerInterface $em,
        LeagueFactory $leagueFactory
    ) {
        $this->em = $em;
        $this->leagueFactory = $leagueFactory;
        $this->leagueRepository = $this->em->getRepository(LeagueEntity::class);
    }

    /**
     * @param string $name
     * @return LeagueEntity
     */
    public function createLeagueByName(string $name): LeagueEntity
    {
        return $this->leagueFactory->prepareNewLeagueByName($name);
    }

    /**
     * @param LeagueEntity $leagueEntity
     */
    public function deleteLeague(LeagueEntity $leagueEntity): void
    {
        $this->em->remove($leagueEntity);
        $this->em->flush();
    }
}
