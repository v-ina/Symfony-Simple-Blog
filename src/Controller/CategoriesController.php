<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController{

    #[Route('categories-list', name: 'categories_list')]
    public function findAllCategories(CategoryRepository $categoryRepository){
        $categories = $categoryRepository->findAll();

        return $this->render('public/page/category/categories_list.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('category-detail/{categoryId}', name: 'category_detail')]
    public function findCategoriesByid( int $categoryId,CategoryRepository $categoryRepository, ArticleRepository $articleRepository){
        $category = $categoryRepository->find($categoryId);
        $articles = $articleRepository->findBy(['category' => $category]);

        return $this->render('public/page/category/category_detail.html.twig', [
            'category' => $category, 'articles' => $articles
        ]);
    }
}