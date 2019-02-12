<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserType", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    /**
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\UserContactInfo", mappedBy="user_id", cascade={"persist", "remove"})
     */
    private $userContactInfo;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\UserPaymentMethod", mappedBy="user_id", cascade={"persist", "remove"})
     */
    private $userPaymentMethod;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Orders", mappedBy="user_id")
     */
    private $orders;

    /**
     * @Assert\Length(max=4096)
     */
    protected $plainPassword;


    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $role;



    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->User = new ArrayCollection();
    }

    public function eraseCredentials()
    {
        return null;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role = null)
    {
        $this->role = $role;
    }

    public function getRoles()
    {
        return [$this->getRole()];
    }

    public function getUserType(): ?UserType
    {
        return $this->user_type;
    }

    public function setUserType(?UserType $user_type): self
    {
        $this->user_type = $user_type;

        return $this;
    }

    public function getUserContactInfo(): ?UserContactInfo
    {
        return $this->userContactInfo;
    }

    public function setUserContactInfo(UserContactInfo $userContactInfo): self
    {
        $this->userContactInfo = $userContactInfo;

        // set the owning side of the relation if necessary
        if ($this !== $userContactInfo->getUserId()) {
            $userContactInfo->setUserId($this);
        }

        return $this;
    }

    public function getUserPaymentMethod(): ?UserPaymentMethod
    {
        return $this->userPaymentMethod;
    }

    public function setUserPaymentMethod(UserPaymentMethod $userPaymentMethod): self
    {
        $this->userPaymentMethod = $userPaymentMethod;

        // set the owning side of the relation if necessary
        if ($this !== $userPaymentMethod->getUserId()) {
            $userPaymentMethod->setUserId($this);
        }

        return $this;
    }

    public function __toString()
    {
        return (string) $this->getId();
    }

    /**
     * @return Collection|Orders[]
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Orders $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders[] = $order;
            $order->setUserId($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): self
    {
        if ($this->orders->contains($order)) {
            $this->orders->removeElement($order);
            // set the owning side to null (unless already changed)
            if ($order->getUserId() === $this) {
                $order->setUserId(null);
            }
        }

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function setUsername($username){
        $this->username=$username;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }

    public function getSalt()
    {
        return null;
    }
}
