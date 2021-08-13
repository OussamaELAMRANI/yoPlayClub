<?php

namespace App\Http\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    #[Route('/app', name: 'app')]
    public function index(): Response
    {
        dump($this->container);

        return $this->render('base.html.twig');
    }

    #[Route('/ping', name: 'ping', methods: ['POST'])]
    public function ping(MessageBusInterface $bus): Response
    {
        $data = json_encode(['name' => 'Oussama']) ?: '';
        $update = new Update('https://example.com/ping', $data);
        $bus->dispatch($update);
        return $this->redirectToRoute('app');
    }
}
