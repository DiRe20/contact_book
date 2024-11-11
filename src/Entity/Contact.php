<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    const string CATEGORY_FAMILY = 'Family';
    const string CATEGORY_WORK = 'Work';
    const string CATEGORY_FRIENDS = 'Friends';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $category = null;

    #[ORM\Column(length: 30)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthday = null;

    /**
     * @var Collection<int, ContactPhone>
     */
    #[ORM\OneToMany(targetEntity: ContactPhone::class, mappedBy: 'contact', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $contactPhones;

    /**
     * @var Collection<int, ContactEmail>
     */
    #[ORM\OneToMany(targetEntity: ContactEmail::class, mappedBy: 'contact', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $contactEmails;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->contactPhones = new ArrayCollection();
        $this->contactEmails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

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

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(\DateTimeInterface $birthday): static
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * @return Collection<int, ContactPhone>
     */
    public function getContactPhones(): Collection
    {
        return $this->contactPhones;
    }

    public function addContactPhone(ContactPhone $contactPhone): static
    {
        if (!$this->contactPhones->contains($contactPhone)) {
            $this->contactPhones->add($contactPhone);
            $contactPhone->setContact($this);
        }

        return $this;
    }

    public function removeContactPhone(ContactPhone $contactPhone): static
    {
        if ($this->contactPhones->removeElement($contactPhone)) {
            // set the owning side to null (unless already changed)
            if ($contactPhone->getContact() === $this) {
                $contactPhone->setContact(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ContactEmail>
     */
    public function getContactEmails(): Collection
    {
        return $this->contactEmails;
    }

    public function addContactEmail(ContactEmail $contactEmail): static
    {
        if (!$this->contactEmails->contains($contactEmail)) {
            $this->contactEmails->add($contactEmail);
            $contactEmail->setContact($this);
        }

        return $this;
    }

    public function removeContactEmail(ContactEmail $contactEmail): static
    {
        if ($this->contactEmails->removeElement($contactEmail)) {
            // set the owning side to null (unless already changed)
            if ($contactEmail->getContact() === $this) {
                $contactEmail->setContact(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function is5orLessDaysToBirthday()
    {
        $birthdayTheseYear = (clone $this->getBirthday())->setDate((new \DateTime())->format('Y'),$this->getBirthday()->format('m'), $this->getBirthday()->format('d'));
        $diff = (new \DateTime())->diff($birthdayTheseYear);
        if ($diff->invert == 1 and $diff->days != 0) return null;

        if ($diff->days > 5) return null;
        return $diff->days;
    }
}
