<?php

namespace App\Controller\Admin;

use App\Entity\CarDoor;
use App\Form\CarDoorType;
use App\Repository\CarDoorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/car/door')]
final class CarDoorController extends AbstractController
{
    #[Route(name: 'app_admin_car_door_index', methods: ['GET'])]
    public function index(CarDoorRepository $carDoorRepository): Response
    {
        return $this->render('admin/car_door/index.html.twig', [
            'car_doors' => $carDoorRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_admin_car_door_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $carDoor = new CarDoor();
        $form = $this->createForm(CarDoorType::class, $carDoor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($carDoor);
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_car_door_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/car_door/new.html.twig', [
            'car_door' => $carDoor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_car_door_show', methods: ['GET'])]
    public function show(CarDoor $carDoor): Response
    {
        return $this->render('admin/car_door/show.html.twig', [
            'car_door' => $carDoor,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_admin_car_door_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CarDoor $carDoor, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CarDoorType::class, $carDoor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_admin_car_door_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/car_door/edit.html.twig', [
            'car_door' => $carDoor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_admin_car_door_delete', methods: ['POST'])]
    public function delete(Request $request, CarDoor $carDoor, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$carDoor->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($carDoor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_admin_car_door_index', [], Response::HTTP_SEE_OTHER);
    }
}
