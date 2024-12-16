<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LevelRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Metadata as Metadata;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: LevelRepository::class)]
#[Metadata\ApiResource(
    operations: [
        new Metadata\Get(
            normalizationContext: [
                'groups' => [
                    'read:level:item',
                ]
            ],
        ),
        new Metadata\GetCollection(
            normalizationContext: [
                'groups' => [
                    'read:level:collection',
                ]
            ],
        )
    ],
), Metadata\ApiFilter(
    SearchFilter::class,
    properties: [
        'id' => 'partial',
        'name' => 'partial',
        'sector' => 'exact',
        'yearAcademic' => 'exact',
        'programme' => 'exact',
        'created_at' => 'partial'
    ]
)]

class Level
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(
        [
            'read:level:collection',
            'read:level:item',
            'read:programme:item',
            'read:student:item',
            'read:paid:collection',
            'read:paid:item',
            'read:payment:collection',
            'read:payment:item',

        ]
    )]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'levels')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(
        [
            'read:level:collection',
            'read:level:item',
            'read:student:item',
            'read:paid:collection',
            'read:paid:item',
            'read:payment:collection',
            'read:payment:item',
        ]
    )]
    private ?Programme $programme = null;

    #[ORM\ManyToOne(inversedBy: 'levels')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(
        [
            'read:level:collection',
            'read:level:item',
            'read:programme:item',
            'read:student:item',
            'read:paid:collection',
            'read:paid:item',
            'read:payment:collection',
            'read:payment:item',
        ]
    )]
    private ?Sector $sector = null;

    #[ORM\ManyToOne(inversedBy: 'levels')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(
        [
            'read:level:collection',
            'read:level:item',
            'read:programme:item',
            'read:student:item',
            'read:paid:collection',
            'read:paid:item',
            'read:payment:collection',
            'read:payment:item',
        ]
    )]
    private ?YearAcademic $yearAcademic = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(
        [
            'read:level:collection',
            'read:level:item',
            'read:programme:item',

        ]
    )]
    private ?\DateTimeInterface $created_at = null;

    /**
     * @var Collection<int, Paid>
     */
    #[ORM\OneToMany(targetEntity: Paid::class, mappedBy: 'level', orphanRemoval: true)]
    #[Groups(
        [
            'read:level:collection',
            'read:level:item',
        ]
    )]
    private Collection $paids;

    /**
     * @var Collection<int, Payment>
     */
    #[ORM\OneToMany(targetEntity: Payment::class, mappedBy: 'level', orphanRemoval: true)]
    private Collection $payments;

    /**
     * @var Collection<int, Student>
     */
    #[ORM\OneToMany(targetEntity: Student::class, mappedBy: 'level')]
    private Collection $students;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->paids = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->students = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProgramme(): ?Programme
    {
        return $this->programme;
    }

    public function setProgramme(?Programme $programme): static
    {
        $this->programme = $programme;

        return $this;
    }

    public function getSector(): ?Sector
    {
        return $this->sector;
    }

    public function setSector(?Sector $sector): static
    {
        $this->sector = $sector;

        return $this;
    }

    public function getYearAcademic(): ?YearAcademic
    {
        return $this->yearAcademic;
    }

    public function setYearAcademic(?YearAcademic $yearAcademic): static
    {
        $this->yearAcademic = $yearAcademic;

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
     * @return Collection<int, Paid>
     */
    public function getPaids(): Collection
    {
        return $this->paids;
    }

    public function addPaid(Paid $paid): static
    {
        if (!$this->paids->contains($paid)) {
            $this->paids->add($paid);
            $paid->setLevel($this);
        }

        return $this;
    }

    public function removePaid(Paid $paid): static
    {
        if ($this->paids->removeElement($paid)) {
            // set the owning side to null (unless already changed)
            if ($paid->getLevel() === $this) {
                $paid->setLevel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): static
    {
        if (!$this->payments->contains($payment)) {
            $this->payments->add($payment);
            $payment->setLevel($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): static
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getLevel() === $this) {
                $payment->setLevel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Student>
     */
    public function getStudents(): Collection
    {
        return $this->students;
    }

    public function addStudent(Student $student): static
    {
        if (!$this->students->contains($student)) {
            $this->students->add($student);
            $student->setLevel($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): static
    {
        if ($this->students->removeElement($student)) {
            // set the owning side to null (unless already changed)
            if ($student->getLevel() === $this) {
                $student->setLevel(null);
            }
        }

        return $this;
    }
}
