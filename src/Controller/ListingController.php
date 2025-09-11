<?php

namespace App\Controller;

use App\Entity\Listing;
use App\Form\ListingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

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


    // Action pour créer une nouvelle annonce immobilière
    #[Route(
        path: '/listings/create-new-listing',
        name: 'listings_create_new',
        methods:['GET', 'POST']
    )]
    #[IsGranted('ROLE_AGENT')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response {
        // Création d'un nouvel objet annonce
        $listing = new Listing;

        // Création du formulaire et liaison avec l'objet à hydrater
        $form = $this->createForm(ListingType::class, $listing);
        
        // Recueillir la requête 
        $form->handleRequest($request);

        // Vérifier si le formulaire a été soumis et est valide
        if($form->isSubmitted() && $form->isValid()){
            // dd($listing);
            // S'il n'y pas de traitement particulier à faire, compléter les informations de l'objet déjà hydraté (remplir) $listing
            $listing->setAgent($this->getUser())
                    ->setCreatedAt(new \DateTimeImmutable());
        
            // Persister et envoyer en base de donnée
            $entityManager->persist($listing);
            $entityManager->flush();

            // Envoyer un message flash avant redirection de l'utilisateur
            $this->addFlash('success', 'Votre annonce a été créée avec succès');
            return $this->redirectToRoute('home'); // rediriger à la page d'accueil
        }

        // Afficher le formulaire
        return $this->render('listings/create_listing.html.twig', [
            'form' => $form
        ]);
        // dd('hello world');
    }

    // Action pour afficher une seule anonce immobilière en détail
    #[Route(
        path:'/listings/{id}',
        name: 'listings_show_detailed_listing',
        methods: 'GET'
    )]
    public function show(#[MapEntity(id:'id')] ?Listing $listing): Response
    {
        dd($listing);
    }

    // Action pour mettre à jour une anonce immobilière 
    public function update(): Response
    {

    }


    // Action pour mettre à jour une anonce immobilière 
    #[Route(
            path: '/listings/delete/{id}',
            name: 'listings_delete_listing_by_id'
        )]
    public function delete(
        EntityManagerInterface $entityManager,
        #[MapEntity(id: 'id')] ?Listing $listing
    ): Response
    {
        // dd($listing);
        if(!$listing){
            throw $this->createNotFoundException('Annonce à supprimer inexistante');
        }

        // Supprimer de la base de donnée
        $entityManager->remove($listing);
        $entityManager->flush();

        // Envoyer un message flash de succès avant de faire une redirection d'URL
        $this->addFlash('success', 'Annoncée supprimée avec succès');
        return $this->redirectToRoute('home'); // rediriger l'utilisateur à la page d'accueil
    }
}
