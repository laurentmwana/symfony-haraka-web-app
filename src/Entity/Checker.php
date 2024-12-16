<?php

namespace App\Entity;

use App\Enum\GenderEnum;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CheckerRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Validator;
use ApiPlatform\Metadata as Metadata;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: CheckerRepository::class)]
#[UniqueEntity(['number_phone'])]
#[Metadata\ApiResource(
    operations: [
        new Metadata\Get(
            normalizationContext: [
                'groups' => [
                    'read:checker:item',
                ]
            ],
        ),
        new Metadata\GetCollection(
            normalizationContext: [
                'groups' => [
                    'read:checker:collection',
                ]
            ],
        )
    ],
), Metadata\ApiFilter(
    SearchFilter::class,
    properties: [
        'id' => 'partial',
        'name' => 'partial',
        'firstname' => 'partial',
        'gender' => 'partial',
        'happy' => 'partial',
        'number_phone' => 'partial',
        'created_at' => 'partial'
    ]
)]

class Checker
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(
        [
            'read:checker:collection',
            'read:checker:item',
        ]
    )]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Validator\NotBlank()]
    #[Validator\Length(min: 3, max: 255)]
    #[Groups(
        [
            'read:checker:collection',
            'read:checker:item',
        ]
    )]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Validator\NotBlank()]
    #[Validator\Length(min: 3, max: 255)]
    #[Groups(
        [
            'read:checker:collection',
            'read:checker:item',
        ]
    )]
    private ?string $firstname = null;

    #[ORM\Column(enumType: GenderEnum::class)]
    #[Validator\NotBlank()]
    #[Groups(
        [
            'read:checker:collection',
            'read:checker:item',
        ]
    )]
    private ?GenderEnum $gender = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Validator\NotBlank()]
    #[Groups(
        [
            'read:checker:collection',
            'read:checker:item',
        ]
    )]
    private ?string $number_phone = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(
        [
            'read:checker:collection',
            'read:checker:item',
        ]
    )]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(
        [
            'read:checker:collection',
            'read:checker:item',
        ]
    )]
    private ?\DateTimeInterface $updated_at = null;


    #[ORM\OneToOne(mappedBy: 'checker', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    public function __construct()
    {
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getGender(): ?GenderEnum
    {
        return $this->gender;
    }

    public function setGender(GenderEnum $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getNumberPhone(): ?string
    {
        return $this->number_phone;
    }

    public function setNumberPhone(string $number_phone): static
    {
        $this->number_phone = $number_phone;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setChecker(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getChecker() !== $this) {
            $user->setChecker($this);
        }

        $this->user = $user;

        return $this;
    }
}
