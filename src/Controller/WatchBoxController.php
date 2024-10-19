<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry; 

use App\Entity\WatchBox;

class WatchBoxController extends AbstractController
{

	/**
	Récupere la liste des Watchboxes
	*/

  #[Route('/watchbox', name: 'app_watch_box')]
  public function index(ManagerRegistry $doctrine): Response
  {
  $watchBoxes = $doctrine->getRepository(WatchBox::class)->findAll();

  return $this->render('watch_box/index.html.twig', [
      'watchBoxes' => $watchBoxes,
  ]);
  }

	/**
 	* Affiche une WatchBox par id
 	* @param Integer $id
	* @param ManagerRegistry $doctrine
        * @return Response
        */

	#[Route('/watchbox/{id}', name: 'watchBox_show', requirements: ['id' => '\d+'])]
	public function show(ManagerRegistry $doctrine, $id) : Response
	{
        $watchBoxRepo = $doctrine->getRepository(WatchBox::class);
        $watchBox = $watchBoxRepo->find($id);

        if (!$watchBox) {
                throw $this->createNotFoundException('La Watchbox avec l\' '.$id.' n\'existe pas.');
        }
	// Récupérer les montres associées
        $watches = $watchBox->getWatches();
        
	return $this->render('watch_box/show.html.twig', [
            'watchBox' => $watchBox,
	    'watches' => $watches,
        ]);

}
}
