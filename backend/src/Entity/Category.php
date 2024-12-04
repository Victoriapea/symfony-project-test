<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
class Category 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["category", "product"])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Le nom de la catégorie ne peut pas être vide")]
    #[Groups(["category", "product"])]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Product::class)]
    #[Groups(["category"])]
    private Collection $products;

    public function __construct() 
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function setName(string $name): self { $this->name = $name; return $this; }
    
    public function getProducts(): Collection { return $this->products; }
    public function addProduct(Product $product): self 
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setCategory($this);
        }
        return $this;
    }
    public function removeProduct(Product $product): self 
    {
        if ($this->products->removeElement($product)) {
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }
        return $this;
    }
}