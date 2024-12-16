<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DepartmentRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Validator;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use ApiPlatform\Metadata as Metadata;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: DepartmentRepository::class)]
#[UniqueEntity(['alias', 'faculty'], errorPath: 'alias')]
#[UniqueEntity(['name', 'faculty'], errorPath: 'name')]
#[Metadata\ApiResource(
    operations: [
        new Metadata\Get(
            normalizationContext: [
                'groups' => [
                    'read:department:item',
                ]
            ],
        ),
        new Metadata\GetCollection(
            normalizationContext: [
                'groups' => [
                    'read:department:collection',
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
        'faculty' => 'exact',
        'created_at' => 'partial'
    ]
)]

class Department
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(
        [
            'read:department:collection',
            'read:department:item',
            'read:faculty:item'
        ]
    )]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Validator\NotBlank()]
    #[Validator\Length(min: 2, max: 255)]
    #[Groups(
        [
            'read:department:collection',
            'read:department:item',
            'read:faculty:item'
        ]
    )]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'departments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Validator\NotBlank()]
    #[Groups(
        [
            'read:department:collection',
            'read:department:item',
        ]
    )]
    private ?Faculty $faculty = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(
        [
            'read:department:collection',
            'read:department:item',
            'read:faculty:item'
        ]
    )]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(
        [
            'read:department:item',
        ]
    )]
    private ?\DateTimeInterface $updated_at = null;

    /**
     * @var Collection<int, Sector>
     */
    #[ORM\OneToMany(targetEntity: Sector::class, mappedBy: 'department', orphanRemoval: true)]
    #[Groups(
        [
            'read:department:item',
        ]
    )]
    private Collection $sectors;

    #[ORM\Column(length: 20)]
    #[Validator\NotBlank()]
    #[Validator\Length(min: 2, max: 20)]
    #[Groups(
        [
            'read:department:item',
        ]
    )]
    private ?string $alias = null;

    public function __construct()
    {
        $this->sectors = new ArrayCollection();
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
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

    public function getFaculty(): ?Faculty
    {
        return $this->faculty;
    }

    public function setFaculty(?Faculty $faculty): static
    {
        $this->faculty = $faculty;

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
     * @return Collection<int, Sector>
     */
    public function getSectors(): Collection
    {
        return $this->sectors;
    }

    public function addSector(Sector $sector): static
    {
        if (!$this->sectors->contains($sector)) {
            $this->sectors->add($sector);
            $sector->setDepartment($this);
        }

        return $this;
    }

    public function removeSector(Sector $sector): static
    {
        if ($this->sectors->removeElement($sector)) {
            // set the owning side to null (unless already changed)
            if ($sector->getDepartment() === $this) {
                $sector->setDepartment(null);
            }
        }

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
}
