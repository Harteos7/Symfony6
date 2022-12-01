<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CatalogueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CatalogueRepository::class)]
#[ApiResource(
    collectionOperations: ['get' => ['normalization_context' => ['groups' => 'catalogue:list']], 'post' => ['normalization_context' => ['groups' => 'catalogue:list']]],
    itemOperations: ['get' => ['normalization_context' => ['groups' => 'catalogue:item']], 'put' => ['normalization_context' => ['groups' => 'catalogue:item']], 'patch' => ['normalization_context' => ['groups' => 'catalogue:item']], 'delete' => ['normalization_context' => ['groups' => 'catalogue:item']]],
    order: ['description' => 'DESC', 'nom' => 'ASC'],
    paginationEnabled: false,
)]
class Catalogue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['catalogue:list', 'catalogue:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['catalogue:list', 'catalogue:item'])]
    private ?string $image = null;

    #[ORM\Column(length: 150, nullable: true)]
    #[Groups(['catalogue:list', 'catalogue:item'])]
    private ?string $description = null;

    #[ORM\Column(length: 50)]
    #[Groups(['catalogue:list', 'catalogue:item'])]
    private ?string $nom = null;

    #[ORM\ManyToOne(inversedBy: 'catalogues')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Menu $menu = null;

    #[ORM\OneToMany(mappedBy: 'catalogue_id', targetEntity: Panier::class)]
    private Collection $paniers;

    public function __construct()
    {
        $this->paniers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * @return Collection<int, Panier>
     */
    public function getPaniers(): Collection
    {
        return $this->paniers;
    }

    public function addPanier(Panier $panier): self
    {
        if (!$this->paniers->contains($panier)) {
            $this->paniers->add($panier);
            $panier->setCatalogueId($this);
        }

        return $this;
    }

    public function removePanier(Panier $panier): self
    {
        if ($this->paniers->removeElement($panier)) {
            // set the owning side to null (unless already changed)
            if ($panier->getCatalogueId() === $this) {
                $panier->setCatalogueId(null);
            }
        }

        return $this;
    }

}
