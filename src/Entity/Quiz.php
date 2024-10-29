<?php

namespace App\Entity;

use App\Repository\QuizRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Validator;
use ApiPlatform\Metadata as Metadata;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: QuizRepository::class)]
#[UniqueEntity('request')]
#[Metadata\ApiResource(
    operations: [
        new Metadata\Get(
            normalizationContext: [
                'groups' => [
                    'read:quiz:item',
                ]
            ],
        ),
        new Metadata\GetCollection(
            normalizationContext: [
                'groups' => [
                    'read:quiz:collection',
                ]
            ],
        )
    ],
), Metadata\ApiFilter(
    SearchFilter::class,
    properties: [
        'id' => 'partial',
        'request' => 'partial',
        'response' => 'partial',
        'created_at' => 'partial'
    ]
)]
class Quiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(
        [
            'read:quiz:collection',
            'read:quiz:item',
        ]
    )]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, unique: true)]
    #[Validator\NotBlank()]
    #[Validator\Length(min: 5, max: 4078)]
    #[Groups(
        [
            'read:quiz:collection',
            'read:quiz:item',
        ]
    )]
    private ?string $request = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Validator\NotBlank()]
    #[Validator\Length(min: 20, max: 5000)]
    #[Groups(
        [
            'read:quiz:collection',
            'read:quiz:item',
        ]
    )]
    private ?string $response = null;

    #[ORM\Column]
    #[Groups(
        [
            'read:quiz:collection',
            'read:quiz:item',
        ]
    )]
    private ?bool $featured = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(
        [
            'read:quiz:collection',
            'read:quiz:item',
        ]
    )]
    private ?\DateTimeInterface $created_at = null;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->featured = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRequest(): ?string
    {
        return $this->request;
    }

    public function setRequest(string $request): static
    {
        $this->request = $request;

        return $this;
    }

    public function getResponse(): ?string
    {
        return $this->response;
    }

    public function setResponse(string $response): static
    {
        $this->response = $response;

        return $this;
    }

    public function isFeatured(): ?bool
    {
        return $this->featured;
    }

    public function setFeatured(bool $featured): static
    {
        $this->featured = $featured;

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
