<?php

namespace App\Entity;

use App\Repository\ProgrammeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgrammeRepository::class)]
class Programme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $name = null;

    #[ORM\Column(length: 20, unique: true)]
    private ?string $alias = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    /**
     * @var Collection<int, Amount>
     */
    #[ORM\OneToMany(targetEntity: Amount::class, mappedBy: 'programme', orphanRemoval: true)]
    private Collection $amounts;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->amounts = new ArrayCollection();
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

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): static
    {
        $this->alias = $alias;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection<int, Amount>
     */
    public function getAmounts(): Collection
    {
        return $this->amounts;
    }

    public function addAmount(Amount $amount): static
    {
        if (!$this->amounts->contains($amount)) {
            $this->amounts->add($amount);
            $amount->setProgramme($this);
        }

        return $this;
    }

    public function removeAmount(Amount $amount): static
    {
        if ($this->amounts->removeElement($amount)) {
            // set the owning side to null (unless already changed)
            if ($amount->getProgramme() === $this) {
                $amount->setProgramme(null);
            }
        }

        return $this;
    }
}
