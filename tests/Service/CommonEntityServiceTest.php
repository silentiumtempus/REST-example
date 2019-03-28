<?php
declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\LeagueEntity;
use App\Service\CommonEntityService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class CommonEntityServiceTest extends TestCase
{
    /** @var EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $emMock;
    /** @var CommonEntityService|\PHPUnit_Framework_MockObject_MockObject */
    private $commonEntityServiceMock;

    protected function setUp()
    {
        $this->emMock = $this->createMock(EntityManagerInterface::class);
        $this->commonEntityServiceMock = new CommonEntityService($this->emMock);
    }

    /**
     * @test
     * @covers \App\Service\CommonEntityService::mergeSingleEntity
     */
    public function testMergeSingleEntity()
    {
        $league = new LeagueEntity();
        $league->setName('Test League');

        $this->emMock
            ->expects($this->once())
            ->method('flush');

        $this->commonEntityServiceMock->mergeSingleEntity();
    }

    /**
     * @test
     * @covers \App\Service\CommonEntityService::persistSingleEntity
     */
    public function testPersistSingleEntity()
    {
        $league = new LeagueEntity();
        $league->setName('Test League');

        $this->emMock
            ->expects($this->once())
            ->method('persist')
            ->with($league);

        $this->commonEntityServiceMock->persistSingleEntity($league);
    }
}
