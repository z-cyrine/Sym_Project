<?php

namespace App\Controller;
use App\Entity\WatchBox;
use App\Entity\Watch;
use App\Form\WatchType;
use App\Repository\WatchRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/watch')]
final class WatchController extends AbstractController
{
    #[Route(name: 'app_watch_index', methods: ['GET'])]
    public function index(WatchRepository $watchRepository): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            $watches = $watchRepository->findAll();
        } else {
            $member = $this->getUser();
            $watches = $watchRepository->findMemberWatches($member);
        }
        return $this->render('watch/index.html.twig', [
            'watches' => $watchRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_watch_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, WatchBox $watchBox): Response
    {
        $watch = new Watch();
        
        $watch->setWatchBox($watchBox);
    
        $form = $this->createForm(WatchType::class, $watch);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
        
            $entityManager->persist($watch);
            $entityManager->flush();
    
            return $this->redirectToRoute('watchBox_show', [
                'id' => $watchBox->getId(),
            ], Response::HTTP_SEE_OTHER);
        }
    
        return $this->render('watch/new.html.twig', [
            'watch' => $watch,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_watch_show', methods: ['GET'])]
    public function show(Watch $watch): Response
    {
        return $this->render('watch/show.html.twig', [
            'watch' => $watch,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_watch_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Watch $watch, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(WatchType::class, $watch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('watchBox_show', [
                'id' => $watch->getWatchBox()->getId()
            ], Response::HTTP_SEE_OTHER);
    }

        return $this->render('watch/edit.html.twig', [
            'watch' => $watch,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_watch_delete', methods: ['POST'])]
    public function delete(Request $request, Watch $watch, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$watch->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($watch);
            $entityManager->flush();
        }

        return $this->redirectToRoute('watchBox_show', [
            'id' => $watch->getWatchBox()->getId()
        ], Response::HTTP_SEE_OTHER);
    }
}
