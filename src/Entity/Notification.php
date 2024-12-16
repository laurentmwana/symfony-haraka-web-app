<?php

namespace App\Entity;

use App\Owner\UserOwnerInterface;
use App\Repository\NotificationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata as Metadata;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;



#[ORM\Entity(repositoryClass: NotificationRepository::class)]
#[Metadata\ApiResource(
    security: "is_granted('ROLE_USER')",
    operations: [
        new Metadata\Get(
            normalizationContext: [
                'groups' => [
                    'read:notification:item',
                ]
            ],
        ),

        new Metadata\GetCollection(
            normalizationContext: [
                'groups' => [
                    'read:notification:collection',
                ]
            ],
        )
    ],
), Metadata\ApiFilter(
    SearchFilter::class,
    properties: [
        'id' => 'partial',
        'user' => 'partial',
        'title' => 'partial',
        'description' => 'partial',
        'to_route' => 'partial',
        'created_at' => 'partial',
        'eye' => 'partial',
        'eye_at' => 'partial',
    ]
)]
class Notification implements UserOwnerInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(
        [
            'read:notification:collection',
            'read:notification:item',
        ]
    )]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'notifications')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(
        [
            'read:notification:item',
        ]
    )]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    #[Groups(
        [
            'read:notification:collection',
            'read:notification:item',
        ]
    )]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups(
        [
            'read:notification:collection',
            'read:notification:item',
        ]
    )]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(
        [
            'read:notification:collection',
            'read:notification:item',
        ]
    )]
    private ?int $priority = null;

    #[ORM\Column(length: 255)]
    #[Groups(
        [
            'read:notification:collection',
            'read:notification:item',
        ]
    )]
    private ?string $to_route = null;

    #[ORM\Column]
    #[Groups(
        [
            'read:notification:collection',
            'read:notification:item',
        ]
    )]
    private bool $eye = false;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(
        [
            'read:notification:item',
        ]
    )]
    private ?\DateTimeInterface $eye_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(
        [
            'read:notification:collection',
            'read:notification:item',
        ]
    )]
    private ?\DateTimeInterface $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    public function getToRoute(): ?string
    {
        return $this->to_route;
    }

    public function setToRoute(string $to_route): static
    {
        $this->to_route = $to_route;

        return $this;
    }

    public function isEye(): ?bool
    {
        return $this->eye;
    }

    public function setEye(bool $eye): static
    {
        $this->eye = $eye;

        return $this;
    }

    public function getEyeAt(): ?\DateTimeInterface
    {
        return $this->eye_at;
    }

    public function setEyeAt(?\DateTimeInterface $eye_at): static
    {
        $this->eye_at = $eye_at;

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
}
