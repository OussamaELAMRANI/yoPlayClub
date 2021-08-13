<?php

namespace App\Tests\E2e\Controller;

use Symfony\Component\Panther\PantherTestCase;

class AppTest extends PantherTestCase
{

    public function testAppStart()
    {
        // Your app is automatically started using the built-in web server
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/app');
        $crawler->selectButton('Ping now')->click();

        $this->assertPageTitleContains('Welcome');
    }
}
