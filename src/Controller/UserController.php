<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Entity\Role;
use App\Entity\User;
use App\Form\UserType;
use App\Services\Helpers;
use App\Services\MailerService;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\SendinblueMailer;



#[Route('user')]
class UserController extends AbstractController
{

    public function __construct(private Helpers $helpers, private SendinblueMailer $sendinblueMailer)
    {
    }

    #[Route('/', name: 'user.list')]
    public function index(ManagerRegistry $doctrine) : Response
    {
        $repository = $doctrine->getRepository(Personne::class);

        $users = $repository->findAll();
        return $this->render('user/index.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/alls/{page?1}/{nbre?12}', name: 'user.list.alls')]
    /**
     * @IsGranted("ROLE_USER")
     *
     */
    public function indexAlls(ManagerRegistry $doctrine, $page, $nbre) : Response
    {
        $repository = $doctrine->getRepository(Personne::class);
        $nbUsers = $repository->count([]);
        $nbrPage = ceil($nbUsers/$nbre) ;

        //echo $this->helpers->sayHello();

        $users = $repository->findBy([], ['age' => 'DESC'],$nbre,($page - 1) * $nbre);
        return $this->render('user/index.html.twig', [
            'users' => $users,
            'isPaginated' => true,
            'nbrPage' => $nbrPage,
            'page' => $page,
            'nbre' => $nbre
        ]);
    }


    #[Route('/alls/age/{ageMin}/{ageMax}', name: 'user.list.alls.ageInterval')]
    public function indexAllsByAge(ManagerRegistry $doctrine, $ageMin, $ageMax) : Response
    {
        $repository = $doctrine->getRepository(Personne::class);
        $users = $repository->finduserByAgeInterval($ageMin,$ageMax);

        return $this->render('user/ageInterval.html.twig', ['users' => $users]);
    }


    #[Route('/stats/age/{ageMin}/{ageMax}', name: 'user.list.stats.ageInterval')]
    public function indexStatsByAge(ManagerRegistry $doctrine, $ageMin, $ageMax) : Response
    {
        $repository = $doctrine->getRepository(Personne::class);
        $stats = $repository->statsUserByAgeInterval($ageMin,$ageMax);

        return $this->render('user/statsAgeInterval.html.twig', [
            'stats' => $stats,
            'ageMin' => $ageMin,
            'ageMax'=> $ageMax

        ]);
    }


    #[Route('/{id<\d+>}',name:'user.detail')]
    public function detail(ManagerRegistry $doctrine, $id) : Response
    {
        $repository = $doctrine->getRepository(Personne::class);

        $user = $repository->find($id);

        if(!$user)
        {
            return $this->redirectToRoute('user.list');
        }
        return $this->render('user/detail.html.twig', [
            'user' => $user
        ]);
    }
    #[Route('/add', name: 'user.add')]
    public function addUser(ManagerRegistry $doctrine, Request $request): Response
    {


        $user = new Personne();
        $form = $this->createForm(UserType::class,$user);
        $form->remove('createdAt');
        $form->remove('updatedAt');
        //$form->remove('role');

        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash( 'success', $user->getFirstname(). "a été ajouté avec succès");
           // $this->sendinblueMailer->sendEmail($user->getEmail(),"Enregistrement nouvel utilisateur",content:"Un nouvel utilisateur a été ajouté avec succès" );
            return $this->redirectToRoute('user.list.alls');
        }
        else    
        {
            return $this->render('user/add-user.html.twig', [
                'form' => $form->createView()
            ]);
        }

        /*$user = new User();
        $user->setName('hakim');
        $user->setFirstname('Pnouk');
        $user->setAge(33);

        $role = new Role();
        $role->setRole("Admin");
        $role->setDescription("Has all the right");
        $entityManager->persist($role);



        $user->setRole($role);


        $entityManager->persist($user);

        $entityManager->flush();*/



    }

    #[Route('/edit/{id?0}', name: 'user.edit')]
    public function editUser(
            Personne $user = null ,
            ManagerRegistry $doctrine,
            Request $request,
            MailerService $mailer
    ): Response
    {
        $new = false;
        if(!$user)
        {
            $new = true;
            $user = new Personne();
        }

        $form = $this->createForm(UserType::class,$user);
        $form->remove('createdAt');
        $form->remove('updatedAt');

        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            if($new)
            {
                $this->addFlash( 'success', $user->getFirstname(). "a été ajouté avec succès");
                $mailMessage = $user->getFirstname().' '.$user->getName().' a été ajouté avec succes';
            }
            else
            {
                $this->addFlash( 'success', $user->getFirstname(). "a été édité avec succès");
                $mailMessage = $user->getFirstname().' '.$user->getName().' a été édité avec succes';
            }

            $mailer->sendEmail(content: $mailMessage);
            return $this->redirectToRoute('user.list.alls');
        }
        else
        {
            return $this->render('user/add-user.html.twig', [
                'form' => $form->createView()
            ]);
        }

        /*$user = new User();
        $user->setName('hakim');
        $user->setFirstname('Pnouk');
        $user->setAge(33);

        $role = new Role();
        $role->setRole("Admin");
        $role->setDescription("Has all the right");
        $entityManager->persist($role);



        $user->setRole($role);


        $entityManager->persist($user);

        $entityManager->flush();*/



    }

    #[Route('/remove/{id<\d+>}', name: 'user.remove')]
    public function removeUser(ManagerRegistry $doctrine,$id) : RedirectResponse
    {
        $entityManager = $doctrine->getManager();

        $user = $entityManager->getRepository(Personne::class)->find($id);

        if($user)
        {
            $entityManager->remove($user);
            $entityManager->flush();

            $this->addFlash('success', "La personne a été supprimé avec succès");
        }
        else
        {
            $this->addFlash('error', "La personne est innexistante");
        }

        return $this->redirectToRoute('user.list.alls');
    }

    #[Route('/update/{id}/{firstname}/{name}/{age}',name :'user.update')]
    public function updateUser(Personne $user = null,$firstname ,$name,$age, ManagerRegistry $doctrine) : RedirectResponse
    {
        if($user)
        {
            $user->setName($name);
            $user->setFirstname($firstname);
            $user->setAge($age);

            $doctrine->getManager()->persist($user);
            $doctrine->getManager()->flush();

            $this->addFlash('success' , "Le user a été mis a jour");

        }
        else
        {
            $this->addFlash('error', "La personne est innexistante");
        }

        return $this->redirectToRoute('user.list.alls');
    }
}
