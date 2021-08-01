<?php

namespace App\DataFixtures;

use App\Domain\Game\Entity\Game;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class GameFixtures extends Fixture
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; ++$i) {
            $game = new Game();
            $game->setName($this->faker->colorName)->setLogoPath($this->faker->imageUrl());
            $manager->persist($game);
        }

        $manager->flush();
    }
}
