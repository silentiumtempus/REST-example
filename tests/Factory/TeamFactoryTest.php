<?php
declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\LeagueEntity;
use App\Entity\TeamEntity;
use App\Factory\TeamFactory;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class TeamFactoryTest extends TestCase
{
    /** @var EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $emMock;
    /** @var TeamFactory|\PHPUnit_Framework_MockObject_MockObject */
    private $teamFactoryMock;

    protected function setUp()
    {
        $this->emMock = $this->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->teamFactoryMock = new TeamFactory(
            $this->emMock
        );
    }

    /**
     * @test
     * @covers \App\Factory\TeamFactory::prepareNewTeamWithData
     * @param LeagueEntity $leagueEntity
     * @dataProvider getPrepareNewTeamWithDataDataProvider
     */
    public function testPrepareNewTeamWithData(LeagueEntity $leagueEntity)
    {
        $newTeam = new TeamEntity();
        $newTeam
            ->setName('Test team')
            ->setStrip('Test strip')
            ->setLeague($leagueEntity);

        $this->emMock
            ->expects($this->once())
            ->method('persist')
            ->with($newTeam);

        $result = $this->teamFactoryMock->prepareNewTeamWithData('Test team', 'Test strip', $leagueEntity);

        $this->assertEquals($newTeam, $result);

    }

    /**
     * @test
     * @covers \App\Factory\TeamFactory::createTeamsSetWithData
     * @param array $teams
     * @param LeagueEntity $leagueEntity
     * @dataProvider getCreateTeamsSetWithData
     */
    public function testCreateTeamsSetWithData(array $teams, LeagueEntity $leagueEntity)
    {
        $this->emMock
            ->expects($this->once())
            ->method('flush');

         $this->teamFactoryMock->createTeamsSetWithData($teams, $leagueEntity);
    }

    /**
     * @return LeagueEntity
     */
    public function getPrepareNewTeamWithDataDataProvider()
    {
        $league = new LeagueEntity();
        $league
            ->setId(1)
            ->setName('Test league');

        return $league;
    }

    /**
     * @return array
     */
    public function getCreateTeamsSetWithData()
    {
        $league = new LeagueEntity();
        $league
            ->setId(1)
            ->setName('Test league');

        $teams = [
            'Arsenal' => 'test strip1',
            'Chelsea' => 'test strip2',
            'Everton' => 'test strip3',
            'Liverpool' => 'test strip4',
            'Manchester United' => 'test strip5',
            'Tottenham Hotspur' => 'test strip6'
        ];

        return [
            [$teams, $league]
        ];
    }

}
