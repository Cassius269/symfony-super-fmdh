<?php

namespace App\Entity;

use App\Repository\FavoriteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FavoriteRepository::class)]
class Favorite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\DateTime(
        format:'Y-m-d', 
        message: 'La date doit être au format Y-m-ds')
    ]
    private ?\DateTime $date_favorited = null;

    #[ORM\ManyToOne(inversedBy: 'favorites')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(
        message:'L\'utilisateur doit être renseigné à l\'annonce mise en favori'
    )]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'favorites')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank(
        message:'L\'annonce doit être renseignée à la mise en favori'
    )]
    private ?Listing $listing = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateFavorited(): ?\DateTime
    {
        return $this->date_favorited;
    }

    public function setDateFavorited(\DateTime $date_favorited): static
    {
        $this->date_favorited = $date_favorited;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getListing(): ?Listing
    {
        return $this->listing;
    }

    public function setListing(?Listing $listing): static
    {
        $this->listing = $listing;

        return $this;
    }
}
