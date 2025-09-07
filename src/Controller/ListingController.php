<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ListingController extends AbstractController
{
    #[Route(
        path:'/listings', 
        name: 'all_listingq',
        methods: 'GET')
    ]
    public function index(): Response
    {
        return $this->render('listings/index.html.twig', [
            'controller_name' => 'ListingController',
        ]);
    }
}
