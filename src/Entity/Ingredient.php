<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    /**
     * @var Collection<int, Composition>
     */
    #[ORM\OneToMany(targetEntity: Composition::class, mappedBy: 'ingredient', orphanRemoval: true)]
    private Collection $compositions;

    public function __construct()
    {
        $this->compositions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Composition>
     */
    public function getCompositions(): Collection
    {
        return $this->compositions;
    }

    public function addComposition(Composition $composition): static
    {
        if (!$this->compositions->contains($composition)) {
            $this->compositions->add($composition);
            $composition->setIngredient($this);
        }

        return $this;
    }

    public function removeComposition(Composition $composition): static
    {
        if ($this->compositions->removeElement($composition)) {
            // set the owning side to null (unless already changed)
            if ($composition->getIngredient() === $this) {
                $composition->setIngredient(null);
            }
        }

        return $this;
    }
}
