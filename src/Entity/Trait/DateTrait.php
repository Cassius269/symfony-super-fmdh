<?php

namespace App\Entity\Trait;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait DateTrait {
    #[ORM\Column]
    #[Assert\DateTime(message:'Le format de date doit être "Y-m-d H:i:s"')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    #[Assert\DateTime(message:'Le format de date doit être "Y-m-d H:i:s"')]
    private ?\DateTime $updatedAt = null;

    
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}