<?php

namespace App\Entity;

use App\Repository\ExpenseControlRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Validator;
use ApiPlatform\Metadata as Metadata;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: ExpenseControlRepository::class)]
#[Metadata\ApiResource(
    operations: [
        new Metadata\Get(
            normalizationContext: [
                'groups' => [
                    'read:expense-control:item',
                ]
            ],
        ),
        new Metadata\GetCollection(
            normalizationContext: [
                'groups' => [
                    'read:expense-control:collection',
                ]
            ],
        )
    ],
), Metadata\ApiFilter(
    SearchFilter::class,
    properties: [
        'id' => 'partial',
        'start_at' => 'partial',
        'end_at' => 'partial',
        'description' => 'partial',
        'created_at' => 'partial'
    ]
)]
class ExpenseControl
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'read:expense-control:collection',
        'read:expense-control:item',

    ])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Validator\NotBlank()]
    #[Groups([
        'read:expense-control:collection',
        'read:expense-control:item',

    ])]

    private ?\DateTimeInterface $start_at = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Validator\NotBlank()]
    #[Groups([
        'read:expense-control:collection',
        'read:expense-control:item',

    ])]
    private ?\DateTimeInterface $end_at = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Validator\Length(min: 30, max: 8000)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups([
        'read:expense-control:collection',
        'read:expense-control:item',

    ])]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups([
        'read:expense-control:item',

    ])]
    private ?\DateTimeInterface $updated_at = null;

    /**
     * @var Collection<int, YearAcademic>
     */
    #[ORM\ManyToMany(targetEntity: YearAcademic::class, inversedBy: 'expenseControls')]
    #[Validator\NotBlank()]
    #[Groups([
        'read:expense-control:item',

    ])]
    private Collection $yearAcademics;

    /**
     * @var Collection<int, Assignment>
     */
    #[ORM\OneToMany(targetEntity: Assignment::class, mappedBy: 'expenseControl', orphanRemoval: true)]
    #[Groups([
        'read:expense-control:item',

    ])]
    private Collection $assignments;


    public function __construct()
    {
        $this->yearAcademics = new ArrayCollection();

        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
        $this->assignments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->start_at;
    }

    public function setStartAt(\DateTimeInterface $start_at): static
    {
        $this->start_at = $start_at;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->end_at;
    }

    public function setEndAt(\DateTimeInterface $end_at): static
    {
        $this->end_at = $end_at;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, YearAcademic>
     */
    public function getYearAcademics(): Collection
    {
        return $this->yearAcademics;
    }

    public function addYearAcademic(YearAcademic $yearAcademic): static
    {
        if (!$this->yearAcademics->contains($yearAcademic)) {
            $this->yearAcademics->add($yearAcademic);
        }

        return $this;
    }

    public function removeYearAcademic(YearAcademic $yearAcademic): static
    {
        $this->yearAcademics->removeElement($yearAcademic);

        return $this;
    }

    /**
     * @return Collection<int, Assignment>
     */
    public function getAssignments(): Collection
    {
        return $this->assignments;
    }

    public function addAssignment(Assignment $assignment): static
    {
        if (!$this->assignments->contains($assignment)) {
            $this->assignments->add($assignment);
            $assignment->setExpenseControl($this);
        }

        return $this;
    }

    public function removeAssignment(Assignment $assignment): static
    {
        if ($this->assignments->removeElement($assignment)) {
            // set the owning side to null (unless already changed)
            if ($assignment->getExpenseControl() === $this) {
                $assignment->setExpenseControl(null);
            }
        }

        return $this;
    }
}
