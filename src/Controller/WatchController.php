<?php

namespace App\Controller;

use App\Entity\Watch;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WatchController extends AbstractController
{
    /**
     * Affiche les détails d'une montre spécifique
     *
     * @param int $id
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    #[Route('/watch/{id}', name: 'watch_show', requirements: ['id' => '\d+'])]
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $watch = $doctrine->getRepository(Watch::class)->find($id);

        if (!$watch) {
            throw $this->createNotFoundException('La montre avec l\'ID ' . $id . ' n\'existe pas');
        }

        return $this->render('watch/show.html.twig', [
            'watch' => $watch,
        ]);
    }
}
 ?>
