<?php

namespace App\Entity;

use App\Repository\AssignmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssignmentRepository::class)]
class Assignment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'assignments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Faculty $faculty = null;

    #[ORM\ManyToOne(inversedBy: 'assignments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ExpenseControl $expenseControl = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    /**
     * @var Collection<int, Checker>
     */
    #[ORM\ManyToMany(targetEntity: Checker::class, inversedBy: 'assignments')]
    private Collection $checkers;

    public function __construct()
    {
        $this->checkers = new ArrayCollection();

        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getExpenseControl(): ?ExpenseControl
    {
        return $this->expenseControl;
    }

    public function setExpenseControl(?ExpenseControl $expenseControl): static
    {
        $this->expenseControl = $expenseControl;

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
     * @return Collection<int, Checker>
     */
    public function getCheckers(): Collection
    {
        return $this->checkers;
    }

    public function addChecker(Checker $checker): static
    {
        if (!$this->checkers->contains($checker)) {
            $this->checkers->add($checker);
        }

        return $this;
    }

    public function removeChecker(Checker $checker): static
    {
        $this->checkers->removeElement($checker);

        return $this;
    }
}
