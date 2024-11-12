<?php

namespace App\Controller\admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminArticleController extends AbstractController{

    #[Route('/admin/articles-list', name: 'admin_articles_list')]
    public function adminFindAllArticles(ArticleRepository $articleRepository){
        $articles = $articleRepository->findAll();
//        dd($articles);
        return $this->render('admin/page/article/admin_articles_list.html.twig', [
            'articles' => $articles
        ]);
    }

    #[Route('/admin/article-delete/{articleId}', name: 'admin_articles_delete')]
    public function adminDeleteArticle(int $articleId, EntityManagerInterface $entityManager ,ArticleRepository $articleRepository){
        $article = $articleRepository->find($articleId);

        if(!$article){
            $html404 = $this->renderView('admin/page/404.html.twig');
            return new Response($html404, 404);
        }

        try{
            $entityManager->remove($article);
            $entityManager->flush();
            $this->addFlash('success', 'Article deleted successfully');
        } catch (\Exception $exception){
            return $this->renderView('admin/page/error.html.twig', [
                'errorMessage' => $exception->getMessage()
            ]);
        }
            return $this->redirectToRoute('admin_articles_list');
    }


    #[Route('/admin/add-article', name: 'admin_articles_add')]
    public function AddArticle(Request $request,EntityManagerInterface $entityManager, ArticleRepository $articleRepository){
        $article = new Article();
        $articleForm = $this->createForm(ArticleType::class, $article);
        $articleForm->handleRequest($request);

        if($articleForm->isSubmitted() && $articleForm->isValid()){
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', 'Article added successfully');
            return $this->redirectToRoute('admin_articles_list');
        }

        return $this->render('admin/page/article/add_article.html.twig' , [
            'articleForm' => $articleForm->createView()
        ]);
    }

    #[Route('admin/article-update/{articleId}', name: 'admin_article_update')]
    public function updateArticle(int $articleId, Request $request, ArticleRepository $articleRepository, EntityManagerInterface $entityManager){

        $article = $articleRepository->find($articleId);
        $articleForm = $this->createForm(ArticleType::class, $article);
        $articleForm->handleRequest($request);

        if($articleForm->isSubmitted() && $articleForm->isValid()){
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', 'Article updated successfully');
            return $this->redirectToRoute('admin_articles_list');
        }

        return $this->render('admin/page/article/add_article.html.twig' , [
            'articleForm' => $articleForm->createView()
        ]);
    }
}