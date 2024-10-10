<?php

namespace App\Entity;

use App\Repository\QrcodeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QrcodeRepository::class)]
class Qrcode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'qrcodes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Paid $paid = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $qrcode_at = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPaid(): ?Paid
    {
        return $this->paid;
    }

    public function setPaid(?Paid $paid): static
    {
        $this->paid = $paid;

        return $this;
    }

    public function getQrcodeAt(): ?\DateTimeInterface
    {
        return $this->qrcode_at;
    }

    public function setQrcodeAt(\DateTimeInterface $qrcode_at): static
    {
        $this->qrcode_at = $qrcode_at;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }
}
