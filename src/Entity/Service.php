<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $service = null;

    /**
     * @var Collection<int, Products>
     */
    #[ORM\OneToMany(targetEntity: Products::class, mappedBy: 'service')]
    private Collection $product;

    public function __construct()
    {
        $this->product = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getService(): ?string
    {
        return $this->service;
    }

    public function setService(string $service): static
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return Collection<int, Products>
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(Products $product): static
    {
        if (!$this->product->contains($product)) {
            $this->product->add($product);
            $product->setService($this);
        }

        return $this;
    }

    public function removeProduct(Products $product): static
    {
        if ($this->product->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getService() === $this) {
                $product->setService(null);
            }
        }

        return $this;
    }
}
