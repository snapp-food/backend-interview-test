<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RestaurantRepository")
 * @ORM\Table(name="restaurants")
 */
class Restaurant
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"restaurant.list", "restaurant.detail"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Groups({"restaurant.list", "restaurant.detail"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Groups({"restaurant.detail"})
     */
    private $status;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"restaurant.detail"})
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Groups({"restaurant.detail"})
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="restaurant", orphanRemoval=true)
     * @Groups({"restaurant.detail"})
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setRestaurant($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getRestaurant() === $this) {
                $product->setRestaurant(null);
            }
        }

        return $this;
    }
}
