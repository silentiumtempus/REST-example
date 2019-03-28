<?php
declare(strict_types=1);

namespace App\Repository;

use App\Entity\LeagueEntity;
use Doctrine\ORM\EntityRepository;

/**
 * Class TeamRepository
 * @package App\Repository
 */
class TeamRepository extends EntityRepository
{
    /**
     * @param LeagueEntity $league
     * @param int $page
     * @param int $teamsPerPageLimit
     * @return mixed
     */
    public function findAllByLeaguePaginated(LeagueEntity $league, int $page, int $teamsPerPageLimit = 10): ?array
    {
        $qb = $this->createQueryBuilder('team');
        $qb
            ->innerJoin('team.league', 'league')
            ->where('league.id = :league_id')
            ->setParameter('league_id', $league->getId())
            ->setFirstResult($page * $teamsPerPageLimit)
            ->setMaxResults($teamsPerPageLimit);

        return $qb->getQuery()->getResult();
    }
}
