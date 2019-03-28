<?php
declare(strict_types=1);

namespace App\Tests\DataFixtures\ORM;

use App\DataFixtures\ORM\LoadLeagueDataFixture;
use App\DataFixtures\ORM\LoadTeamDataFixture;
use App\Factory\LeagueFactory;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class LoadLeagueDataFixtureTest extends WebTestCase
{
    /** @var EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $emMock;
    /** @var LeagueFactory|\PHPUnit_Framework_MockObject_MockObject */
    private $leagueFactoryMock;
    /** @var LoadLeagueDataFixture|\PHPUnit_Framework_MockObject_MockObject */
    private $loadLeagueDataFixtureMock;

    protected function setUp()
    {
        $this->emMock = $this->createMock(EntityManagerInterface::class);
        $this->leagueFactoryMock = new LeagueFactory($this->emMock);
        $this->loadLeagueDataFixtureMock = new LoadLeagueDataFixture($this->leagueFactoryMock);
    }

    /**
     * @test
     * @covers \App\DataFixtures\ORM\LoadLeagueDataFixture::getOrder
     */
    public function testGetOrder()
    {
        $loadLeagueDataFixture = new LoadLeagueDataFixture($this->leagueFactoryMock);
        $return = $loadLeagueDataFixture->getOrder();
        $this->assertInternalType('int', $return);
    }

    /**
     * @test
     * @covers \App\DataFixtures\ORM\LoadLeagueDataFixture::load
     * @param ObjectManager $objectManager
     * @dataProvider getLoadDataProvider
     */
    public function testLoad(ObjectManager $objectManager)
    {
       $this->loadFixtures([
            LoadTeamDataFixture::class
        ]);

        $this->loadLeagueDataFixtureMock->load($objectManager);
    }

    /**
     * @return ObjectManager|\PHPUnit_Framework_MockObject_MockObject
     */
    public function getLoadDataProvider()
    {
        return $this->createMock(ObjectManager::class);
    }
}
