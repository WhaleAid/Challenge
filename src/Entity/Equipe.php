<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use App\Traits\TimeStampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EquipeRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Equipe
{
    use TimeStampTrait;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'equipe', targetEntity: Personne::class)]
    private Collection $chef;

    #[ORM\OneToMany(mappedBy: 'equipe', targetEntity: Personne::class)]
    private Collection $membres;



    #[ORM\OneToOne(inversedBy: 'equipe', cascade: ['persist', 'remove'])]
    private ?Projet $projet = null;

    public function __construct()
    {
        $this->chef = new ArrayCollection();
        $this->membres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Personne>
     */
    public function getChef(): Collection
    {
        return $this->chef;
    }

    public function addChef(Personne $chef): self
    {
        if (!$this->chef->contains($chef)) {
            $this->chef->add($chef);
            $chef->setEquipe($this);
        }

        return $this;
    }

    public function removeChef(Personne $chef): self
    {
        if ($this->chef->removeElement($chef)) {
            // set the owning side to null (unless already changed)
            if ($chef->getEquipe() === $this) {
                $chef->setEquipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Personne>
     */
    public function getMembres(): Collection
    {
        return $this->membres;
    }

    public function addMembre(Personne $membre): self
    {
        if (!$this->membres->contains($membre)) {
            $this->membres->add($membre);
            $membre->setEquipe($this);
        }

        return $this;
    }

    public function removeMembre(Personne $membre): self
    {
        if ($this->membres->removeElement($membre)) {
            // set the owning side to null (unless already changed)
            if ($membre->getEquipe() === $this) {
                $membre->setEquipe(null);
            }
        }

        return $this;
    }

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): self
    {
        $this->projet = $projet;

        return $this;
    }
}
