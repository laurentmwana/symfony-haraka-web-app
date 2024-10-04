<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LevelRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: LevelRepository::class)]

class Level
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'levels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Programme $programme = null;

    #[ORM\ManyToOne(inversedBy: 'levels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Sector $sector = null;

    #[ORM\ManyToOne(inversedBy: 'levels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?YearAcademic $yearAcademic = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    /**
     * @var Collection<int, Student>
     */
    #[ORM\ManyToMany(targetEntity: Student::class, mappedBy: 'levels', cascade: ['persist'])]
    private Collection $students;

    /**
     * @var Collection<int, ActualLevel>
     */
    #[ORM\OneToMany(targetEntity: ActualLevel::class, mappedBy: 'level', orphanRemoval: true)]
    private Collection $actualLevels;

    public function __construct()
    {
        $this->students = new ArrayCollection();

        $this->created_at = new \DateTime();
        $this->actualLevels = new ArrayCollection();
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
            $student->addLevel($this);
        }

        return $this;
    }

    public function removeStudent(Student $student): static
    {
        if ($this->students->removeElement($student)) {
            $student->removeLevel($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, ActualLevel>
     */
    public function getActualLevels(): Collection
    {
        return $this->actualLevels;
    }

    public function addActualLevel(ActualLevel $actualLevel): static
    {
        if (!$this->actualLevels->contains($actualLevel)) {
            $this->actualLevels->add($actualLevel);
            $actualLevel->setLevel($this);
        }

        return $this;
    }

    public function removeActualLevel(ActualLevel $actualLevel): static
    {
        if ($this->actualLevels->removeElement($actualLevel)) {
            // set the owning side to null (unless already changed)
            if ($actualLevel->getLevel() === $this) {
                $actualLevel->setLevel(null);
            }
        }

        return $this;
    }
}
