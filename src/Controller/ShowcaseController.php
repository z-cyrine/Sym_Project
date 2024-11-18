<?php

namespace App\Controller;

use App\Entity\Showcase;
use App\Form\ShowcaseType;
use App\Entity\Watch;
use App\Entity\Member;
use App\Repository\ShowcaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;

#[Route('/showcase')]
final class ShowcaseController extends AbstractController
{
    #[Route('new/{memberId}', name: 'app_showcase_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine, int $memberId): Response
    {
        $member = $doctrine->getRepository(Member::class)->find($memberId);
    
        if (!$member) {
            throw $this->createNotFoundException('Le membre n\'existe pas.');
        }
    
        $showcase = new Showcase();
        $showcase->setCreateur($member);
    
        $form = $this->createForm(ShowcaseType::class, $showcase);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($showcase);
            $entityManager->flush();
    
            return $this->redirectToRoute('app_member_show', ['id' => $memberId], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('showcase/new.html.twig', [
            'showcase' => $showcase,
            'form' => $form,
            'member' => $member, 
        ]);
    }


    #[Route('/{id}', name: 'app_showcase_show', methods: ['GET'])]
    public function show(Showcase $showcase): Response
    {
        $hasAccess = false;
        if($this->isGranted('ROLE_ADMIN') || $showcase->isPubliee()) {
                $hasAccess = true;
        }
        else {
                $member = $this->getUser();
                if ( $member &&  ($member == $showcase->getCreateur()) ) {
                    $hasAccess = true;
                }
        }
        if(! $hasAccess) {
                throw $this->createAccessDeniedException("You cannot access the requested resource!");
        }
    
        return $this->render('showcase/show.html.twig', [
            'showcase' => $showcase,
        ]);
    }
    

    

    #[Route('/{id}/edit', name: 'app_showcase_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Showcase $showcase, EntityManagerInterface $entityManager): Response
    {
        $hasAccess = false;
        if ($this->isGranted('ROLE_ADMIN')) {
            $hasAccess = true;
        } else {
            $member = $this->getUser();
            if ($member && ($member === $showcase->getCreateur())) {
                $hasAccess = true;
            }
        }
    
        if (!$hasAccess) {
        $this->addFlash('danger', "Vous ne pouvez pas modifier les galeries d'un autre membre.");
        return $this->redirectToRoute('app_member_show', [
            'id' => $showcase->getCreateur()->getId()
        ]);
        }
    
        $form = $this->createForm(ShowcaseType::class, $showcase);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
    
            return $this->redirectToRoute('app_member_show', [
                'id' => $showcase->getCreateur()->getId(),
            ], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('showcase/edit.html.twig', [
            'showcase' => $showcase,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_showcase_delete', methods: ['POST'])]
    public function delete(Request $request, Showcase $showcase, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$showcase->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($showcase);
            $entityManager->flush();
        }

                return $this->redirectToRoute('app_member_show', [
            'id' => $showcase->getCreateur()->getId(),
        ], Response::HTTP_SEE_OTHER);

    }
    
    /**
     * Affiche les détails d'une montre spécifique
     *
     * @param int $id
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    #[Route('/watch/{id}', name: 'app_showcase_watch_show', requirements: ['id' => '\d+'])]
    public function watchShow(ManagerRegistry $doctrine, int $id): Response
    {
        $watch = $doctrine->getRepository(Watch::class)->find($id);

        if (!$watch) {
            throw $this->createNotFoundException('La montre avec l\'ID ' . $id . ' n\'existe pas');
        }
        
        $watchBox = $watch->getWatchBox();
        if (!$watchBox) {
            throw $this->createNotFoundException("Cette montre n'est associée à aucune WatchBox.");
        }
    
        // Vérifier si l'utilisateur a accès
        $hasAccess = false;
        if ($this->isGranted('ROLE_ADMIN')) {
            $hasAccess = true;
        } else {
            $member = $this->getUser();
            if ($member && ($member === $watchBox->getMember())) {
                $hasAccess = true;
            }
        }
    
        // Si l'accès est refusé
        if (!$hasAccess) {
            throw $this->createAccessDeniedException("Vous n'avez pas accès à cette ressource.");
        }

        return $this->render('showcase/watch.show.html.twig', [
            'watch' => $watch,
            'watchBox' => $watchBox
        ]);
    }
    
    
    /**
     * Affiche une montre dans le contexte d'une galerie.
     *
     * @param Showcase $showcase La galerie (Showcase) où se trouve la montre
     * @param Watch $watch       La montre à afficher
     */
    #[Route('{showcase_id}/watch/{watch_id}', 
        name: 'app_showcase_watch_show_v2', 
        requirements: ['showcase_id' => '\d+', 'watch_id' => '\d+']
    )]
    public function watchShow_v2(
        #[MapEntity(id: 'showcase_id')] Showcase $showcase,
        #[MapEntity(id: 'watch_id')] Watch $watch
    ): Response {
        
        if (! $showcase->getWatches()->contains($watch)) {
            throw $this->createNotFoundException("La montre demandée n'est pas dans cette galerie !");
        }

        $hasAccess = false;
        if($this->isGranted('ROLE_ADMIN') || $showcase->isPubliee()) {
                $hasAccess = true;
        }
        else {
                $member = $this->getUser();
          if ( $member &&  ($member == $showcase->getCreateur()) ) {
              $hasAccess = true;
          }
        }
        if(! $hasAccess) {
                throw $this->createAccessDeniedException("You cannot access the requested ressource!");
        }

        return $this->render('showcase/watch.show.html.twig', [
            'watch' => $watch,
            'showcase' => $showcase,
        ]);
    }
}