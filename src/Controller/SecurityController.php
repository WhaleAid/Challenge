<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, Security $security): Response | RedirectResponse
    {
        if ($security->isGranted('ROLE_MANAGER')) {
            return new RedirectResponse($this->generateUrl('user.list.alls'));
        } else if ( $security->isGranted('ROLE_DEV')) {
            return new RedirectResponse($this->generateUrl('adm.tableau.detail', ['id' => 1]));
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(Request $request,LogoutSuccessHandler $logoutSuccessHandler): Response
    {
        //throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
        //return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
        return $logoutSuccessHandler->onLogoutSuccess($this->getRequest());
    }
}
