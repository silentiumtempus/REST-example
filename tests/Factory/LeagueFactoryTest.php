<?php
declare(strict_types=1);

namespace App\Tests\Factory;

use App\Entity\LeagueEntity;
use App\Factory\LeagueFactory;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use PHPUnit\Framework\TestCase;

class LeagueFactoryTest extends TestCase
{
    /** @var EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $emMock;
    /** @var EntityRepository|\PHPUnit_Framework_MockObject_MockObject */
    private $leagueRepositoryMock;
    /** @var LeagueFactory|\PHPUnit_Framework_MockObject_MockObject */
    private $leagueFactoryMock;

    protected function setUp()
    {
        $this->emMock = $this->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->leagueRepositoryMock = $this->getMockBuilder(EntityRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->leagueFactoryMock = new LeagueFactory(
            $this->emMock
        );
    }

    /**
     * @test
     * @covers \App\Factory\LeagueFactory::prepareNewLeagueByName
     */
    public function testPrepareNewLeagueByName()
    {
        $league = new LeagueEntity();
        $league->setName('Test League');

        $this->emMock
            ->expects($this->once())
            ->method('persist')
            ->with($league);

        $result = $this->leagueFactoryMock->prepareNewLeagueByName('Test League');

        $this->assertEquals($league, $result);
    }
}
