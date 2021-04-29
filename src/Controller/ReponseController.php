<?php

namespace App\Controller;

use App\Entity\Reponse;
use App\Entity\Ticket;
use App\Form\ReponseFormType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReponseController extends AbstractController
{
    /**
     * @Route("/reponse/{id}", name="reponse",requirements={"id"="\d+"})
     */
    public function ajouterReponse(Ticket $ticket,Request $request,EntityManagerInterface $em): Response
    {

        $reponse = new Reponse();
        $ajouterReponseForm = $this->createForm(ReponseFormType::class,$reponse );
        $ajouterReponseForm->handleRequest($request);
        $reponse->setDateCreation(new \DateTime());

        if($ajouterReponseForm->isSubmitted() && $ajouterReponseForm->isValid() ) {
            $reponse->setUser($this->getUser());
            $reponse->setTicket($ticket);
           
            dump($reponse);
            $em->persist($reponse);
            $em->flush();

            $this->addFlash('succes','Réponse a bien été ajouté avec succes');
            return $this->redirectToRoute('ticket-Details',['id' => $ticket->getId()]);
        }
        return $this->render('reponse/ajouterReponse.html.twig', [
           'ajouterReponseForm' => $ajouterReponseForm->createView()
        ]);
    }
}
