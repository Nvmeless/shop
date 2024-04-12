<?php

namespace App\Controller;

use App\Entity\CustomUploadedFile;
use App\Form\CustomUploadedFileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CustomUploadedFileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/file')]
class CustomUploadedFileController extends AbstractController
{
    #[Route('/', name: 'app_custom_uploaded_file_index', methods: ['GET'])]
    public function index(CustomUploadedFileRepository $customUploadedFileRepository): Response
    {
        return $this->render('custom_uploaded_file/index.html.twig', [
            'custom_uploaded_files' => $customUploadedFileRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_custom_uploaded_file_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $customUploadedFile = new CustomUploadedFile();
        $form = $this->createForm(CustomUploadedFileType::class, $customUploadedFile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($customUploadedFile);
            $entityManager->flush();

            return $this->redirectToRoute('app_custom_uploaded_file_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('custom_uploaded_file/new.html.twig', [
            'custom_uploaded_file' => $customUploadedFile,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_custom_uploaded_file_show', methods: ['GET'])]
    public function show(CustomUploadedFile $customUploadedFile): Response
    {
        return $this->render('custom_uploaded_file/show.html.twig', [
            'custom_uploaded_file' => $customUploadedFile,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_custom_uploaded_file_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CustomUploadedFile $customUploadedFile, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CustomUploadedFileType::class, $customUploadedFile);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_custom_uploaded_file_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('custom_uploaded_file/edit.html.twig', [
            'custom_uploaded_file' => $customUploadedFile,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_custom_uploaded_file_delete', methods: ['POST'])]
    public function delete(Request $request, CustomUploadedFile $customUploadedFile, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$customUploadedFile->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($customUploadedFile);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_custom_uploaded_file_index', [], Response::HTTP_SEE_OTHER);
    }
}
