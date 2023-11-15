<?php

namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
class ApiController
{
    #[Route('/api', name: 'api')]
    public function index(): JsonResponse
    {
        $currencies = [
            ['name' => 'Dólar estadounidense', 'iso3' => 'USD'],
            ['name' => 'Euro', 'iso3' => 'EUR'],
            ['name' => 'Yen japonés', 'iso3' => 'JPY'],
        ];

        return new JsonResponse($currencies);
    }
}