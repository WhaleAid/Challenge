<?php

namespace App\Controller;

use App\Entity\Lead;
use App\Entity\Tableau;
use App\Entity\User;
use App\Form\Tableau1Type;
use App\Form\TableauType;
use App\Repository\TableauRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/tableau')]
class TableauController extends AbstractController
{
    #[Route('/', name: 'tableau_index', methods: ['GET'])]
    public function index(TableauRepository $tableauRepository): Response
    {
        return $this->render('tableau/index.html.twig', [
            'tableaus' => $tableauRepository->findAll(),
        ]);
    }

    #[Route('/show', name: 'tableau_show', methods: ['GET'])]
    public function showMyBords(TableauRepository $tableauRepository,Security $security, ManagerRegistry $doctrine): Response
    {
        $token = $security->getToken();
        if ($token !== null) {
            $user = $token->getUser()->getUserIdentifier();
            dd($user);
            $roles = $user->getRoles();
        }
        //dd($user);
        $temp = $doctrine->getManager()->getRepository(Tableau::class);

        //dd($temp);

        return $this->render('tableau/index.html.twig', [
            'tableaus' => $tableauRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_tableau_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TableauRepository $tableauRepository,ManagerRegistry $doctrine): Response
    {
        $tableau = new Tableau();

        $form = $this->createFormBuilder($tableau)
            ->add('name')
            ->add('lead', ChoiceType::class, [
                'choices' => $doctrine->getManager()->getRepository(Lead::class)->findAll(),
                'choice_label' => 'name',
                'placeholder' => 'Sélectionner une Lead',
            ])
            ->add('enregistrer', SubmitType::class)
            ->getForm();

        //$form = $this->createForm(Tableau1Type::class, $tableau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tableauRepository->save($tableau, true);

            return $this->redirectToRoute('tableau_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tableau/new.html.twig', [
            'tableau' => $tableau,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tableau_show', methods: ['GET'])]
    public function show(Tableau $tableau): Response
    {
        return $this->render('tableau/show.html.twig', [
            'tableau' => $tableau,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tableau_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tableau $tableau, TableauRepository $tableauRepository, ManagerRegistry $doctrine): Response
    {
        //$form = $this->createForm(Tableau1Type::class, $tableau);
        $form = $this->createFormBuilder($tableau)
            ->add('name')
            ->add('lead', ChoiceType::class, [
                'choices' => $doctrine->getManager()->getRepository(Lead::class)->findAll(),
                'choice_label' => 'name',
                'placeholder' => 'Sélectionner une Lead',
            ])
            ->add('enregistrer', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tableauRepository->save($tableau, true);

            return $this->redirectToRoute('tableau_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tableau/edit.html.twig', [
            'tableau' => $tableau,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tableau_delete', methods: ['POST'])]
    public function delete(Request $request, Tableau $tableau, TableauRepository $tableauRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tableau->getId(), $request->request->get('_token'))) {
            $tableauRepository->remove($tableau, true);
        }

        return $this->redirectToRoute('tableau_index', [], Response::HTTP_SEE_OTHER);
    }
}
