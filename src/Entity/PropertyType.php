<?php

namespace App\Entity;

use App\Entity\Trait\DateTrait;
use App\Repository\PropertyTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PropertyTypeRepository::class)]
class PropertyType
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

    /**
     * @var Collection<int, Listing>
     */
    #[ORM\OneToMany(targetEntity: Listing::class, mappedBy: 'propertyType')]
    private Collection $listings;

    public function __construct()
    {
        $this->listings = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Listing>
     */
    public function getListings(): Collection
    {
        return $this->listings;
    }

    public function addListing(Listing $listing): static
    {
        if (!$this->listings->contains($listing)) {
            $this->listings->add($listing);
            $listing->setPropertyType($this);
        }

        return $this;
    }

    public function removeListing(Listing $listing): static
    {
        if ($this->listings->removeElement($listing)) {
            // set the owning side to null (unless already changed)
            if ($listing->getPropertyType() === $this) {
                $listing->setPropertyType(null);
            }
        }

        return $this;
    }
}
