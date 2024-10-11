<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Validator;
use ApiPlatform\Metadata as Metadata;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: ContactRepository::class)]
#[Metadata\ApiResource(
    denormalizationContext: [
        'groups' => ['write:contact']
    ],
    normalizationContext: [
        'groups' => ['read:contact:item']
    ],
    operations: [
        new Metadata\Post(),
    ],
)]

class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(
        [
            'read:contact:item',
        ]
    )]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Validator\NotBlank()]
    #[Validator\Length(min: 2, max: 255)]
    #[Groups(
        [
            'read:contact:item',
            'write:contact',
        ]
    )]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Validator\NotBlank()]
    #[Validator\Length(max: 255)]
    #[Validator\Email()]
    #[Groups(
        [
            'read:contact:item',
            'write:contact',
        ]
    )]
    private ?string $email = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Validator\NotBlank()]
    #[Validator\Length(min: 5, max: 500)]
    #[Groups(
        [
            'read:contact:item',
            'write:contact',
        ]
    )]
    private ?string $subject = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Validator\NotBlank()]
    #[Validator\Length(min: 20, max: 8000)]
    #[Groups(
        [
            'read:contact:item',
            'write:contact',
        ]
    )]
    private ?string $message = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    public function __construct()
    {
        $this->created_at = new \DateTime();
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

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
