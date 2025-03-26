<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/product/{id}', 
            requirements: ['id' => '\d+'],
            normalizationContext: ['groups' => 'product:item']
            ),
        new GetCollection(
            uriTemplate: '/products',
            ),
        new Post(
            uriTemplate:'/product',
            status:201
        ),
        new Delete(
            uriTemplate:'/product/{id}',
            requirements: ['id' => '\d+'],
            status:204
        ),
        new Put(
            uriTemplate:'/product/{id}',
            requirements:['id'=> '\d+'],
            status:201
        ),
        new Patch(
            uriTemplate:'/product',
            status:201
        )
    ],
    order: ['id' => 'ASC', 'name' => 'ASC'],
    paginationEnabled: true
)]

class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['product:item'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['product:item'])]
    private ?float $price = null;

    /**
     * @var Collection<int, Category>
     */
    #[ORM\ManyToMany(targetEntity: Category::class)]
    #[Groups(['product:item'])]
    private Collection $categories;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }
}
