<?php

namespace App\Entity;

use App\Repository\PanierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PanierRepository::class)]
class Panier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'user_panier')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $user_id = null;

    #[ORM\ManyToOne(inversedBy: 'paniers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?catalogue $catalogue_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?user
    {
        return $this->user_id;
    }

    public function setUserId(?user $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getCatalogueId(): ?catalogue
    {
        return $this->catalogue_id;
    }

    public function setCatalogueId(?catalogue $catalogue_id): self
    {
        $this->catalogue_id = $catalogue_id;

        return $this;
    }
}
