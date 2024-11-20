<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route(path: '/', name: 'app_login')]
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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour accéder à cette page.');
        }

        // Rediriger en fonction du rôle
        if (in_array('ROLE_ADMIN', $user->getRoles())) {
            // Redirection pour l'administrateur
            return $this->redirectToRoute(
                'app_member_index', // Liste des membres
                [],
                Response::HTTP_SEE_OTHER
            );
        }

        // Redirection pour un utilisateur standard
        return $this->redirectToRoute(
            'app_member_show', // Profil du membre connecté
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
