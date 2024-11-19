<?php

namespace App\Controller;

use App\Entity\Member;
use App\Entity\Showcase;
use App\Repository\MemberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class MemberController extends AbstractController
{
    #[Route('/members', name: 'app_member_index')]
    public function index(MemberRepository $memberRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser(); 
        $members = $memberRepository->findAll();
        
        return $this->render('member/index.html.twig', [
            'members' => $members,
        ]);
    }

    #[Route('/member/{id}', name: 'app_member_show')]
    public function show(Member $member, ManagerRegistry $doctrine): Response
    {   
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // Empêcher l'accès au profil de l'admin
        if (in_array('ROLE_ADMIN', $member->getRoles())) {
            $this->addFlash('danger', "Vous ne pouvez pas acceder au profil d'un administrateur.");
            return $this->redirectToRoute('app_member_index');
        }
        
        $showcaseRepository = $doctrine->getRepository(Showcase::class);

        // Récupérer les showcases en fonction des roles
        if ($this->isGranted('ROLE_ADMIN') || $this->getUser() && $this->getUser() === $member) {
            $showcases = $showcaseRepository->findBy(['createur' => $member]);
        } else {
            $showcases = $showcaseRepository->findBy(['createur' => $member, 'publiee' => true]);
        }
    
        return $this->render('member/show.html.twig', [
            'member' => $member,
            'showcases' => $showcases,
        ]);
    }

    

    
 
}

