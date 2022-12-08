<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use App\Form\CategoryType;
use App\Entity\Category;

class  CategoryController extends AbstractController
{
    #[Route('/category/', name: 'category_index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/category/show/{categoryName}', name: 'category_show')]
    public function show(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $programRepository):Response
    {
        $category = $categoryRepository->findBy(['name' => $categoryName]);

        if (!$category) {
            throw $this->createNotFoundException(
                'No program with id : '.$categoryName.' found in category\'s table.'
            );
        }

        $programs = $programRepository->findby(['category' => $category], ['id' => 'DESC'], limit:3);

        return $this->render('category/show.html.twig', [
            'programs' => $programs,
            'category' => $category,
        ]);
    }

    #[Route('/category/new', name: 'new_category')]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        $category = new Category();
        // Create the form, linked with $category
        $form = $this->createForm(CategoryType::class, $category);
        // Get data from HTTP request
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted() && $form->isValid()) {
            $categoryRepository->save($category, true);
        }
        // Render the form (best practice)
        return $this->renderForm('category/new.html.twig', [
            'form' => $form,
            'categories' => $categories,
        ]);
        // Alternative
        // return $this->render('category/new.html.twig', [
        //   'form' => $form->createView(),
        // ]);

    }
}