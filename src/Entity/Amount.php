<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\AmountRepository;
use App\Validator\ChangedPriceAmount;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Validator;
use ApiPlatform\Metadata as Metadata;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: AmountRepository::class)]
#[UniqueEntity(['programme', 'yearAcademic'], errorPath: 'programme')]
#[ChangedPriceAmount()]
#[Metadata\ApiResource(
    operations: [
        new Metadata\Get(
            normalizationContext: [
                'groups' => [
                    'read:amount:item',
                ]
            ],
        ),
        new Metadata\GetCollection(
            normalizationContext: [
                'groups' => [
                    'read:amount:collection',
                ]
            ],
        )
    ],
), Metadata\ApiFilter(
    SearchFilter::class,
    properties: [
        'id' => 'partial',
        'price' => 'partial',
        'yearAcademic' => 'partial',
        'max_number_installment' => 'partial',
        'created_at' => 'partial'
    ]
)]
class Amount
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        'read:amount:collection',
        'read:amount:item',
        'read:yearAcademic:item',
        'read:payment:collection',
        'read:payment:item',
    ])]
    private ?int $id = null;

    #[ORM\Column]
    #[Validator\NotBlank()]
    #[Validator\Regex("/^([0-9]*[1-9][0-9]*)(\.[0-9]+)?$/")]
    #[Groups([
        'read:amount:collection',
        'read:amount:item',
        'read:yearAcademic:item',
        'read:payment:collection',
        'read:payment:item',

    ])]
    private ?float $price = null;

    #[ORM\Column]
    #[Validator\NotBlank()]
    #[Validator\Range(min: 1, max: 5)]
    #[Groups([
        'read:amount:collection',
        'read:amount:item',
        'read:yearAcademic:item',

    ])]
    private ?int $max_number_installment = null;

    #[ORM\ManyToOne(inversedBy: 'amounts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups([
        'read:amount:collection',
        'read:amount:item',
        'read:yearAcademic:item',
    ])]
    private ?Programme $programme = null;

    #[ORM\ManyToOne(inversedBy: 'amounts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?YearAcademic $yearAcademic = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups([
        'read:amount:collection',
        'read:amount:item',
        'read:yearAcademic:item',

    ])]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    /**
     * @var Collection<int, Installment>
     */
    #[ORM\OneToMany(targetEntity: Installment::class, mappedBy: 'amount', orphanRemoval: true, cascade: ['persist'])]
    #[Validator\Valid()]
    #[Groups([
        'read:amount:collection',
        'read:amount:item',
        'read:yearAcademic:item',
    ])]
    private Collection $installments;

    #[ORM\Column]
    private ?bool $generate = false;

    /**
     * @var Collection<int, Payment>
     */
    #[ORM\OneToMany(targetEntity: Payment::class, mappedBy: 'amount', orphanRemoval: true)]
    private Collection $payments;

    public function __construct()
    {
        $this->installments = new ArrayCollection();
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
        $this->payments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getMaxNumberInstallment(): ?int
    {
        return $this->max_number_installment;
    }

    public function setMaxNumberInstallment(int $max_number_installment): static
    {
        $this->max_number_installment = $max_number_installment;

        return $this;
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
     * @return Collection<int, Installment>
     */
    public function getInstallments(): Collection
    {
        return $this->installments;
    }

    public function addInstallment(Installment $installment): static
    {
        if (!$this->installments->contains($installment)) {
            $this->installments->add($installment);
            $installment->setAmount($this);
        }

        return $this;
    }

    public function removeInstallment(Installment $installment): static
    {
        if ($this->installments->removeElement($installment)) {
            // set the owning side to null (unless already changed)
            if ($installment->getAmount() === $this) {
                $installment->setAmount(null);
            }
        }

        return $this;
    }

    public function isGenerate(): ?bool
    {
        return $this->generate;
    }

    public function setGenerate(bool $generate): static
    {
        $this->generate = $generate;

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
            $payment->setAmount($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): static
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getAmount() === $this) {
                $payment->setAmount(null);
            }
        }

        return $this;
    }
}
