<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
#[ORM\Table("user_session")]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $user_id = null;

    #[ORM\Column(length: 255)]
    private ?string $sessid = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_entered = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_expired = null;

    public function __construct(?string $name = null,?int $user_id = null)
    {
        if(!empty($name)) $this->setName($name);
        if(!empty($user_id)) $this->setUserId($user_id);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): static
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getSessid(): ?string
    {
        return $this->sessid;
    }

    public function setSessid(string $sessid): static
    {
        $this->sessid = $sessid;

        return $this;
    }

    public function getDateEntered(): ?\DateTimeInterface
    {
        return $this->date_entered;
    }

    public function setDateEntered(\DateTimeInterface $date_entered): static
    {
        $this->date_entered = $date_entered;

        return $this;
    }

    public function getDateExpired(): ?\DateTimeInterface
    {
        return $this->date_expired;
    }

    public function setDateExpired(\DateTimeInterface $date_expired): static
    {
        $this->date_expired = $date_expired;

        return $this;
    }
}
