<?php

namespace App\Entity;

use App\Entity\Trait\DateTrait;
use App\Repository\PropertyTypeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PropertyTypeRepository::class)]
class PropertyType
{
    use DateTrait; // utilisation du trait contenant les propriétés de date de création et mise à jour en plus des getteurs et setteurs

    #[ORM\Id] 
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 15)]
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
