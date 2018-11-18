<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\Table(name="products")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"product.detail", "product.list"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"product.detail", "product.list"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Restaurant", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"product.detail"})
     */
    private $restaurant;

    /**
     * @ORM\Column(type="float")
     * @Groups({"product.detail", "product.list"})
     */
    private $price;

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

    public function getRestaurant(): ?Restaurant
    {
        return $this->restaurant;
    }

    public function setRestaurant(?Restaurant $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }
}
