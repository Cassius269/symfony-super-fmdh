<?php

namespace App\Controller;

use App\Entity\Agent;
use App\Entity\Client;
use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class SecurityController extends AbstractController
{
    #[Route(
        path:'/register',
        name: 'register'
    )]
    public function register(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $passwordHasher): Response
    {
        // Créer un nouvel objet vide User
        $user = new User;

        // Préparer le formulaire
        $form=$this->createForm(UserType::class, $user);

        // Recueillir la requête 
        $form->handleRequest($request);
        // dd($request);

        // Vérifier la soumission du formulaire et les donneés soumises       
         if($form->isSubmitted() && $form->isValid()){
            // dd($form->getData());

            // S'il n'y pas de gros traitement à faire, l'objet User prend le contenu du formulaire
            $firstname = $form->get('firstname')->getData();
            $lastname = $form->get('lastname')->getData();
            $email = $form->get('email')->getData();
            $plainPassword = $form->get('password')->getData();

            // Personnalisation des données entrantes
            $typeUser = $form['typeUser']->getData();

            if($typeUser == 'agent'){
                $agent = new Agent;
                $agent->setFirstname($firstname)
                     ->setLastname($lastname)  
                     ->setEmail($email)         
                      ->setRoles(['ROLE_AGENT'])
                      ->setIsAccepted(false) // mettre en attente d'abord
                    ->setPassword($passwordHasher->hashPassword($agent, $plainPassword)) // hasher le mot de passe avant de l'insérer en base de données
                    ->setCreatedAt(new \DateTimeImmutable());

                $em->persist($agent);
            }else if($typeUser == 'client'){
                $client = new Client;
                $client->setFirstname($firstname)
                     ->setLastname($lastname)    
                     ->setEmail($email)         
                    ->setRoles(['ROLE_CLIENT'])
                    ->setIsAccepted(true)
                    ->setPassword($passwordHasher->hashPassword($client,$plainPassword)) // hasher le mot de passe avant de l'insérer en base de données
                    ->setCreatedAt(new \DateTimeImmutable());
                    
                $em->persist($client);
            }

            // Préparer la requête et envoyer la donnée à la base de données
            $em->flush();

            // Rediriger l'utilisateur à la page d'accueil
            if(isset($client) && in_array('ROLE_CLIENT', $client->getRoles())){
            // Envoyer un message flash de bienvenue et d'attente de confirmation
            $this->addFlash('success', "Bienvenu(e) {$user->getFirstname()}  {$user->getLastname()}");
            }

            // Envoyer un message flash de bienvenue et d'attente de confirmation
            if(isset($agent) && in_array('ROLE_AGENT', $agent->getRoles())){
            $this->addFlash('success', 'Bienvenu. Votre inscription sera bientôt étudiée');
          }

           return $this->redirectToRoute('home'); // Rediriger le nouvel utilisateur à la page d'accueil
           
        }
       
        return $this->render('security/register.html.twig',[
            'form' => $form
        ]);
    }

    // Action de se connecter

    #[Route(
        path:'/login',
        name: 'login'
    )]    
    public function login(AuthenticationUtils $authenticationUtils): Response
    {

        // Si utilisateur déjà connecté, rediriger à la page d'accueil
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        // Stoker la dernière rencontrée ainsi que l'identifiant utilisateur(ici le email)
        $error = $authenticationUtils->getLastAuthenticationError();
        $username = $authenticationUtils->getLastUsername();

        // En cas d'erreur, préparer un message flash
        if($error){
            $this->addFlash('error', 'Une erreur d\'authentification s\'est produite');
        }

        return $this->render('security/login.html.twig',[
            'error' => $error,
            'username' => $username
        ]);
    }

    #[Route(
        path:'/logout',
        name: 'logout'
    )]
    public function logout(): Response
    {

    }
}
