<?php

namespace App\Controller;

use App\Entity\Slider;
use App\Form\SliderType;
use App\Repository\SliderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/slider')]
final class SliderController extends AbstractController
{
    #[Route(name: 'app_slider_index', methods: ['GET'])]
    public function index(SliderRepository $sliderRepository): Response
    {

        return $this->render('slider/index.html.twig', [
            'sliders' => $sliderRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_slider_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $slider = new Slider();
        $form = $this->createForm(SliderType::class, $slider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($slider);
            $entityManager->flush();

            return $this->redirectToRoute('app_slider_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('slider/new.html.twig', [
            'slider' => $slider,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_slider_show', methods: ['GET'])]
    public function show(Slider $slider): Response
    {
        return $this->render('slider/show.html.twig', [
            'slider' => $slider,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_slider_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Slider $slider, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SliderType::class, $slider);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_slider_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('slider/edit.html.twig', [
            'slider' => $slider,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_slider_delete', methods: ['POST'])]
    public function delete(Request $request, Slider $slider, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$slider->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($slider);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_slider_index', [], Response::HTTP_SEE_OTHER);
    }
}
