<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'prénom'
                ],
                'required' => true
            ])
            ->add('lastname', TextType::class,[
                'label' => 'Nom de famille', 
                'attr' => [
                    'placeholder' => 'nom de famille'
                ],
                'required' => true
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'email'
                ]
            ])
            // ->add('password', PasswordType::class, [
            //     'label' => 'Mot de passe',
            //     'attr' => [
            //         'placeholder' => 'mot de passe'
            //     ],
            //     'required' => true
            // ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les champs de mot de passe doivent être identiques',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true, 
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmation de mot de passe']
            ])
            ->add('typeUser', ChoiceType::class, [
                'mapped' => false,
                'choices' => [
                    '----- Sélectionner votre choix -----' => null,
                    'Agent' => 'agent',
                    'Client' => 'client'
                ],
                'label' => 'S\'inscrire en tant que', 
                'required'=> true,
                'constraints' => [
                 new NotBlank(['message' => 'Veuillez sélectionner un rôle']),
    ],
            ])
            ->add('agreementTerms', CheckboxType::class, [
                'mapped' => false,
                'label' => "J'accepte les conditions d'utilisation du site", 
                'required' => true]
            )
;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
