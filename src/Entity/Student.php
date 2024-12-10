<?php

namespace App\Entity;

use App\Enum\GenderEnum;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata as Metadata;
use App\Repository\StudentRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Validator;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;



#[ORM\Entity(repositoryClass: StudentRepository::class)]
#[UniqueEntity(['number_phone'])]
#[Metadata\ApiResource(
    operations: [
        new Metadata\Get(
            normalizationContext: [
                'groups' => [
                    'read:student:item',
                ]
            ],
        ),
        new Metadata\GetCollection(
            normalizationContext: [
                'groups' => [
                    'read:student:collection',
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
#[Vich\Uploadable]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(
        [
            'read:student:collection',
            'read:student:item',
            'read:payment:collection',
            'read:payment:item',
        ]
    )]
    private ?int $id = null;

    /**
     * @var Collection<int, Level>
     */
    #[ORM\ManyToMany(targetEntity: Level::class, inversedBy: 'students', cascade: ['persist'])]
    #[Groups(
        [
            'read:student:item',
        ]
    )]
    private Collection $levels;

    #[ORM\Column(length: 255)]
    #[Validator\NotBlank()]
    #[Validator\Length(min: 3, max: 255)]
    #[Groups(
        [
            'read:student:collection',
            'read:student:item',
            'read:payment:collection',
            'read:payment:item',
        ]
    )]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Validator\NotBlank()]
    #[Validator\Length(min: 2, max: 255)]
    #[Groups(
        [
            'read:student:collection',
            'read:student:item',
            'read:payment:collection',
            'read:payment:item',
        ]
    )]
    private ?string $firstname = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Validator\Length(min: 2, max: 255)]
    #[Groups(
        [
            'read:student:item',
        ]
    )]
    private ?string $lastname = null;

    #[ORM\Column(enumType: GenderEnum::class)]
    #[Validator\NotBlank()]
    #[Groups(
        [
            'read:student:collection',
            'read:student:item',
            'read:payment:collection',
            'read:payment:item',
        ]
    )]
    private ?GenderEnum $gender = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Validator\NotBlank()]
    #[Groups(
        [
            'read:student:item',
        ]
    )]
    private ?\DateTimeInterface $happy = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Validator\NotBlank()]
    #[Validator\Length(min: 2, max: 255)]
    #[Groups(
        [
            'read:student:item',
        ]
    )]
    private ?string $number_phone = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(
        [
            'read:student:collection',
            'read:student:item',
        ]
    )]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(
        [
            'read:student:item',
        ]
    )]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\OneToOne(mappedBy: 'student', cascade: ['persist', 'remove'])]
    #[Groups([
        'student:validator:actual',
        'read:student:item'
    ])]
    private ?ActualLevel $actualLevel = null;

    #[ORM\OneToOne(mappedBy: 'student', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    /**
     * @var Collection<int, Paid>
     */
    #[ORM\OneToMany(targetEntity: Paid::class, mappedBy: 'student', orphanRemoval: true)]
    #[Groups(
        [
            'read:student:item',
        ]
    )]
    private Collection $paids;

    /**
     * @var Collection<int, Payment>
     */
    #[ORM\OneToMany(targetEntity: Payment::class, mappedBy: 'student', orphanRemoval: true)]
    #[Groups(
        [
            'read:student:item',
        ]
    )]
    private Collection $payments;
    public ?string $contentUrl = null;

    #[Vich\UploadableField(mapping: "qrcode_student", fileNameProperty: "identificatorPath")]
    public ?File $identificator = null;

    #[ORM\Column()]
    public ?string $identificatorPath = null;

    public function __construct()
    {
        $this->levels = new ArrayCollection();

        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
        $this->paids = new ArrayCollection();
        $this->payments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Level>
     */
    public function getLevels(): Collection
    {
        return $this->levels;
    }

    public function addLevel(Level $level): static
    {
        if (!$this->levels->contains($level)) {
            $this->levels->add($level);
        }

        return $this;
    }

    public function removeLevel(Level $level): static
    {
        $this->levels->removeElement($level);

        return $this;
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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): static
    {
        $this->lastname = $lastname;

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

    public function getHappy(): ?\DateTimeInterface
    {
        return $this->happy;
    }

    public function setHappy(\DateTimeInterface $happy): static
    {
        $this->happy = $happy;

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

    public function getActualLevel(): ?ActualLevel
    {
        return $this->actualLevel;
    }

    public function setActualLevel(ActualLevel $actualLevel): static
    {
        // set the owning side of the relation if necessary
        if ($actualLevel->getStudent() !== $this) {
            $actualLevel->setStudent($this);
        }

        $this->actualLevel = $actualLevel;

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
            $this->user->setStudent(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getStudent() !== $this) {
            $user->setStudent($this);
        }

        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Paid>
     */
    public function getPaids(): Collection
    {
        return $this->paids;
    }

    public function addPaid(Paid $paid): static
    {
        if (!$this->paids->contains($paid)) {
            $this->paids->add($paid);
            $paid->setStudent($this);
        }

        return $this;
    }

    public function removePaid(Paid $paid): static
    {
        if ($this->paids->removeElement($paid)) {
            // set the owning side to null (unless already changed)
            if ($paid->getStudent() === $this) {
                $paid->setStudent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): static
    {
        if (!$this->payments->contains($payment)) {
            $this->payments->add($payment);
            $payment->setStudent($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): static
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getStudent() === $this) {
                $payment->setStudent(null);
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
    public function getIdentificator(): File|null
    {
        return $this->identificator;
    }
    public function setIdentificator(?File $identificator): static
    {
        $this->identificator = $identificator;

        if ($identificator) {
            // Mettez à jour `updated_at` pour que VichUploader puisse détecter le changement
            $this->updated_at = new \DateTime();
        }

        return $this;
    }

    public function getIdentificatorPath(): string|null
    {
        return $this->identificatorPath;
    }

    public function setIdentificatorPath(?string $identificatorPath): static
    {
        $this->identificatorPath = $identificatorPath;

        return $this;
    }
}
