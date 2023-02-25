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





    #[ORM\OneToOne(inversedBy: 'equipe', cascade: ['persist', 'remove'])]
    private ?Tableau $tableau = null;

    #[ORM\OneToOne(mappedBy: 'equipe', cascade: ['persist', 'remove'])]
    private ?Lead $lead = null;

    #[ORM\OneToMany(mappedBy: 'equipe', targetEntity: Dev::class)]
    private Collection $devs;

    public function __construct()
    {
        $this->devs = new ArrayCollection();
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











    public function getTableau(): ?tableau
    {
        return $this->tableau;
    }

    public function setTableau(?tableau $tableau): self
    {
        $this->tableau = $tableau;

        return $this;
    }

    public function getLead(): ?Lead
    {
        return $this->lead;
    }

    public function setLead(?Lead $lead): self
    {
        // unset the owning side of the relation if necessary
        if ($lead === null && $this->lead !== null) {
            $this->lead->setEquipe(null);
        }

        // set the owning side of the relation if necessary
        if ($lead !== null && $lead->getEquipe() !== $this) {
            $lead->setEquipe($this);
        }

        $this->lead = $lead;

        return $this;
    }

    /**
     * @return Collection<int, Dev>
     */
    public function getDevs(): Collection
    {
        return $this->devs;
    }

    public function addDev(Dev $dev): self
    {
        if (!$this->devs->contains($dev)) {
            $this->devs->add($dev);
            $dev->setEquipe($this);
        }

        return $this;
    }

    public function removeDev(Dev $dev): self
    {
        if ($this->devs->removeElement($dev)) {
            // set the owning side to null (unless already changed)
            if ($dev->getEquipe() === $this) {
                $dev->setEquipe(null);
            }
        }

        return $this;
    }
}
