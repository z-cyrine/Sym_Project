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
        $members = $memberRepository->findAll();
        return $this->render('member/index.html.twig', [
            'members' => $members,
        ]);
    }

    #[Route('/member/{id}', name: 'app_member_show', requirements: ['id' => '\d+'])]
    public function show(Member $member, ManagerRegistry $doctrine): Response
    {
        // Récupérer les showcases du membre
        $showcaseRepository = $doctrine->getRepository(Showcase::class);
        $showcases = $showcaseRepository->findBy(['createur' => $member]);
    
        return $this->render('member/show.html.twig', [
            'member' => $member,
            'showcases' => $showcases,
        ]);
    }
    
 
}

