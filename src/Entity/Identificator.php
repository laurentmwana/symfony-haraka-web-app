<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\IdentificatorRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: IdentificatorRepository::class)]
#[Vich\Uploadable]
class Identificator
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'identificator', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Student $student = null;

    public ?string $contentUrl = null;

    #[Vich\UploadableField(mapping: "qrcode_student", fileNameProperty: "filePath")]
    public ?File $file = null;

    #[ORM\Column()]
    public ?string $filePath = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    public function __construct()
    {
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(Student $student): static
    {
        $this->student = $student;

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
}
