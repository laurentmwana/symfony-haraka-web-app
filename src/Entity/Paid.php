<?php

namespace App\Entity;

use App\Enum\PaidEnum;
use App\Repository\PaidRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata as Metadata;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: PaidRepository::class)]
#[Metadata\ApiResource(
    operations: [
        new Metadata\Get(
            normalizationContext: [
                'groups' => [
                    'read:paid:item',
                ]
            ],
        ),
        new Metadata\GetCollection(
            normalizationContext: [
                'groups' => [
                    'read:paid:collection',
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
        'created_at' => 'partial'
    ]
)]
class Paid
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(
        [
            'read:paid:collection',
            'read:paid:item',
        ]
    )]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'paids')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(
        [
            'read:paid:collection',
            'read:paid:item',
        ]
    )]
    private ?Student $student = null;

    #[ORM\ManyToOne(inversedBy: 'paids')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(
        [
            'read:paid:collection',
            'read:paid:item',
        ]
    )]
    private ?Level $level = null;

    #[ORM\Column(enumType: PaidEnum::class)]
    #[Groups(
        [
            'read:paid:collection',
            'read:paid:item',
        ]
    )]
    private ?PaidEnum $state = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(
        [
            'read:paid:collection',
            'read:paid:item',
        ]
    )]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(
        [
            'read:paid:item',
        ]
    )]
    private ?\DateTimeInterface $updated_at = null;

    /**
     * @var Collection<int, Qrcode>
     */
    #[ORM\OneToMany(targetEntity: Qrcode::class, mappedBy: 'paid', orphanRemoval: true)]

    private Collection $qrcodes;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
        $this->state = PaidEnum::NO_PAID;
        $this->qrcodes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): static
    {
        $this->student = $student;

        return $this;
    }

    public function getLevel(): ?Level
    {
        return $this->level;
    }

    public function setLevel(?Level $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getState(): ?PaidEnum
    {
        return $this->state;
    }

    public function setState(PaidEnum $state): static
    {
        $this->state = $state;

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
     * @return Collection<int, Qrcode>
     */
    public function getQrcodes(): Collection
    {
        return $this->qrcodes;
    }

    public function addQrcode(Qrcode $qrcode): static
    {
        if (!$this->qrcodes->contains($qrcode)) {
            $this->qrcodes->add($qrcode);
            $qrcode->setPaid($this);
        }

        return $this;
    }

    public function removeQrcode(Qrcode $qrcode): static
    {
        if ($this->qrcodes->removeElement($qrcode)) {
            // set the owning side to null (unless already changed)
            if ($qrcode->getPaid() === $this) {
                $qrcode->setPaid(null);
            }
        }

        return $this;
    }
}
