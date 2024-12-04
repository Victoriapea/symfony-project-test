<?php
namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/products')]
class ProductController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function index(EntityManagerInterface $em): JsonResponse
    {
        $products = $em->getRepository(Product::class)->findAll();
        return $this->json($products, 200, [], [
            'groups' => ['product']
        ]);
    }

    #[Route('', methods: ['POST'])]
    public function create(
        Request $request, 
        EntityManagerInterface $em,
        ValidatorInterface $validator
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        
        $product = new Product();
        $product->setName($data['name']);
        $product->setDescription($data['description'] ?? null);
        $product->setPrice($data['price']);

        $category = $em->getRepository(Category::class)->find($data['categoryId']);
        if (!$category) {
            return $this->json(['error' => 'Catégorie non trouvée'], 404);
        }
        $product->setCategory($category);

        $errors = $validator->validate($product);
        if (count($errors) > 0) {
            return $this->json($errors, 400);
        }

        $em->persist($product);
        $em->flush();

        return $this->json($product, 201, [], ['groups' => ['product']]);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(
        Product $product, 
        Request $request, 
        EntityManagerInterface $em,
        ValidatorInterface $validator
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        
        if (isset($data['name'])) $product->setName($data['name']);
        if (isset($data['description'])) $product->setDescription($data['description']);
        if (isset($data['price'])) $product->setPrice($data['price']);

        if (isset($data['categoryId'])) {
            $category = $em->getRepository(Category::class)->find($data['categoryId']);
            if (!$category) {
                return $this->json(['error' => 'Catégorie non trouvée'], 404);
            }
            $product->setCategory($category);
        }

        $errors = $validator->validate($product);
        if (count($errors) > 0) {
            return $this->json($errors, 400);
        }

        $em->flush();

        return $this->json($product, 200, [], ['groups' => ['product']]);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(
        Product $product, 
        EntityManagerInterface $em
    ): JsonResponse {
        $em->remove($product);
        $em->flush();

        return $this->json(null, 204);
    }
}
