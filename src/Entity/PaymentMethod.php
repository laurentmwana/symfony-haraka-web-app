<?php

namespace App\Entity;

use App\Repository\PaymentMethodRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use ApiPlatform\Metadata as Metadata;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: PaymentMethodRepository::class)]
#[Metadata\ApiResource(
    operations: [
        new Metadata\Get(
            uriTemplate: '/payment-methods/{id}',
            normalizationContext: [
                'groups' => [
                    'read:payment-method:item',
                ]
            ],
        ),
        new Metadata\GetCollection(
            uriTemplate: '/payment-methods',
            normalizationContext: [
                'groups' => [
                    'read:payment-method:collection',
                ]
            ],
        )
    ],
), Metadata\ApiFilter(
    SearchFilter::class,
    properties: [
        'id' => 'partial',
        'name' => 'partial',
        'number_account' => 'partial',
        'created_at' => 'partial'
    ]
)]
#[Vich\Uploadable]
class PaymentMethod
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(
        [
            'read:payment-method:collection',
            'read:payment-method:item',
        ]
    )]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(
        [
            'read:payment-method:collection',
            'read:payment-method:item',
        ]
    )]
    private ?string $name = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(
        [
            'read:payment-method:collection',
            'read:payment-method:item',
        ]
    )]
    private ?string $number_account = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(
        [
            'read:payment-method:collection',
            'read:payment-method:item',
        ]
    )]
    private ?\DateTimeInterface $created_at = null;

    /**
     * @var Collection<int, ChoiceMethodPayment>
     */
    #[ORM\OneToMany(targetEntity: ChoiceMethodPayment::class, mappedBy: 'paymentMethod', orphanRemoval: true)]
    #[Groups(
        [
            'read:payment-method:item',
        ]
    )]
    private Collection $choiceMethodPayments;

    #[Groups(
        [
            'read:payment-method:item',
        ]
    )]
    public ?string $contentUrl = null;

    #[Vich\UploadableField(mapping: "payment_method_image", fileNameProperty: "filePath")]
    public ?File $file = null;

    #[ORM\Column(nullable: true)]
    public ?string $filePath = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(
        [
            'read:payment-method:item',
        ]
    )]
    private ?\DateTimeInterface $updated_at = null;


    public function __construct()
    {
        $this->choiceMethodPayments = new ArrayCollection();
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

    public function getNumberAccount(): ?string
    {
        return $this->number_account;
    }

    public function setNumberAccount(string $number_account): static
    {
        $this->number_account = $number_account;

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
            $choiceMethodPayment->setPaymentMethod($this);
        }

        return $this;
    }

    public function removeChoiceMethodPayment(ChoiceMethodPayment $choiceMethodPayment): static
    {
        if ($this->choiceMethodPayments->removeElement($choiceMethodPayment)) {
            // set the owning side to null (unless already changed)
            if ($choiceMethodPayment->getPaymentMethod() === $this) {
                $choiceMethodPayment->setPaymentMethod(null);
            }
        }

        return $this;
    }

    public function getContentUrl(): ?string
    {
        return $this->contentUrl;
    }


    public function setContentUrl(?string $contentUrl): static
    {
        $this->contentUrl = $contentUrl;

        return $this;
    }


    public function getFile(): File|null
    {
        return $this->file;
    }


    public function setFile(?File $file): static
    {
        $this->file = $file;

        return $this;
    }


    public function getFilePath(): string|null
    {
        return $this->filePath;
    }


    public function setFilePath(?string $filePath): static
    {
        $this->filePath = $filePath;

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
}
