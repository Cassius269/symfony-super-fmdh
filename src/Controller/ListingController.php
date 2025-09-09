<?php

namespace App\Controller;

use App\Entity\Agent;
use App\Entity\City;
use App\Entity\Listing;
use App\Entity\PropertyType;
use App\Entity\TransactionType;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ListingController extends AbstractController
{
    #[Route(
        path:'/listings', 
        name: 'listing_all',
        methods: 'GET')
    ]
    public function index(): Response
    {
        return $this->render('listings/index.html.twig', [
            'controller_name' => 'ListingController',
        ]);
    }

    #[Route(
        path:'/listing/create'
    )]
    public function show(EntityManagerInterface $em): Response
    {

        $propertyType = $em->getRepository(PropertyType::class)->findOneBy([
        'name' => 'maison'
            ]);

        $transactionType = $em->getRepository(TransactionType::class)->findOneBy([
        'name' => 'location'
            ]);
        
    $lyon = $em->getRepository(City::class)->findOneBy([
        'name' => 'Lyon'
    ]);

    $agent = $em->getRepository(Agent::class)->findOneBy([
        'email' => 'jean-dupont@email.com'
    ]);

     if(! $lyon){
        throw $this->createNotFoundException('La ville de Lyon n\'es pas enregistrée');
    }

    // Créer un nouvel objet annonce
    $listing = new Listing;
    $listing->setTitle('Charmant ppartement')
        ->setDescription('Se situe à Lyon à côté du centre de Lyon, à Perrache')
        ->setCity($lyon)
        ->setPrice(634.4)
        ->setPropertyType($propertyType)
        ->setTransactionType($transactionType)
        ->setAgent($agent)
        ->setImage('https://placehold.co/300x200/EEE/31343C')
         ->setCreatedAt(new DateTimeImmutable());

    // Persister et envoyer en base de données
    $em->persist($listing);
    $em->flush();

    return $this->redirectToRoute('home');
    }
}
