<?php

namespace App\Tests\repository;

use App\DataFixtures\GameFixtures;
use App\Domain\Game\Repository\GameRepository;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class GameRepositoryTest extends KernelTestCase
{
    private AbstractDatabaseTool $databaseTool;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        /** @var DatabaseToolCollection */
        $databaseTool = self::getContainer()->get(DatabaseToolCollection::class);
        $this->databaseTool = $databaseTool->get();
    }

    public function testTenGames(): void
    {
        $this->databaseTool->loadFixtures([GameFixtures::class]);

        /** @var GameRepository */
        $games = self::getContainer()->get(GameRepository::class);
        $this->assertEquals(10, $games->count([]));
    }
}
