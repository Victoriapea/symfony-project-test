<?php
namespace App\Controller;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/categories')]
class CategoryController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function index(EntityManagerInterface $em): JsonResponse
    {
        $categories = $em->getRepository(Category::class)->findAll();
        return $this->json($categories, 200, [], [
            'groups' => ['category']
        ]);
    }

    #[Route('', methods: ['POST'])]
    public function create(
        Request $request, 
        EntityManagerInterface $em, 
        ValidatorInterface $validator
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        
        $category = new Category();
        $category->setName($data['name']);

        $errors = $validator->validate($category);
        if (count($errors) > 0) {
            return $this->json($errors, 400);
        }

        $em->persist($category);
        $em->flush();

        return $this->json($category, 201, [], [
            'groups' => ['category']
        ]);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(
        Category $category, 
        Request $request, 
        EntityManagerInterface $em,
        ValidatorInterface $validator
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
        
        $category->setName($data['name']);

        $errors = $validator->validate($category);
        if (count($errors) > 0) {
            return $this->json($errors, 400);
        }

        $em->flush();

        return $this->json($category, 200, [], ['groups' => ['category']]);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(
        Category $category, 
        EntityManagerInterface $em
    ): JsonResponse {
        $em->remove($category);
        $em->flush();

        return $this->json(null, 204);
    }
}
