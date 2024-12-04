<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups; 

#[ORM\Entity]
class Product 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["product", "category"])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Le nom du produit ne peut pas être vide")]
    #[Groups(["product", "category"])] 
    private string $name;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Groups(["product"])]
    private ?string $description = null;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 2)]
    #[Assert\Positive(message: "Le prix doit être positif")]
    #[Groups(["product"])]
    private float $price;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["product"])]
    private Category $category;

    #[ORM\Column(type: 'datetime')]
    #[Groups(["product"])]
    private \DateTimeInterface $createdAt;

    public function __construct() 
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int { return $this->id; }
    
    public function getName(): string { return $this->name; }
    public function setName(string $name): self { $this->name = $name; return $this; }
    
    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): self { $this->description = $description; return $this; }
    
    public function getPrice(): float { return $this->price; }
    public function setPrice(float $price): self { $this->price = $price; return $this; }
    
    public function getCategory(): Category { return $this->category; }
    public function setCategory(?Category $category): self { $this->category = $category; return $this; }
    
    public function getCreatedAt(): \DateTimeInterface { return $this->createdAt; }
}