<?php

namespace App\Controller\Admin;

use App\Entity\Tyres;
use App\Form\TyresType;
use App\Repository\TyresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/tyres')]
final class TyresController extends AbstractController
{
    #[Route(name: 'app_admin_tyres_index', methods: ['GET'])]
    public function index(TyresRepository $tyresRepository): Response
    {
        return $this->render('admin/tyres/index.html.twig', [
            'tyres' => $tyresRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_tyres_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $tyre = new Tyres();
        $form = $this->createForm(TyresType::class, $tyre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tyre);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_tyres_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/tyres/new.html.twig', [
            'tyre' => $tyre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_tyres_show', methods: ['GET'])]
    public function show(Tyres $tyre): Response
    {
        return $this->render('admin/tyres/show.html.twig', [
            'tyre' => $tyre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_tyres_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tyres $tyre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TyresType::class, $tyre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_tyres_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/tyres/edit.html.twig', [
            'tyre' => $tyre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_tyres_delete', methods: ['POST'])]
    public function delete(Request $request, Tyres $tyre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tyre->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($tyre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_tyres_index', [], Response::HTTP_SEE_OTHER);
    }
}
