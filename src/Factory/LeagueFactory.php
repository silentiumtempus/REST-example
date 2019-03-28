<?php
declare(strict_types=1);

namespace App\Factory;

use App\Entity\LeagueEntity;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class LeagueFactory
 * @package App\Factory
 */
class LeagueFactory
{
    private $em;

    /**
     * LeagueFactory constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $name
     * @return LeagueEntity
     */
    public function prepareNewLeagueByName(string $name): LeagueEntity
    {
        $league = new LeagueEntity();
        $league->setName($name);
        $this->em->persist($league);

        return $league;
    }
}
