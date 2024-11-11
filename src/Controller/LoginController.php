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
      if ($this->getUser()) {
          // R�cup�rer l'utilisateur connect�
          $currentUser = $this->getUser();
          
          if ($this->getUser()) {
      return $this->redirectToRoute('app_member_show', ['id' => $this->getUser()->getId()]);
    }

      }
  
      $error = $authenticationUtils->getLastAuthenticationError();
      $lastUsername = $authenticationUtils->getLastUsername();
  
      return $this->render('login/index.html.twig', [
      'last_username' => $lastUsername, 
      'error' => $error]
      );
    }
    

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('');

    }
}
