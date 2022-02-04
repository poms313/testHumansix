<?php

namespace App\Entity;

use App\Repository\ActualCartItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActualCartItemRepository::class)
 */
class ActualCartItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $itemQuantity;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getItemQuantity(): ?int
    {
        return $this->itemQuantity;
    }

    public function setItemQuantity(int $itemQuantity): self
    {
        $this->itemQuantity = $itemQuantity;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }
}
