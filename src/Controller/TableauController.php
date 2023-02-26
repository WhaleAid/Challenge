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
use Symfony\Component\Security\Core\Annotation\IsGranted;
use Symfony\Component\Security\Core\Security;

#[Route('/tableau')]
class TableauController extends AbstractController
{
    #[Route('/', name: 'tableau_index', methods: ['GET'])]
    public function index(TableauRepository $tableauRepository): Response
    {
        if ($this-> isGranted('ROLE_MANAGER')) {
            return $this->render('tableau/index.html.twig', [
                'tableaus' => $tableauRepository->findBy(['manager_id' => $this->getUser()->getId()])
            ]);
        } else {
            return $this->render('adm.tableau.detail');
        }
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
            $tableau->setManager($this->getUser());
            $tableauRepository->save($tableau, true);

            return $this->redirectToRoute('tableau_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('tableau/new.html.twig', [
            'tableau' => $tableau,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'adm.tableau.detail', methods: ['GET'])]
    public function show(Tableau $tableau): Response
    {
        return $this->render('tableau/show.html.twig', [
            'tableau' => $tableau
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

    #[Route('/{id?0<\d+>}',name:'adm.tableau.detail')]
    public function detail(ManagerRegistry $doctrine, $id) : Response
    {
        $repository = $doctrine->getRepository(Tableau::class);
            $tableau = $repository->find($id);
            return $this->render('tableau/detail.html.twig', [
                'tableau' => $tableau
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
