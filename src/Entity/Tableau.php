<?php

namespace App\Entity;

use App\Repository\PersonneRepository;
use App\Repository\TableauRepository;
use App\Traits\TimeStampTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TableauRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table('`tableau`')]
class Tableau
{
    use TimeStampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(mappedBy: 'tableau', cascade: ['persist', 'remove'])]
    private ?Projet $projet = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;



    /**
     * @ORM\ManyToOne(targetEntity=Personne::class, inversedBy="tableaux")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?personne $lead = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): self
    {
        // unset the owning side of the relation if necessary
        if ($projet === null && $this->projet !== null) {
            $this->projet->setTableau(null);
        }

        // set the owning side of the relation if necessary
        if ($projet !== null && $projet->getTableau() !== $this) {
            $projet->setTableau($this);
        }

        $this->projet = $projet;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLead(): ?personne
    {
        return $this->lead;
    }

    public function setLead(?personne $lead): self
    {
        $this->lead = $lead;

        return $this;
    }
}
