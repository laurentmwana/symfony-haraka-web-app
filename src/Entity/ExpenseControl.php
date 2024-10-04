<?php

namespace App\Entity;

use App\Repository\ExpenseControlRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Validator;


#[ORM\Entity(repositoryClass: ExpenseControlRepository::class)]
class ExpenseControl
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Validator\NotBlank()]

    private ?\DateTimeInterface $start_at = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Validator\NotBlank()]

    private ?\DateTimeInterface $end_at = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Validator\Length(min: 30, max: 8000)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    /**
     * @var Collection<int, YearAcademic>
     */
    #[ORM\ManyToMany(targetEntity: YearAcademic::class, inversedBy: 'expenseControls')]
    #[Validator\NotBlank()]

    private Collection $yearAcademics;


    public function __construct()
    {
        $this->yearAcademics = new ArrayCollection();

        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
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
}
