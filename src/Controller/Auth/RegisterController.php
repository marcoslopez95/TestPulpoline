<?php

namespace App\Controller\Auth;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    #[Route('/auth/register', name: 'app_auth_register')]
    public function index(): Response
    {
        return $this->render('auth/register/index.html.twig', [
            'controller_name' => 'RegisterController',
        ]);
    }
}
