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
            'articles' => $articleRepository->findByStatusOn(),
        ]);
    }
    #[Route('/article/new', name: 'article.create')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

    $article = new Article();
     $form = $this->createForm(ArticleFormType::class,$article, ["save_button_label" => "Creer un Article"]);
     $form->handleRequest($request);
     if($form->isSubmitted()){
        $today = new \DateTime();

        $article = $form->getData();
        foreach ($article->getCategories() as $category) {
            $category->addArticle($article);
        }
        $article->setCreatedAt($today)->setUpdatedAt( $today )->setStatus("on");
        $entityManager->persist($article);
        $entityManager->flush();
        return $this->redirectToRoute("article.get", ["id" => $article->getId()], Response::HTTP_CREATED);
     }
    //  $article->setTitle("Nouvel Article")->setStatus("on")->setCreatedAt($today)->setUpdatedAt($today);
    //  $entityManager->persist($article);
    //  $entityManager->flush();
        return $this->render('article/new.html.twig', [
            'form' => $form,
        ]);

    }
        #[Route('/article/update/{id}', name: 'article.update')]
    public function update(int $id, Request $request, EntityManagerInterface $entityManager, ArticleRepository $articleRepository): Response
    {

    $article = $articleRepository->find($id);
     $form = $this->createForm(ArticleFormType::class,$article, ["save_button_label" => "Creer un Article"]);
     $form->handleRequest($request);
     if($form->isSubmitted()){
        $today = new \DateTime();

        $article = $form->getData();
        foreach ($article->getCategories() as $category) {
            $category->addArticle($article);
        }
        $article->setUpdatedAt( $today )->setStatus("on");
        $entityManager->persist($article);
        $entityManager->flush();
        return $this->redirectToRoute("article.get", ["id" => $article->getId()], Response::HTTP_CREATED);
     }

        return $this->render('article/new.html.twig', [
            'form' => $form,
        ]);

    }
    #[Route('/article/{id}', name: 'article.get')]
    public function get(int $id,ArticleRepository $articleRepository): Response
    {
             return $this->render('article/get.html.twig', [
            'article' => $articleRepository->find($id),
        ]);
    }

  #[Route('/article/delete/{id}', name: 'article.delete')]
    public function delete(int $id,ArticleRepository $articleRepository, EntityManagerInterface $entityManager): Response
    {
        $article = $articleRepository->find($id);
        $entityManager->remove($article);
        $entityManager->flush();
                   return $this->render('article/all.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }
}
