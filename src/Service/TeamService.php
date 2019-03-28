<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\TeamEntity;
use App\Entity\LeagueEntity;
use App\Factory\TeamFactory;
use App\Factory\TeamSerializerFactory;
use Doctrine\ORM\EntityManagerInterface;
use App\Factory\TeamDeserializerFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

/**
 * Class TeamService
 * @package App\Service
 */
class TeamService
{
    private $em;
    private $container;
    private $teamRepository;
    private $teamFactory;
    private $teamSerializerFactory;
    private $teamDeserializerFactory;
    private $teamsPerPageLimit;

    /**
     * TeamService constructor.
     * @param EntityManagerInterface $em
     * @param ContainerInterface $container
     * @param TeamDeserializerFactory $teamDeserializerFactory
     * @param TeamSerializerFactory $teamSerializerFactory
     * @param TeamFactory $teamFactory
     */
    public function __construct
    (
        EntityManagerInterface $em,
        ContainerInterface $container,
        TeamSerializerFactory $teamSerializerFactory,
        TeamDeserializerFactory $teamDeserializerFactory,
        TeamFactory $teamFactory
    ) {
        $this->em = $em;
        $this->container = $container;
        $this->teamFactory = $teamFactory;
        $this->teamSerializerFactory = $teamSerializerFactory;
        $this->teamDeserializerFactory = $teamDeserializerFactory;
        $this->teamsPerPageLimit = $this->container->getParameter('teams.per.page.limit');
        $this->teamRepository = $this->em->getRepository(TeamEntity::class);
    }

    /**
     * @param ParameterBag $request
     * @param LeagueEntity $league
     * @return TeamEntity
     */
    public function createOneTeam(ParameterBag $request, LeagueEntity $league): ?TeamEntity
    {
        $newTeam = $this->teamFactory->prepareNewTeamWithData($request->get('name'), $request->get('strip'), $league);

        return $newTeam;
    }

    /**
     * @param LeagueEntity $leagueEntity
     * @param int $page
     * @return array
     * @throws ExceptionInterface
     */
    public function listTeamsByLeague(LeagueEntity $leagueEntity, int $page): ?array
    {
        $teams = $this->teamRepository->findAllByLeaguePaginated($leagueEntity, $page, $this->teamsPerPageLimit);
        $responseData = $this->teamSerializerFactory->serializeTeams($teams);

        return $responseData;
    }

    /**
     * @param Request $request
     * @param TeamEntity $teamEntity
     * @return mixed
     */
    public function updateOneTeam(Request $request, TeamEntity $teamEntity): ?TeamEntity
    {
        $objectToPopulate = $teamEntity ? ['object_to_populate' => $teamEntity] : null;
        $updatedTeam = $this->teamDeserializerFactory->deserializeTeam($request, $objectToPopulate);

        return $updatedTeam;
    }
}
