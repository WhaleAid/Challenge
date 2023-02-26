<?php

namespace App\Controller;

use App\Entity\Tableau;
use App\Entity\User;
use App\Form\Tableau1Type;
use App\Repository\TableauRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function showTableau(TableauRepository $tableauRepository,Security $security, ManagerRegistry $doctrine): Response
    {
        $token = $security->getToken();
        if ($token !== null) {
            $user = $token->getUser();
            $roles = $user->getRoles();
        }

        $temp = $doctrine->getManager()->getRepository(User::class);

        dd($user->getUserIdentifier());

        return $this->render('tableau/index.html.twig', [
            'tableaus' => $tableauRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_tableau_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TableauRepository $tableauRepository): Response
    {
        $tableau = new Tableau();
        $form = $this->createForm(Tableau1Type::class, $tableau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tableauRepository->save($tableau, true);

            return $this->redirectToRoute('app_tableau_index', [], Response::HTTP_SEE_OTHER);
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
    public function edit(Request $request, Tableau $tableau, TableauRepository $tableauRepository): Response
    {
        $form = $this->createForm(Tableau1Type::class, $tableau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tableauRepository->save($tableau, true);

            return $this->redirectToRoute('app_tableau_index', [], Response::HTTP_SEE_OTHER);
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

        return $this->redirectToRoute('app_tableau_index', [], Response::HTTP_SEE_OTHER);
    }
}
