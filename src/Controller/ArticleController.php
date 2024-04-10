<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use Doctrine\ORM\EntityManager;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class ArticleController extends AbstractController
{
    #[Route('/', name: 'article.index')]
    public function index(): Response
    {
        return $this->render('article/index.html.twig', [
            'controller_name' => 'world',
        ]);
    }

        #[Route('/articles', name: 'article.getAll')]
    public function getAll(ArticleRepository $articleRepository): Response
    {
        // https://github.com/Nvmeless/shop
        return $this->render('article/all.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }
        #[Route('/article/new', name: 'article.create')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
     $article = new Article();
     $form = $this->createForm(ArticleFormType::class,$article);
     $form->handleRequest($request);
     if($form->isSubmitted()){
        $article = $form->getData();

        $entityManager->persist($article);
        $entityManager->flush();
        return $this->redirectToRoute("article_get", ["id" => $article->getId()], Response::HTTP_CREATED);
     }
    //  $today = new \DateTime();
    //  $article->setTitle("Nouvel Article")->setStatus("on")->setCreatedAt($today)->setUpdatedAt($today);
    //  $entityManager->persist($article);
    //  $entityManager->flush();
        return $this->render('article/new.html.twig', [
            'form' => $form,
        ]);

    }
    #[Route('/article/{id}', name: 'article_get')]
    public function get(int $id,ArticleRepository $articleRepository): Response
    {
             return $this->render('article/get.html.twig', [
            'article' => $articleRepository->find($id),
        ]);
    }


}
