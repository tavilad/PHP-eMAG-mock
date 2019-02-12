<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserPaymentMethodRepository")
 */
class UserPaymentMethod
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="userPaymentMethod", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $user_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $credit_card_number;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $credit_card_expiration_date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getCreditCardNumber(): ?string
    {
        return $this->credit_card_number;
    }

    public function setCreditCardNumber(string $credit_card_number): self
    {
        $this->credit_card_number = $credit_card_number;

        return $this;
    }

    public function getCreditCardExpirationDate(): ?string
    {
        return $this->credit_card_expiration_date;
    }

    public function setCreditCardExpirationDate(string $credit_card_expiration_date): self
    {
        $this->credit_card_expiration_date = $credit_card_expiration_date;

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getId();
    }

}
