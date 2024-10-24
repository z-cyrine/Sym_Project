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
    #[Route('/member/{memberId}', name: 'app_showcase_index', methods: ['GET'])]
    public function index(int $memberId, ManagerRegistry $doctrine, ShowcaseRepository $showcaseRepository): Response
    {
        // R�cup�rer le membre par son ID
        $member = $doctrine->getRepository(Member::class)->find($memberId);
        if (!$member) {
            throw $this->createNotFoundException('Le membre n\'existe pas.');
        }
    
        // Afficher uniquement les showcases publi�es pour ce membre
        $showcases = $showcaseRepository->findBy(['createur' => $member, 'publiee' => true]);
    
        return $this->render('showcase/index.html.twig', [
            'showcases' => $showcases,
            'member' => $member, 
        ]);
    }

    


    #[Route('/showcase/new/{memberId}', name: 'app_showcase_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine, int $memberId): Response
    {
        // R�cup�rer le membre par son ID
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
        return $this->render('showcase/show.html.twig', [
            'showcase' => $showcase,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_showcase_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Showcase $showcase, EntityManagerInterface $entityManager): Response
    {
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
     * Affiche les d�tails d'une montre sp�cifique
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

        return $this->render('showcase/watch.show.html.twig', [
            'watch' => $watch,
        ]);
    }
    
    
    /**
     * Affiche une montre dans le contexte d'une galerie.
     *
     * @param Showcase $showcase La galerie (Showcase) o� se trouve la montre
     * @param Watch $watch       La montre � afficher
     */
    #[Route('/showcase/{showcase_id}/watch/{watch_id}', 
        name: 'app_showcase_watch_show_v2', 
        requirements: ['showcase_id' => '\d+', 'watch_id' => '\d+']
    )]
    public function watchShow_v2(
        #[MapEntity(id: 'showcase_id')] Showcase $showcase,
        #[MapEntity(id: 'watch_id')] Watch $watch
    ): Response {
        // V�rifier que la montre est bien dans la galerie
        if (! $showcase->getWatches()->contains($watch)) {
            throw $this->createNotFoundException("La montre demand�e n'est pas dans cette galerie !");
        }

        // V�rifier que la galerie est publique (ou ajouter une logique pour les galeries priv�es autoris�es)
        if (! $showcase->isPublished()) {
            throw $this->createAccessDeniedException("Vous ne pouvez pas acc�der � cette ressource !");
        }

        return $this->render('showcase/watch_show.html.twig', [
            'watch' => $watch,
            'showcase' => $showcase,
        ]);
    }
}
