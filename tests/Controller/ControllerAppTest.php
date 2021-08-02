<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ControllerAppTest extends WebTestCase
{

    public function testGetGamesCollection(): void
    {
        $client = self::createClient();
        $client->request('GET', '/api/games', [
            'headers' => [
                'Content-Type' => 'application/ld+json',
                'Accept' => 'application/ld+json',
            ],
        ]);

        $this->assertResponseStatusCodeSame(200);
    }
}
