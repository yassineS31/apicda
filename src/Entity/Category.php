<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/category/{id}', 
            requirements: ['id' => '\d+'],
            ),
        new GetCollection(
            uriTemplate: '/categories',
            ),
        new Post(
            uriTemplate:'/category',
            status:201
        ),
        new Delete(
            uriTemplate:'/category/{id}',
            requirements: ['id' => '\d+'],
            status:204
        ),
        new Put(
            uriTemplate:'/category/{id}',
            requirements:['id'=> '\d+'],
            status:201
        ),
        new Patch(
            uriTemplate:'/category',
            status:201
        )
    ],
    order: ['id' => 'ASC', 'label' => 'ASC'],
    paginationEnabled: false
)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['product:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['product:item'])]
    private ?string $label = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }
}
