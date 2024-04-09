<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/article', name: "article")]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'article.index')]
    public function index(): Response
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'world',
        ]);
    }

        #[Route('/all', name: 'article.getAll')]
    public function getAll(ArticleRepository $articleRepository): Response
    {
        dd($articleRepository->findAll());
        return $this->render('article/all.html.twig', [
            'articles' => [
                ["title" =>"Super Atricle 1"],
                ["title" =>"Super Atricle2"],
                ["title" =>"Super Atricle4"],
                ["title" =>"Super Atricle3"],
                ["title" =>"Super Atricle5"],
                ["title" =>"Super Atricle6"],
                ["title" =>"Super Atricle7"],
                ["title" =>"Super Atricle8"],
            ],
        ]);
    }


}
