<?php
declare(strict_types=1);

namespace App\Tests\DataFixtures\ORM;

use App\DataFixtures\ORM\LoadTeamDataFixture;
use App\Factory\TeamFactory;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Liip\FunctionalTestBundle\Test\WebTestCase;

class LoadTeamDataFixtureTest extends WebTestCase
{
    /** @var EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject */
    private $emMock;
    /** @var TeamFactory|\PHPUnit_Framework_MockObject_MockObject */
    private $teamFactoryMock;
    /** @var LoadTeamDataFixture|\PHPUnit_Framework_MockObject_MockObject */
    private $loadTeamDataFixtureMock;

    public function setUp()
    {
        $this->emMock = $this->createMock(EntityManagerInterface::class);
        $this->teamFactoryMock = new TeamFactory($this->emMock);
        $this->loadTeamDataFixtureMock = new LoadTeamDataFixture($this->teamFactoryMock);
    }

    /**
     * @test
     * @covers LoadTeamDataFixture::load
     * @param ObjectManager $objectManager
     * @dataProvider getLoadDataProvider
     */
    public function testLoad(ObjectManager $objectManager)
    {
        $this->
        $this->loadFixtures([
            LoadTeamDataFixture::class
        ]);

        $this->loadTeamDataFixtureMock->load($objectManager);
    }

    /**
     * @test
     * @covers LoadTeamDataFixture::getOrder
     */
    public function testGetOrder()
    {
        $loadLeagueDataFixture = new LoadTeamDataFixture($this->teamFactoryMock);
        $return = $loadLeagueDataFixture->getOrder();
        $this->assertInternalType('int', $return);
    }

    /**
     * @return ObjectManager|\PHPUnit_Framework_MockObject_MockObject
     */
    public function getLoadDataProvider()
    {
        return $this->createMock(ObjectManager::class);
    }
}
