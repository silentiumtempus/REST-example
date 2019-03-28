<?php
declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\LeagueEntity;
use App\Factory\LeagueFactory;
use App\Service\LeagueService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;

class LeagueServiceTest extends TestCase
{
    /** @var EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $emMock;
    /** @var LeagueService|\PHPUnit_Framework_MockObject_MockObject */
    private $leagueService;
    /** @var LeagueFactory|\PHPUnit_Framework_MockObject_MockObject */
    private $leagueFactoryMock;
    /** @var EntityRepository|\PHPUnit_Framework_MockObject_MockObject */
    private $leagueRepositoryMock;

    protected function setUp()
    {
        $this->emMock = $this->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->leagueRepositoryMock = $this->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->leagueFactoryMock = new LeagueFactory($this->emMock);
        $this->leagueService = new LeagueService($this->emMock, $this->leagueFactoryMock);
    }

    /**
     * @test
     * @covers \App\Service\LeagueService::createLeagueByName
     */
    public function testCreateLeagueByName()
    {
        $league = new LeagueEntity();
        $league->setName('Test League');

        $this->emMock
            ->expects($this->once())
            ->method('persist')
            ->with($league);

        $result = $this->leagueService->createLeagueByName('Test League');

        $this->assertEquals($league, $result);
    }

    /**
     * @param LeagueEntity $leagueEntity
     * @test
     * @covers \App\Service\LeagueService::deleteLeague
     * @dataProvider getDeleteOneLeagueDataProvider
     */
    public function testDeleteLeague(LeagueEntity $leagueEntity)
    {
        $this->leagueRepositoryMock
            ->expects($this->once())
            ->method('find')
            ->with($leagueEntity)
            ->willReturn(true);

        $this->leagueService->deleteLeague($leagueEntity);
    }

    /**
     * @return LeagueEntity
     */
    public function getDeleteOneLeagueDataProvider()
    {
        $league = new LeagueEntity();
        $league
            ->setId(1)
            ->setName('Test league');

        return $league;
    }
}
