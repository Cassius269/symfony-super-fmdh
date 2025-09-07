<?php

namespace App\Entity;

use App\Entity\Trait\DateTrait;
use App\Repository\TransactionTypeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TransactionTypeRepository::class)]
class TransactionType
{
    use DateTrait; // utilisation du trait contenant les propriétés de date de création et mise à jour en plus des getteurs et setteurs

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 15)]
    #[Assert\NotBlank(message:'Le type de propriété est obligatoire')]
    #[Assert\Length(
        min: 4,
        max:15,
        minMessage: 'Le nom du type de propriété doit avoir plus de 4 caractères', 
        maxMessage: 'Le nom du type de propriété doit avoir au maximum 15 caractères'
    )]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
