<?php

namespace App\Entity;


use App\Repository\TableauRepository;
use App\Traits\TimeStampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;



#[ORM\Entity(repositoryClass: TableauRepository::class)]
#[ORM\Table('`tableau`')]
#[ORM\HasLifecycleCallbacks]
class Tableau
{
    use TimeStampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;



    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToOne(mappedBy: 'tableau', cascade: ['persist', 'remove'])]
    private ?Equipe $equipe = null;

    #[ORM\OneToMany(mappedBy: 'tableau', targetEntity: Dev::class)]
    private Collection $devs;

    #[ORM\OneToOne(mappedBy: 'tableau', cascade: ['persist', 'remove'])]
    private ?Lead $lead = null;

    #[ORM\ManyToOne(inversedBy: 'tableau')]
    private ?Manager $manager = null;

    #[ORM\OneToMany(mappedBy: 'tableau', targetEntity: Tache::class)]
    private Collection $taches;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'tableaus')]
    private Collection $user_id;

    public function __construct()
    {
        $this->devs = new ArrayCollection();
        $this->taches = new ArrayCollection();
        $this->user_id = new ArrayCollection();
    }





    public function getId(): ?int
    {
        return $this->id;
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

    public function getEquipe(): ?Equipe
    {
        return $this->equipe;
    }

    public function setEquipe(?Equipe $equipe): self
    {
        // unset the owning side of the relation if necessary
        if ($equipe === null && $this->equipe !== null) {
            $this->equipe->setTableau(null);
        }

        // set the owning side of the relation if necessary
        if ($equipe !== null && $equipe->getTableau() !== $this) {
            $equipe->setTableau($this);
        }

        $this->equipe = $equipe;

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
            $dev->setTableau($this);
        }

        return $this;
    }

    public function removeDev(Dev $dev): self
    {
        if ($this->devs->removeElement($dev)) {
            // set the owning side to null (unless already changed)
            if ($dev->getTableau() === $this) {
                $dev->setTableau(null);
            }
        }

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
            $this->lead->setTableau(null);
        }

        // set the owning side of the relation if necessary
        if ($lead !== null && $lead->getTableau() !== $this) {
            $lead->setTableau($this);
        }

        $this->lead = $lead;

        return $this;
    }

    public function getManager(): ?Manager
    {
        return $this->manager;
    }

    public function setManager(?Manager $manager): self
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * @return Collection<int, Tache>
     */
    public function getTaches(): Collection
    {
        return $this->taches;
    }

    public function addTach(Tache $tach): self
    {
        if (!$this->taches->contains($tach)) {
            $this->taches->add($tach);
            $tach->setTableau($this);
        }

        return $this;
    }

    public function removeTach(Tache $tach): self
    {
        if ($this->taches->removeElement($tach)) {
            // set the owning side to null (unless already changed)
            if ($tach->getTableau() === $this) {
                $tach->setTableau(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserId(): Collection
    {
        return $this->user_id;
    }

    public function addUserId(User $userId): self
    {
        if (!$this->user_id->contains($userId)) {
            $this->user_id->add($userId);
        }

        return $this;
    }

    public function removeUserId(User $userId): self
    {
        $this->user_id->removeElement($userId);

        return $this;
    }


}
