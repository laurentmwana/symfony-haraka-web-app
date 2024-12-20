<?php

namespace App\Entity;

use App\Enum\PaidEnum;
use App\Owner\UserStudentOwnerInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PaidRepository;
use ApiPlatform\Metadata as Metadata;
use App\Controller\APIs\PaidStudentController;
use Symfony\Component\HttpFoundation\File\File;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: PaidRepository::class)]
#[Metadata\ApiResource(
    security: "is_granted('ROLE_USER')",
    operations: [
        new Metadata\Get(
            normalizationContext: [
                'groups' => [
                    'read:paid:item',
                ]
            ],
        ),
        new Metadata\Post(
            uriTemplate: '/verify-response-qrcode/{token}',
            controller: PaidStudentController::class,
            normalizationContext: [
                'groups' => [
                    'read:paid:state',
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
#[Vich\Uploadable]
class Paid implements UserStudentOwnerInterface
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
            'read:level:item',
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
            'read:level:item'
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

    #[Groups(
        [
            'read:paid:collection',
            'read:paid:item',
            'read:level:item',
        ]
    )]
    public ?string $contentUrl = null;

    #[Vich\UploadableField(mapping: "qrcode_slip", fileNameProperty: "filePath")]
    public ?File $file = null;

    #[ORM\Column(nullable: true)]
    public ?string $filePath = null;

    #[ORM\Column(length: 255)]
    #[Groups(
        [
            'read:paid:collection',
            'read:paid:item',
            'read:level:item',
        ]
    )]
    private ?string $token = null;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
        $this->state = PaidEnum::NO_PAID;
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

        if ($file) {
            // Mettez à jour `updated_at` pour que VichUploader puisse détecter le changement
            $this->updated_at = new \DateTime();
        }

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

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): static
    {
        $this->token = $token;

        return $this;
    }
}
