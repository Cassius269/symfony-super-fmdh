<?php

namespace App\Form;

use App\Entity\Agent;
use App\Entity\City;
use App\Entity\Listing;
use App\Entity\PropertyType;
use App\Entity\TransactionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ListingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,[
                'label' => 'Titre',
                'attr' => [
                    'placeholder' => 'Titre de l\'annonce'
                ], 
                'required' => true
            ])
            ->add('description', TextareaType::class,[
                'label' => 'Description',
                'attr' => [
                    'placeholder' => 'Description de l\'annonce'
                ], 
                'required' => true
            ])
            ->add('price', NumberType::class, [
                'label' => 'Prix',
                'html5' => true, // afficher input type="number
                'scale' => 2, // deux chiffres après la virgule maximum
                // 'grouping' => true, // activer le séparateur de milliiers
                'attr' => [
                    'placeholder' => 'Prix du bien',
                    'min' => 0,
                    'step' => 10 // sauter de 10 euros à chaque clique du plus ou moins
                ]
            ])
            ->add('image', TextType::class, [
                'label' => 'Image d\'illustration',
                'attr' => [
                    'placeholder' => 'lien de l\'image'
                ]
            ])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'name', // choisir la ville par son nom
            ])
            ->add('propertyType', EntityType::class, [
                'class' => PropertyType::class,
                'choice_label' => 'name',  // choisir le type de propriété par son nom disponible dans la base de donnée
                'label' => 'Type de propriété'
            ])
            ->add('transactionType', EntityType::class, [
                'class' => TransactionType::class,
                'choice_label' => 'name', // choisir le type de transaction par son nom disponible dans la base de donnée
                'label' => 'Type de transaction'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Listing::class,
        ]);
    }
}
