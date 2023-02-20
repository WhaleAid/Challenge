<?php

namespace App\Controller;

use App\Entity\Tableau;
use App\Form\TableauType;
use App\Entity\Personne;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('adm/board')]
class BoardController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine)
    {
    }

    #[Route('/', name:'adm.board')]
    public function displayBoards() : Response
    {
        $repository = $this->doctrine->getRepository(Tableau::class);
        $tableaux =  $repository->findAll();
        //dd($tableaux);
        return $this->render('board/allBoards.html.twig',
        [
            'tableaux' => $tableaux
        ]);
    }
    #[Route('/add', name: 'adm.board.add')]
    public function addBoard(Request $request): Response
    {
        $entityManager = $this->doctrine->getManager();

        $tableau = new Tableau();

        $form = $this->createForm(TableauType::class,$tableau);


        $form->handleRequest($request);

        if($form->isSubmitted())
        {

            $entityManager->persist($tableau);
            $entityManager->flush();

            $this->addFlash( 'success', 'Le tableau numéro'. $tableau->getId(). "a été ajouté avec succès");

            return $this->redirectToRoute('adm.board');
        }
        else
        {
            return $this->render('board/index.html.twig', [
                'controller_name' => 'BoardController',
                'form' => $form->createView()
            ]);
        }
    }
}
