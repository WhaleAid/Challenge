<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use App\Traits\TimeStampTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProjetRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Projet
{

    use TimeStampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $id_chef = null;





    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $id_tableau = null;

    #[ORM\OneToOne(inversedBy: 'projet', cascade: ['persist', 'remove'])]
    private ?Tableau $tableau = null;

    public function getId(): ?int
    {
        return $this->id;
    }





    public function getIntituleProjet(): ?string
    {
        return $this->intitule_projet;
    }

    public function setIntituleProjet(?string $intitule_projet): self
    {
        $this->intitule_projet = $intitule_projet;

        return $this;
    }

    public function getTableau(): ?Tableau
    {
        return $this->tableau;
    }

    public function setTableau(?Tableau $tableau): self
    {
        $this->tableau = $tableau;

        return $this;
    }

}
