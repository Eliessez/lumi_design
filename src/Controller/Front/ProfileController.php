<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfileController extends AbstractController
{
    #[Route('/front/profile', name: 'front_profile')]
    public function index(): Response
    {
        return $this->render('front/profile/index.html.twig', [
            'controller_name' => 'ProfileController',
        ]);
    }
}
