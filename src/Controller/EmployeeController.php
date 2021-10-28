<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Form\EmployeeType;
use App\Repository\EmployeeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/empleados')]
class EmployeeController extends AbstractController
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->passwordHasher = $userPasswordHasher;
    }
    
    #[Route('/', name: 'employee_index', methods: ['GET'])]
    public function index(EmployeeRepository $employeeRepository): Response
    {
        return $this->render('employee/index.html.twig', [
            'employees' => $employeeRepository->findAll(),
        ]);
    }

    #[Route('/crear', name: 'employee_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $employee = new Employee();
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $this->passwordHasher->hashPassword($employee->getUser(), $employee->getUser()->getPassword());
            $employee->getUser()->setPassword($hash);
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($employee);
            $entityManager->flush();

            return $this->redirectToRoute('employee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employee/new.html.twig', [
            'employee' => $employee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'employee_show', methods: ['GET'])]
    public function show(Employee $employee): Response
    {
        return $this->render('employee/show.html.twig', [
            'employee' => $employee,
        ]);
    }

    #[Route('/{id}/editar', name: 'employee_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Employee $employee): Response
    {
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $this->passwordHasher->hashPassword($employee->getUser(), $employee->getUser()->getPassword());
            $employee->getUser()->setPassword($hash);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('employee_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('employee/edit.html.twig', [
            'employee' => $employee,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'employee_delete', methods: ['POST'])]
    public function delete(Request $request, Employee $employee): Response
    {
        if ($this->isCsrfTokenValid('delete'.$employee->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($employee);
            $entityManager->flush();
        }

        return $this->redirectToRoute('employee_index', [], Response::HTTP_SEE_OTHER);
    }
}
