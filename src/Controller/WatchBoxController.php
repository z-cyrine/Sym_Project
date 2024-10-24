<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\Persistence\ManagerRegistry; 
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\WatchBox;
use App\Entity\Member;
use App\Form\WatchBoxType;

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
  
    /**
   * Crée une nouvelle WatchBox pour un membre.
   *
   * @param ManagerRegistry $doctrine
   * @param int $memberId
   * @return Response
   */
  #[Route('/watchbox/new/{memberId}', name: 'app_watchBox_new', methods: ['GET', 'POST'])]
  public function new(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine, int $memberId): Response
  {
      // Récupérer le membre par son ID
      $member = $doctrine->getRepository(Member::class)->find($memberId);
  
      if (!$member) {
          throw $this->createNotFoundException('Le membre n\'existe pas.');
      }
  
      $watchBox = new WatchBox();
      $watchBox->setMember($member); // Associer la WatchBox au membre récupéré
  
      $form = $this->createForm(WatchBoxType::class, $watchBox);
      $form->handleRequest($request);
  
      if ($form->isSubmitted() && $form->isValid()) {
          $entityManager->persist($watchBox);
          $entityManager->flush();
  
          return $this->redirectToRoute('app_member_show', ['id' => $memberId], Response::HTTP_SEE_OTHER);
      }
  
      return $this->render('watch_box/new.html.twig', [
          'watchBox' => $watchBox,
          'form' => $form,
      ]);
  }


}
