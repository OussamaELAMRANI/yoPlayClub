<?php

namespace App\Test\ApiPlatform\Fixtures;

trait FixturesTrait
{
    public function createEntity(int $count, callable $factory, callable $persister, callable $flush)
    {
        for ($i = 0; $i < $count; ++$i) {
            $entity = $factory($i);

            if (null === $entity) {
                throw new \LogicException('Did you forget to return the entity object from your callback to BaseFixture::createMany()?');
            }

            $persister($entity);
        }
        $flush();
    }

    public function clearDatabase(): void
    {
        $this->loadFixturesTools()->loadFixtures([]);
    }
}
