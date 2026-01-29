<?php

namespace App\Controller\Admin;

use App\Entity\AutoGlass;
use App\Form\AutoGlassType;
use App\Repository\AutoGlassRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/auto/glass')]
final class AutoGlassController extends AbstractController
{
    #[Route(name: 'app_admin_auto_glass_index', methods: ['GET'])]
    public function index(AutoGlassRepository $autoGlassRepository): Response
    {
        return $this->render('admin/auto_glass/index.html.twig', [
            'auto_glasses' => $autoGlassRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_auto_glass_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $autoGlass = new AutoGlass();
        $form = $this->createForm(AutoGlassType::class, $autoGlass);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($autoGlass);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_auto_glass_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/auto_glass/new.html.twig', [
            'auto_glass' => $autoGlass,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_auto_glass_show', methods: ['GET'])]
    public function show(AutoGlass $autoGlass): Response
    {
        return $this->render('admin/auto_glass/show.html.twig', [
            'auto_glass' => $autoGlass,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_auto_glass_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AutoGlass $autoGlass, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AutoGlassType::class, $autoGlass);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_auto_glass_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/auto_glass/edit.html.twig', [
            'auto_glass' => $autoGlass,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_auto_glass_delete', methods: ['POST'])]
    public function delete(Request $request, AutoGlass $autoGlass, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$autoGlass->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($autoGlass);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_auto_glass_index', [], Response::HTTP_SEE_OTHER);
    }
}
