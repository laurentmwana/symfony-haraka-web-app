<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ChoiceMethodPaymentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata as Metadata;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ChoiceMethodPaymentRepository::class)]
#[Metadata\ApiResource(
    operations: [
        new Metadata\Get(
            uriTemplate: '/choice-method-payments/{id}',
            normalizationContext: [
                'groups' => [
                    'read:choice-method-payment:item',
                ]
            ],
        ),
        new Metadata\GetCollection(
            uriTemplate: '/choice-method-payments',
            normalizationContext: [
                'groups' => [
                    'read:choice-method-payment:collection',
                ]
            ],
        )
    ],
), Metadata\ApiFilter(
    SearchFilter::class,
    properties: [
        'id' => 'partial',
        'student' => 'partial',
        'level' => 'partial',
        'amount' => 'partial',
        'installment' => 'partial',
        'created_at' => 'partial'
    ]
)]
class ChoiceMethodPayment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(
        [
            'read:choice-method-payment:collection',
            'read:choice-method-payment:item',
        ]
    )]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'choiceMethodPayments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(
        [
            'read:choice-method-payment:collection',
            'read:choice-method-payment:item',
        ]
    )]
    private ?PaymentMethod $paymentMethod = null;

    #[ORM\ManyToOne(inversedBy: 'choiceMethodPayments')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(
        [
            'read:choice-method-payment:collection',
            'read:choice-method-payment:item',
        ]
    )]
    private ?YearAcademic $yearAcademic = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(
        [
            'read:choice-method-payment:collection',
            'read:choice-method-payment:item',
        ]
    )]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(
        [
            'read:choice-method-payment:collection',
            'read:choice-method-payment:item',
        ]
    )]
    private ?\DateTimeInterface $updated_at = null;

    /**
     * @var Collection<int, Faculty>
     */
    #[ORM\ManyToMany(targetEntity: Faculty::class, inversedBy: 'choiceMethodPayments')]
    #[Groups(
        [
            'read:choice-method-payment:item',
        ]
    )]
    private Collection $faculties;

    public function __construct()
    {
        $this->faculties = new ArrayCollection();
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPaymentMethod(): ?PaymentMethod
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?PaymentMethod $paymentMethod): static
    {
        $this->paymentMethod = $paymentMethod;

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
     * @return Collection<int, Faculty>
     */
    public function getFaculties(): Collection
    {
        return $this->faculties;
    }

    public function addFaculty(Faculty $faculty): static
    {
        if (!$this->faculties->contains($faculty)) {
            $this->faculties->add($faculty);
        }

        return $this;
    }

    public function removeFaculty(Faculty $faculty): static
    {
        $this->faculties->removeElement($faculty);

        return $this;
    }
}
