<?php

namespace App\Entity;

use App\Repository\FacultyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Validator;
use ApiPlatform\Metadata as Metadata;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FacultyRepository::class)]
#[UniqueEntity('name')]
#[Metadata\ApiResource(
    operations: [
        new Metadata\Get(
            normalizationContext: [
                'groups' => [
                    'read:faculty:item',
                ]
            ],
        ),
        new Metadata\GetCollection(
            normalizationContext: [
                'groups' => [
                    'read:faculty:collection',
                ]
            ],
        )
    ],
), Metadata\ApiFilter(
    SearchFilter::class,
    properties: [
        'id' => 'partial',
        'name' => 'partial',
        'created_at' => 'partial'
    ]
)]
class Faculty
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(
        [
            'read:faculty:collection',
            'read:faculty:item',
            'read:department:item',
        ]
    )]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Validator\NotBlank()]
    #[Validator\Length(min: 2, max: 255)]
    #[Groups(
        [
            'read:faculty:collection',
            'read:faculty:item',
            'read:department:item',
        ]
    )]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups([
        'read:faculty:collection',
        'read:faculty:item',
        'read:department:item',
    ])]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups([
        'read:faculty:item',
    ])]
    private ?\DateTimeInterface $updated_at = null;

    /**
     * @var Collection<int, Department>
     */
    #[ORM\OneToMany(targetEntity: Department::class, mappedBy: 'faculty', orphanRemoval: true)]
    #[Groups([
        'read:faculty:item',
    ])]
    private Collection $departments;

    /**
     * @var Collection<int, Assignment>
     */
    #[ORM\OneToMany(targetEntity: Assignment::class, mappedBy: 'faculty', orphanRemoval: true)]
    #[Groups([
        'read:faculty:item',
    ])]
    private Collection $assignments;

    /**
     * @var Collection<int, ChoiceMethodPayment>
     */
    #[ORM\ManyToMany(targetEntity: ChoiceMethodPayment::class, mappedBy: 'faculties')]
    private Collection $choiceMethodPayments;

    public function __construct()
    {
        $this->departments = new ArrayCollection();
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
        $this->assignments = new ArrayCollection();
        $this->choiceMethodPayments = new ArrayCollection();
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
     * @return Collection<int, Department>
     */
    public function getDepartments(): Collection
    {
        return $this->departments;
    }

    public function addDepartment(Department $department): static
    {
        if (!$this->departments->contains($department)) {
            $this->departments->add($department);
            $department->setFaculty($this);
        }

        return $this;
    }

    public function removeDepartment(Department $department): static
    {
        if ($this->departments->removeElement($department)) {
            // set the owning side to null (unless already changed)
            if ($department->getFaculty() === $this) {
                $department->setFaculty(null);
            }
        }

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
            $assignment->setFaculty($this);
        }

        return $this;
    }

    public function removeAssignment(Assignment $assignment): static
    {
        if ($this->assignments->removeElement($assignment)) {
            // set the owning side to null (unless already changed)
            if ($assignment->getFaculty() === $this) {
                $assignment->setFaculty(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ChoiceMethodPayment>
     */
    public function getChoiceMethodPayments(): Collection
    {
        return $this->choiceMethodPayments;
    }

    public function addChoiceMethodPayment(ChoiceMethodPayment $choiceMethodPayment): static
    {
        if (!$this->choiceMethodPayments->contains($choiceMethodPayment)) {
            $this->choiceMethodPayments->add($choiceMethodPayment);
            $choiceMethodPayment->addFaculty($this);
        }

        return $this;
    }

    public function removeChoiceMethodPayment(ChoiceMethodPayment $choiceMethodPayment): static
    {
        if ($this->choiceMethodPayments->removeElement($choiceMethodPayment)) {
            $choiceMethodPayment->removeFaculty($this);
        }

        return $this;
    }
}
