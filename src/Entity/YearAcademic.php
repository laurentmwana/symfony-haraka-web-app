<?php

namespace App\Entity;

use App\Repository\YearAcademicRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata as Metadata;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: YearAcademicRepository::class)]
#[Metadata\ApiResource(
    operations: [
        new Metadata\Get(
            uriTemplate: '/year-academics/{id}',
            normalizationContext: [
                'groups' => [
                    'read:yearAcademic:item',
                ]
            ],
        ),
        new Metadata\GetCollection(
            uriTemplate: '/year-academics',
            normalizationContext: [
                'groups' => [
                    'read:yearAcademic:collection',
                ]
            ],
        )
    ],
), Metadata\ApiFilter(
    SearchFilter::class,
    properties: [
        'id' => 'partial',
        'name' => 'partial',
        'closed' => 'exact',
        'created_at' => 'partial'
    ]
)]
class YearAcademic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(
        [
            'read:yearAcademic:collection',
            'read:yearAcademic:item',
            'read:level:collection',
            'read:level:item',
            'read:student:item',
            'read:paid:collection',
            'read:paid:item',
        ]
    )]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(
        [
            'read:yearAcademic:collection',
            'read:yearAcademic:item',
            'read:level:collection',
            'read:level:item',
            'read:student:item',
            'read:paid:collection',
            'read:paid:item',
        ]
    )]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(
        [
            'read:yearAcademic:collection',
            'read:yearAcademic:item',
            'read:level:collection',
            'read:level:item',
            'read:student:item',
        ]
    )]
    private ?bool $closed = false;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(
        [
            'read:yearAcademic:collection',
            'read:yearAcademic:item',
        ]
    )]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(
        [
            'read:yearAcademic:collection',
            'read:yearAcademic:item',

        ]
    )]
    private ?\DateTimeInterface $closed_at = null;


    /**
     * @var Collection<int, Amount>
     */
    #[ORM\OneToMany(targetEntity: Amount::class, mappedBy: 'yearAcademic', orphanRemoval: true)]
    #[Groups(
        [
            'read:yearAcademic:item',
        ]
    )]
    private Collection $amounts;

    /**
     * @var Collection<int, Level>
     */
    #[ORM\OneToMany(targetEntity: Level::class, mappedBy: 'yearAcademic', orphanRemoval: true)]
    private Collection $levels;

    /**
     * @var Collection<int, ExpenseControl>
     */
    #[ORM\ManyToMany(targetEntity: ExpenseControl::class, mappedBy: 'yearAcademics')]
    private Collection $expenseControls;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->amounts = new ArrayCollection();
        $this->levels = new ArrayCollection();
        $this->expenseControls = new ArrayCollection();
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

    public function isClosed(): ?bool
    {
        return $this->closed;
    }

    public function setClosed(bool $closed): static
    {
        $this->closed = $closed;

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

    public function getClosedAt(): ?\DateTimeInterface
    {
        return $this->closed_at;
    }

    public function setClosedAt(?\DateTimeInterface $closed_at): static
    {
        $this->closed_at = $closed_at;

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
            $amount->setYearAcademic($this);
        }

        return $this;
    }

    public function removeAmount(Amount $amount): static
    {
        if ($this->amounts->removeElement($amount)) {
            // set the owning side to null (unless already changed)
            if ($amount->getYearAcademic() === $this) {
                $amount->setYearAcademic(null);
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
            $level->setYearAcademic($this);
        }

        return $this;
    }

    public function removeLevel(Level $level): static
    {
        if ($this->levels->removeElement($level)) {
            // set the owning side to null (unless already changed)
            if ($level->getYearAcademic() === $this) {
                $level->setYearAcademic(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ExpenseControl>
     */
    public function getExpenseControls(): Collection
    {
        return $this->expenseControls;
    }

    public function addExpenseControl(ExpenseControl $expenseControl): static
    {
        if (!$this->expenseControls->contains($expenseControl)) {
            $this->expenseControls->add($expenseControl);
            $expenseControl->addYearAcademic($this);
        }

        return $this;
    }

    public function removeExpenseControl(ExpenseControl $expenseControl): static
    {
        if ($this->expenseControls->removeElement($expenseControl)) {
            $expenseControl->removeYearAcademic($this);
        }

        return $this;
    }
}
