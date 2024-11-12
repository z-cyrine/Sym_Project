<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
      $error = $authenticationUtils->getLastAuthenticationError();
      $lastUsername = $authenticationUtils->getLastUsername();
  
      return $this->render('login/index.html.twig', [
      'last_username' => $lastUsername, 
      'error' => $error]
      );
    }
    
    #[Route('/login-redirect', name: 'app_login_redirect', methods: ['GET', 'POST'])]
    public function loginRedirect(): Response
    {
        $user = $this->getUser();

        
        return $this->redirectToRoute(
            'app_member_show',
            ['id' => $user->getId()],
            Response::HTTP_SEE_OTHER
        );
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('');

    }
}
