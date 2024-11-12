<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController{

    #[Route('/articles-list', name: 'articles_list')]
        public function findAllArticles(ArticleRepository $articleRepository) :Response{
            $articles = $articleRepository->findAll();
            return $this->render('public/page/article/articles_list.html.twig', [
                'articles' => $articles
            ]);
    }

    #[Route('/article-detail/{articleId}', name: 'article_detail')]
    public function findArticleById( int $articleId, ArticleRepository $articleRepository) :Response{
        $article = $articleRepository->find($articleId);

        if(!$article){
            return $this->render('public/page/404.html.twig', []);
        }

//        dd($article);

        return $this->render('public/page/article/article_detail.html.twig', [
            'article' => $article
        ]);
    }

}