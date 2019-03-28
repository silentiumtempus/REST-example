<?php
declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\LeagueEntity;
use App\Entity\TeamEntity;
use App\Factory\LeagueFactory;
use App\Factory\TeamDeserializerFactory;
use App\Factory\TeamFactory;
use App\Factory\TeamSerializerFactory;
use App\Service\TeamService;
use Doctrine\ORM\EntityManagerInterface;
use Liip\FunctionalTestBundle\Test\WebTestCase;
use App\DataFixtures\ORM\LoadLeagueDataFixture;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class TeamServiceTest extends WebTestCase
{
    /** @var EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $emMock;
    /** @var TeamService|\PHPUnit_Framework_MockObject_MockObject */
    private $teamService;
    /** @var ContainerInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $containerMock;
    /** @var TeamFactory|\PHPUnit_Framework_MockObject_MockObject */
    private $teamFactoryMock;
    /** @var LeagueFactory|\PHPUnit_Framework_MockObject_MockObject */
    private $leagueFactoryMock;
    /** @var LoadLeagueDataFixture|\PHPUnit_Framework_MockObject_MockObject */
    private $loadLeagueDataFixtureMock;
    /** @var TeamSerializerFactory|\PHPUnit_Framework_MockObject_MockObject */
    private $teamSerializerFactoryMock;
    /** @var TeamDeserializerFactory|\PHPUnit_Framework_MockObject_MockObject */
    private $teamDeserializerFactoryMock;

    protected function setUp()
    {
        $this->emMock = $this->createMock(EntityManagerInterface::class);
        $this->containerMock = $this->createMock(ContainerInterface::class);
        $this->teamSerializerFactoryMock = $this->createMock(TeamSerializerFactory::class);
        $this->teamDeserializerFactoryMock = $this->createMock(TeamDeserializerFactory::class);
        $this->teamFactoryMock = new TeamFactory($this->emMock);
        $this->leagueFactoryMock = new LeagueFactory($this->emMock);
        $this->loadLeagueDataFixtureMock = new LoadLeagueDataFixture($this->leagueFactoryMock);
        $this->teamService = new TeamService(
            $this->emMock,
            $this->containerMock,
            $this->teamSerializerFactoryMock,
            $this->teamDeserializerFactoryMock,
            $this->teamFactoryMock
        );
    }

    /**
     * @test
     * @covers \App\Service\TeamService::createOneTeam
     * @param LeagueEntity $leagueEntity
     * @dataProvider getCreateOneTeamDataProvider
     */
    public function testCreateOneTeam(LeagueEntity $leagueEntity)
    {
        $request = new Request();
        $request->request->set('name', 'Test team');
        $request->request->set('strip', 'Test strip');

        $team = new TeamEntity();
        $team->setName('Test Team');

        $this->emMock
            ->expects($this->once())
            ->method('persist')
            ->with($team);

        $result = $this->teamService->createOneTeam($request->request, $leagueEntity);

        $this->assertEquals($team, $result);
    }

    /**
     * @test
     * @covers \App\Service\TeamService::updateOneTeam
     * @param TeamEntity $teamEntity
     * @dataProvider getUpdateOneTeamDataProvider
     */
    public function testUpdateOneTeam(TeamEntity $teamEntity)
    {
        $request = new Request();
        $request->request->set('id', 1);
        $request->request->set('name', 'Test team');
        $request->request->set('strip', 'Test strip');

        $teamEntity
            ->setName('Updated name')
            ->setStrip('Updated strip');

        $this->emMock
            ->expects($this->once())
            ->method('flush');

        $updatedTeam = $this->teamService->updateOneTeam($request, $teamEntity);

        $this->assertEquals($teamEntity, $updatedTeam);
    }

    /**
     * @return LeagueEntity
     */
    public function getCreateOneTeamDataProvider()
    {
        $league = new LeagueEntity();
        $league
            ->setId(1)
            ->setName('Test league');

        return $league;
    }

    /**
     * @return TeamEntity
     */
    public function getUpdateOneTeamDataProvider()
    {
        $team = new TeamEntity();
        $team
            ->setId(1)
            ->setName('Test team')
            ->setStrip('test strip');

        return $team;
    }

}
