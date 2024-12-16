<?php

namespace App\Entity;

use App\Repository\ProgrammeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata as Metadata;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProgrammeRepository::class)]
#[Metadata\ApiResource(
    operations: [
        new Metadata\Get(
            normalizationContext: [
                'groups' => [
                    'read:programme:item',
                ]
            ],
        ),
        new Metadata\GetCollection(
            normalizationContext: [
                'groups' => [
                    'read:programme:collection',
                ]
            ],
        )
    ],
), Metadata\ApiFilter(
    SearchFilter::class,
    properties: [
        'id' => 'partial',
        'name' => 'partial',
        'alias' => 'partial',
        'created_at' => 'partial'
    ]
)]
class Programme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(
        [
            'read:programme:collection',
            'read:programme:item',
            'read:yearAcademic:item',
            'read:payment:collection',
            'read:payment:item',
            'read:level:item',
            'read:level:collection'
        ]
    )]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(
        [
            'read:programme:collection',
            'read:programme:item',
            'read:yearAcademic:item',
            'read:payment:collection',
            'read:payment:item',
            'read:level:item',
            'read:level:collection'
        ]
    )]
    private ?string $name = null;

    #[ORM\Column(length: 20, unique: true)]
    #[Groups(
        [
            'read:programme:collection',
            'read:programme:item',
            'read:payment:collection',
            'read:payment:item',
            'read:level:item',
            'read:level:collection'
        ]
    )]
    private ?string $alias = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(
        [
            'read:programme:collection',
            'read:programme:item',
            'read:payment:collection',
            'read:payment:item',
        ]
    )]
    private ?\DateTimeInterface $created_at = null;

    /**
     * @var Collection<int, Amount>
     */
    #[ORM\OneToMany(targetEntity: Amount::class, mappedBy: 'programme', orphanRemoval: true)]
    #[Groups(
        [
            'read:programme:item',
        ]
    )]
    private Collection $amounts;

    /**
     * @var Collection<int, Level>
     */
    #[ORM\OneToMany(targetEntity: Level::class, mappedBy: 'programme', orphanRemoval: true)]
    #[Groups(
        [
            'read:programme:item',
        ]
    )]
    private Collection $levels;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->amounts = new ArrayCollection();
        $this->levels = new ArrayCollection();
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

    /**
     * @return Collection<int, Level>
     */
    public function getLevels(): Collection
    {
        return $this->levels;
    }

    public function addLevel(Level $level): static
    {
        if (!$this->levels->contains($level)) {
            $this->levels->add($level);
            $level->setProgramme($this);
        }

        return $this;
    }

    public function removeLevel(Level $level): static
    {
        if ($this->levels->removeElement($level)) {
            // set the owning side to null (unless already changed)
            if ($level->getProgramme() === $this) {
                $level->setProgramme(null);
            }
        }

        return $this;
    }
}
