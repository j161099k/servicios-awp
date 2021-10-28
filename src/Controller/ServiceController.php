<?php

namespace App\Controller;

use Pusher\Pusher;
use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/servicios')]
class ServiceController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('/', name: 'service_index', methods: ['GET'])]
    public function index(ServiceRepository $serviceRepository): Response
    {
        $services = ($this->security->getUser()->isEmployee())
            ? $serviceRepository->findAll()
            : $this->security->getUser()->getClient()->getServices();

        return $this->render('service/index.html.twig', [
            'services' => $services,
        ]);
    }

    #[Route('/crear', name: 'service_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Pusher $pusher): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($this->security->getUser()->isClient()) {
                $service->setClient($this->security->getUser()->getClient());
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($service);
            $entityManager->flush();



            $pusher->trigger('services', 'new-service', [
                'folio' => $service->getFolio(),
            ]);

            return $this->redirectToRoute('service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service/new.html.twig', [
            'service' => $service,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'service_show', methods: ['GET'])]
    public function show(Service $service): Response
    {
        return $this->render('service/show.html.twig', [
            'service' => $service,
        ]);
    }

    #[Route('/{id}/editar', name: 'service_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Service $service): Response
    {
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($this->security->getUser()->isClient()) {
                $service->setClient($this->security->getUser()->getClient());
            }

            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service/edit.html.twig', [
            'service' => $service,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'service_delete', methods: ['POST'])]
    public function delete(Request $request, Service $service): Response
    {
        if ($this->isCsrfTokenValid('delete' . $service->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($service);
            $entityManager->flush();
        }

        return $this->redirectToRoute('service_index', [], Response::HTTP_SEE_OTHER);
    }
}
