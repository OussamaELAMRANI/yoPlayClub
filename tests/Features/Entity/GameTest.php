<?php

namespace App\Tests\Features\Entity;

use App\Domain\Game\Entity\Game;
use App\Test\ApiPlatform\Fixtures\FixturesTrait;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class GameTest extends KernelTestCase
{
    use FixturesTrait;

    private Generator $faker;
    private ObjectManager $manager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Factory::create();
        self::bootKernel();

        /** @var ManagerRegistry doctrine */
        $doctrine = self::getContainer()->get('doctrine');
        $this->manager = $doctrine->getManager();
        $this->clearDatabase();
    }

    public function loadFixturesTools(): AbstractDatabaseTool
    {
        /** @var DatabaseToolCollection */
        $databaseTool = self::getContainer()->get(DatabaseToolCollection::class);

        return $databaseTool->get();
    }

    public function assertValidationErrors(Game $game, int $errorsCount): void
    {
        /** @var ValidatorInterface validator */
        $validator = self::getContainer()->get(ValidatorInterface::class);
        $errors = $validator->validate($game);

        $messages = [];
        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }

        $this->assertCount($errorsCount, $errors, implode('', $messages));
    }

    public function getEntity(): Game
    {
        return (new Game())
            ->setName($this->faker->name)
            ->setLogoPath($this->faker->imageUrl());
    }

    public function testValidateGame(): void
    {
        $game = $this->getEntity();
        $this->assertValidationErrors($game, 0);
    }

    public function testInvalidGame(): void
    {
        $game = $this->getEntity()->setLogoPath('test-path');
        $this->assertValidationErrors($game, 1);
    }

    public function testUniqueGameName(): void
    {
        $duplicatedGame = $this->getEntity()->setName('basketball');
        $this->createEntity(2,
            fn($i) => clone $duplicatedGame,
            fn($entity) => $this->manager->persist($entity),
            fn() => $this->manager->flush()
        );

        $this->assertValidationErrors($duplicatedGame, 1);
    }
}
