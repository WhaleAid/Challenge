<?php

namespace App\Controller;

use App\Entity\Lead;
use App\Form\LeadType;
use App\Repository\LeadRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/lead')]
class LeadController extends AbstractController
{
    #[Route('/', name: 'app_lead_index', methods: ['GET'])]
    public function index(LeadRepository $leadRepository): Response
    {
        return $this->render('lead/index.html.twig', [
            'leads' => $leadRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_lead_new', methods: ['GET', 'POST'])]
    public function new(Request $request, LeadRepository $leadRepository): Response
    {
        $lead = new Lead();
        $form = $this->createForm(LeadType::class, $lead);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $leadRepository->save($lead, true);

            return $this->redirectToRoute('app_lead_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('lead/new.html.twig', [
            'lead' => $lead,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lead_show', methods: ['GET'])]
    public function show(Lead $lead): Response
    {
        return $this->render('lead/show.html.twig', [
            'lead' => $lead,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_lead_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Lead $lead, LeadRepository $leadRepository): Response
    {
        $form = $this->createForm(LeadType::class, $lead);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $leadRepository->save($lead, true);

            return $this->redirectToRoute('app_lead_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('lead/edit.html.twig', [
            'lead' => $lead,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lead_delete', methods: ['POST'])]
    public function delete(Request $request, Lead $lead, LeadRepository $leadRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lead->getId(), $request->request->get('_token'))) {
            $leadRepository->remove($lead, true);
        }

        return $this->redirectToRoute('app_lead_index', [], Response::HTTP_SEE_OTHER);
    }
}
