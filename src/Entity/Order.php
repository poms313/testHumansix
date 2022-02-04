<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $status;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $customer;

    /**
     * @ORM\Column(type="integer")
     */
    private $orderNumber;

    /**
     * @ORM\OneToMany(targetEntity=CartItem::class, mappedBy="orderNumber", orphanRemoval=true, cascade={"persist"})
     */
    private $cartItem;

    public function __construct()
    {
        $this->cartItem = new ArrayCollection();
    }


   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getOrderNumber(): ?int
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(int $orderNumber): self
    {
        $this->orderNumber = $orderNumber;

        return $this;
    }

    /**
     * @return Collection|CartItem[]
     */
    public function getCartItem(): Collection
    {
        return $this->cartItem;
    }

    public function addCartItem(CartItem $cartItem): self
    {
        if (!$this->cartItem->contains($cartItem)) {
            $this->cartItem[] = $cartItem;
            $cartItem->setOrderNumber($this);
        }

        return $this;
    }

    public function removeCartItem(CartItem $cartItem): self
    {
        if ($this->cartItem->removeElement($cartItem)) {
            // set the owning side to null (unless already changed)
            if ($cartItem->getOrderNumber() === $this) {
                $cartItem->setOrderNumber(null);
            }
        }

        return $this;
    }


}
