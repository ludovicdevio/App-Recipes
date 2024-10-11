<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RecipeController extends AbstractController
{
    #[Route('/recettes', name: 'recipe.index')]
    public function index(Request $request, RecipeRepository $repository, EntityManagerInterface $em): Response{
        $recipes = $repository->findWithDurationLowerThan(30);
        /*$em->remove($recipes[0]);
        $em->flush();*/ // pour supprimer une recette

        /*$recipes = new Recipe();
        $recipes->setTitle('Barbe à papa')
            ->setSlug('barbe-a-papa')
            ->setContent('Recette de la barbe à papa')
            ->setDuration(2)
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUpdatedAt(new \DateTimeImmutable());
        $em->persist($recipes);
        $em->flush();*/ // pour ajouter une recette


       /*$recipes[0]->setTitle(' Pâtes bolognaise');
        $em->flush();*/ // pour modifier un titre

        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes
        ]);


    }

    #[Route('/recette/{slug}-{id}', name: 'recipe.show', requirements: ['slug' => '[a-z0-9\-]+', 'id' => '\d+'])]
    public function show(Request $request, string $slug, int $id, RecipeRepository $repository): Response{

        $recipe = $repository->find($id);
        if($recipe->getSlug() !== $slug){
            return $this->redirectToRoute('recipe.show', ['slug' => $recipe->getSlug(), 'id' => $id]);
        }
        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipe
        ]);
    }
}






















