<?php

namespace App\Controller;

use App\Entity\ServiceStage;
use App\Form\ServiceStageType;
use App\Repository\ServiceStageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/servicio/etapas')]
class ServiceStageController extends AbstractController
{
    #[Route('/', name: 'service_stage_index', methods: ['GET'])]
    public function index(ServiceStageRepository $serviceStageRepository): Response
    {
        return $this->render('service_stage/index.html.twig', [
            'service_stages' => $serviceStageRepository->findAll(),
        ]);
    }

    #[Route('/crear', name: 'service_stage_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $serviceStage = new ServiceStage();
        $form = $this->createForm(ServiceStageType::class, $serviceStage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($serviceStage);
            $entityManager->flush();

            return $this->redirectToRoute('service_stage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service_stage/new.html.twig', [
            'service_stage' => $serviceStage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'service_stage_show', methods: ['GET'])]
    public function show(ServiceStage $serviceStage): Response
    {
        return $this->render('service_stage/show.html.twig', [
            'service_stage' => $serviceStage,
        ]);
    }

    #[Route('/{id}/editar', name: 'service_stage_edit', methods: ['GET','POST'])]
    public function edit(Request $request, ServiceStage $serviceStage): Response
    {
        $form = $this->createForm(ServiceStageType::class, $serviceStage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('service_stage_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service_stage/edit.html.twig', [
            'service_stage' => $serviceStage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'service_stage_delete', methods: ['POST'])]
    public function delete(Request $request, ServiceStage $serviceStage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$serviceStage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($serviceStage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('service_stage_index', [], Response::HTTP_SEE_OTHER);
    }
}
