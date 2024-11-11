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
        $user = $this->getUser(); 
        $members = $memberRepository->findAll();

        // Filtrer les membres pour exclure l'utilisateur authentifié
        $filteredMembers = array_filter($members, function(Member $member) use ($user) {
            return $member !== $user;
        });

        return $this->render('member/index.html.twig', [
            'members' => $filteredMembers,
        ]);
    }

    #[Route('/member/{id}', name: 'app_member_show')]
    public function show(Member $member, ManagerRegistry $doctrine): Response
    {
        $isOwnerOrAdmin = $this->isGranted('ROLE_ADMIN') || ($this->getUser() && $this->getUser() === $member);
    
        $showcaseRepository = $doctrine->getRepository(Showcase::class);
        $showcases = $isOwnerOrAdmin
            // Afficher toutes les showcases si owner ou admin
            ? $showcaseRepository->findBy(['createur' => $member]) 
            // Afficher uniquement les showcases publiques pour les autres membres
            : $showcaseRepository->findBy(['createur' => $member, 'publiee' => true]); 
    
        return $this->render('member/show.html.twig', [
            'member' => $member,
            'showcases' => $showcases,
            'isOwnerOrAdmin' => $isOwnerOrAdmin,
        ]);
    }

    

    
 
}

