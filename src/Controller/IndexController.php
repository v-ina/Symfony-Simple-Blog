<?php

namespace App\Controller;
//아니 이거 열받네. 지가 자동으로 app/controllers라고 적었으면서 결국 대문자에 복수형도 아님

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController{

    #[Route('/', name: 'home')]
    public function indexAction(){
//        dd('test');
        return $this->render('public/page/index.html.twig');
    }

}

