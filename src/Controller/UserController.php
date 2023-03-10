<?php

namespace App\Controller;

use App\Entity\Lead;
use App\Entity\Role;
use App\Entity\User;
use App\Form\UserType;
use App\Services\Helpers;
use App\Services\MailerService;
use App\Services\SendinblueMailer;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Array_;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



#[Route('user')]
class UserController extends AbstractController
{

    public function __construct(private Helpers $helpers, private SendinblueMailer $sendinblueMailer)
    {
    }

    #[Route('/', name: 'user.list')]
    /**
     * @IsGranted("ROLE_MANAGER")
     *
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(User::class);

        $users = $repository->findAll();
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/alls/{page?1}/{nbre?12}', name: 'user.list.alls')]
    /**
     * @IsGranted("ROLE_MANAGER")
     *
     */
    public function indexAlls(ManagerRegistry $doctrine, $page, $nbre): Response
    {
        $repository = $doctrine->getRepository(User::class);
        $nbUsers = $repository->count([]);
        $nbrPage = ceil($nbUsers / $nbre);

        //echo $this->helpers->sayHello();

        $users = $repository->findBy([], [], $nbre, ($page - 1) * $nbre);

        //dd($users);
        return $this->render('user/index.html.twig', [
            'users' => $users,
            'isPaginated' => true,
            'nbrPage' => $nbrPage,
            'page' => $page,
            'nbre' => $nbre
        ]);
    }


    #[Route('/alls/age/{ageMin}/{ageMax}', name: 'user.list.alls.ageInterval')]
    public function indexAllsByAge(ManagerRegistry $doctrine, $ageMin, $ageMax): Response
    {
        $repository = $doctrine->getRepository(User::class);
        $users = $repository->finduserByAgeInterval($ageMin,$ageMax);

        return $this->render('user/ageInterval.html.twig', ['users' => $users]);
    }


    #[Route('/stats/age/{ageMin}/{ageMax}', name: 'user.list.stats.ageInterval')]
    public function indexStatsByAge(ManagerRegistry $doctrine, $ageMin, $ageMax): Response
    {
        $repository = $doctrine->getRepository(User::class);
        $stats = $repository->statsUserByAgeInterval($ageMin,$ageMax);

        return $this->render('user/statsAgeInterval.html.twig', [
            'stats' => $stats,
            'ageMin' => $ageMin,
            'ageMax' => $ageMax

        ]);
    }


    #[Route('/{id<\d+>}', name: 'user.detail')]
    public function detail(ManagerRegistry $doctrine, $id): Response
    {
        $repository = $doctrine->getRepository(User::class);

        $user = $repository->find($id);

        if (!$user) {
            return $this->redirectToRoute('user.list');
        }
        return $this->render('user/detail.html.twig', [
            'user' => $user
        ]);
    }
    #[Route('/add', name: 'user.add')]
    public function addUser(ManagerRegistry $doctrine, Request $request): Response
    {


        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->remove('createdAt');
        $form->remove('updatedAt');
        //$form->remove('role');

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', $user->getFirstname() . "a ??t?? ajout?? avec succ??s");
            // $this->sendinblueMailer->sendEmail($user->getEmail(),"Enregistrement nouvel utilisateur",content:"Un nouvel utilisateur a ??t?? ajout?? avec succ??s" );
            return $this->redirectToRoute('user.list.alls');
        } else {
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
        User $user = null,
        ManagerRegistry $doctrine,
        Request $request,
        $id
        /*MailerService $mailer*/
    ): Response {
        $new = false;
        if (!$user) {
            $new = true;
            $user = new User();
        }

        $form = $this->createForm(UserType::class, $user);
        $form->remove('createdAt');
        $form->remove('updatedAt');

        //dd($form);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $temp = Array();
            $temp =$form->get('roles')->getData();
            if ($new) {
                $this->addFlash('success', $user->getFirstname() . "a ??t?? ajout?? avec succ??s");
                $mailMessage = $user->getFirstname() . ' ' . $user->getName() . ' a ??t?? ajout?? avec succes';
            } else {
                $this->addFlash('success', $user->getFirstname() . "a ??t?? ??dit?? avec succ??s");
                $mailMessage = $user->getFirstname() . ' ' . $user->getName() . ' a ??t?? ??dit?? avec succes';
            }

            //$mailer->sendEmail(content: $mailMessage);

            $this->sendinblueMailer->sendEmail(
                "idirwalidhakim32@gmail.com",
                "Test Challenge",
                "<p>hello </p>"
            );
            return $this->redirectToRoute('user.list.alls');
            }
            else {
                return $this->render('user/add-user.html.twig', [
                    'form' => $form->createView(), 'user' => $user
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
    public function removeUser(ManagerRegistry $doctrine, $id): RedirectResponse
    {
        $entityManager = $doctrine->getManager();

        $user = $entityManager->getRepository(User::class)->find($id);

        if ($user) {
            $entityManager->remove($user);
            $entityManager->flush();

            $this->addFlash('success', "La personne a ??t?? supprim?? avec succ??s");
        } else {
            $this->addFlash('error', "La personne est innexistante");
        }

        return $this->redirectToRoute('user.list.alls');
    }

    #[Route('/update/{id}/{firstname}/{name}/{age}', name: 'user.update')]
    public function updateUser(User $user = null, $firstname, $name, $age, ManagerRegistry $doctrine): RedirectResponse
    {
        if ($user) {
            $user->setName($name);
            $user->setFirstname($firstname);


            $doctrine->getManager()->persist($user);
            $doctrine->getManager()->flush();

            $this->addFlash('success', "Le user a ??t?? mis a jour");
        } else {
            $this->addFlash('error', "La personne est innexistante");
        }

        return $this->redirectToRoute('user.list.alls');
    }

    public function isSignedIn()
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('admin.index');
        } else {
            return $this->redirectToRoute('user.index');
        }
    }
}
