<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SectorRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Validator;
use ApiPlatform\Metadata as Metadata;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: SectorRepository::class)]
#[UniqueEntity(['alias', 'department'], errorPath: 'alias')]
#[UniqueEntity(['name', 'department'], errorPath: 'name')]
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
        'department' => 'exact',
        'created_at' => 'partial'
    ]
)]

class Sector
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'read:sector:collection',
        'read:sector:item',
        'read:department:item',
        'read:level:collection',
        'read:level:item',
        'read:student:item',
        'read:paid:collection',
        'read:paid:item',
    ])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Validator\NotBlank()]
    #[Validator\Length(min: 2, max: 255)]
    #[Groups([
        'read:sector:collection',
        'read:sector:item',
        'read:department:item',
        'read:level:item',
        'read:student:item',
        'read:paid:item',

    ])]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'sectors')]
    #[ORM\JoinColumn(nullable: false)]
    #[Validator\NotBlank()]
    #[Groups([
        'read:sector:item',
    ])]
    private ?Department $department = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups([
        'read:sector:collection',
        'read:sector:item',
        'read:department:item',
    ])]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups([
        'read:sector:item',
    ])]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\Column(length: 20)]
    #[Validator\NotBlank()]
    #[Validator\Length(min: 2, max: 20)]
    #[Groups([
        'read:sector:item',
        'read:department:item',
        'read:level:collection',
        'read:level:item',
        'read:paid:collection',
    ])]
    private ?string $alias = null;

    /**
     * @var Collection<int, Level>
     */
    #[ORM\OneToMany(targetEntity: Level::class, mappedBy: 'sector', orphanRemoval: true)]
    #[Groups([
        'read:sector:item',
    ])]

    private Collection $levels;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
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

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): static
    {
        $this->department = $department;

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

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): static
    {
        $this->alias = $alias;

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
            $level->setSector($this);
        }

        return $this;
    }

    public function removeLevel(Level $level): static
    {
        if ($this->levels->removeElement($level)) {
            // set the owning side to null (unless already changed)
            if ($level->getSector() === $this) {
                $level->setSector(null);
            }
        }

        return $this;
    }
}
