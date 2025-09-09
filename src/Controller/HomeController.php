<?php

namespace App\Controller;

use App\Repository\ListingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route(
        path:'/', 
        name: 'home',
        methods:'GET')
    ]
    public function index(ListingRepository $listingRepository): Response
    {

        $houses = $listingRepository->findByPropertyType('maison');
        // dd($houses);

        $appartments =  $listingRepository->findByPropertyType('appartement');
        // dd($appartments);

        if(!$appartments){
            $this->createNotFoundException('Aucune annonce immobilière trouvée');
        }
        
        if(!$houses){
            $this->createNotFoundException('Aucune annonce immobilière trouvée');
        }


        // dd($listings);
        return $this->render('home/index.html.twig', [
           'houses' => $houses,
           'appartments' => $appartments
        ]);
    }
}
