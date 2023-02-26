<?php

namespace App\Controller;

use App\Entity\Lead;
use App\Entity\Tableau;
use App\Form\TableauType;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @IsGranted("ROLE_USER")
 *
 */
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
        return $this->render('board/allBoards.html.twig',
        [
            'tableaus' => $tableaux
        ]);
    }

    /*#[Route('/add', name: 'adm.board.add')]
    public function addBoard(Request $request): Response
    {
        $entityManager = $this->doctrine->getManager();
        $tableau = new Tableau();
        $form = $this->createFormBuilder($tableau)
            ->add('name')
            ->add('lead', ChoiceType::class, [
                'choices' => $this->doctrine->getRepository(Lead::class)->findAll(),
                'choice_label' => 'name',
                'placeholder' => 'Sélectionner une personne',
            ])
            ->add('enregistrer', SubmitType::class)
            ->getForm();
        //$form = $this->createForm(TableauType::class,$tableau);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $lead = $form->get('lead')->getData();
            //dd($lead);
            if($lead instanceof Lead)
            {
                $tableau->setLead($lead);
            }


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
    }*/

    #[Route('/ajouter', name: 'adm.board.ajouter')]
    public function nouveauTableau(Request $request)
    {
        $tableau = new Tableau();

        $form = $this->createFormBuilder($tableau)
            ->add('name')
            ->add('lead', ChoiceType::class, [
                'choices' => $this->doctrine->getRepository(Lead::class)->findAll(),
                'choice_label' => 'name',
                'placeholder' => 'Sélectionner une personne',
            ])
            ->add('enregistrer', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $lead = $form->get('lead')->getData();
            //dd($lead);


            if ($lead instanceof Lead) {
                //dd($lead);
                $tableau->setLead($lead);

            }
            $entityManager = $this->doctrine->getManager();
            $entityManager->persist($tableau);
            $entityManager->flush();

            return $this->redirectToRoute('adm.board');
        }

        return $this->render('board/nouveau.html.twig', [
            'form' => $form->createView(),
        ]);
    }





    #[Route('/edit/{id?0}', name:'adm.board.edit')]
    public function editBoard(Tableau $tableau = null ,
                              ManagerRegistry $doctrine,
                              Request $request) : Response
    {
        $new = false;
        if(!$tableau)
        {
            $new = true;
            $tableau = new Tableau();
        }

        $form = $this->createForm(TableauType::class,$tableau);
        $form->remove('createdAt');
        $form->remove('updatedAt');

        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($tableau);
            $entityManager->flush();

            if($new)
            {
                $this->addFlash( 'success', "Le tableau ". $tableau->getName(). "a été ajouté avec succès");
            }
            else
            {
                $this->addFlash( 'success', "Le tableau". $tableau->getName(). "a été édité avec succès");
            }

            //$mailer->sendEmail(content: $mailMessage);

            return $this->redirectToRoute('adm.board');
        }
        else
        {
            return $this->render('board/add-board.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }


    #[Route('/remove/{id<\d+>}', name: 'adm.board.remove')]
    public function removeBoard(ManagerRegistry $doctrine,$id) : RedirectResponse
    {
        $entityManager = $doctrine->getManager();

        $tableau = $entityManager->getRepository(Tableau::class)->find($id);

        if($tableau)
        {
            $entityManager->remove($tableau);
            $entityManager->flush();

            $this->addFlash('success', "La tableau a été supprimé avec succès");
        }
        else
        {
            $this->addFlash('error', "La tableau est innexistante");
        }

        return $this->redirectToRoute('adm.board');
    }


    #[Route('/{id<\d+>}',name:'adm.board.detail')]
    public function detail(ManagerRegistry $doctrine, $id) : Response
    {
        $repository = $doctrine->getRepository(Tableau::class);

        $tableau = $repository->find($id);

        return $this->render('board/detail.html.twig', [
            'tableau' => $tableau
        ]);
    }

    #[Route('/no-board',name:'no-board')]
    public function noBoard(ManagerRegistry $doctrine) : Response
    {
        return $this->render('board/detail.html.twig');
    }

    #[Route('/userBoard',name:'adm.board.userBoard')]
    public function userMe(ManagerRegistry $doctrine,$id ,Security $security) : Response
    {
        $token = $security->getToken();
        if ($token !== null) {
            // Récupération de l'utilisateur connecté
            $user = $token->getUser();
            $roles = $user->getRoles();
            dd($user);

        }

        return  $this->redirectToRoute();

    }
}
