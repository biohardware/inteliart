<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Security\LoginFormAuthenticator as AppUser;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();



        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout",name="app_logout")
     */
    public function logout()
    {
        return $this->render('security/logout.html.twig');

        // throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
    /**
     * @Route("/")
     */
    public function index()
    {
        return $this->render('security/logout.html.twig');

        // throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

    public function all_users()
    {
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();

        $error="";
        return $this->render('security/users.html.twig',['users' =>$user,'error' => $error]);

        // throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

}
