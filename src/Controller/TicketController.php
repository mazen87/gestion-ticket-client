<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\TicketFormType;
use App\Repository\ReponseRepository;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends AbstractController
{
    /**
     * @Route("/ticket-add", name="ticket-add")
     */
    public function ticketAdd(Request $request, EntityManagerInterface $em)
    {
        $ticket = new Ticket();
        $ajoutetTicketForm = $this->createForm(TicketFormType::class,$ticket);
        $ajoutetTicketForm->handleRequest($request);

        if($ajoutetTicketForm->isSubmitted() && $ajoutetTicketForm->isValid() ) {
            $ticket->setUser($this->getUser());
            $em->persist($ticket);
            $em->flush();

            $this->addFlash('succes','ticket a bien été ajouté avec succes');
            return $this->redirectToRoute('home');
        }
        
        return $this->render('ticket/ajouterTicket.html.twig', [
          'ajouterTicketForm' => $ajoutetTicketForm->createView(),
          'ticket' => $ticket
        ]);
    }


    /**
     * @Route("/home" , name="home")
     */
    public function home (TicketRepository $ticketRep , EntityManagerInterface $em) {
            $tickets = $ticketRep->findAllTicketswithCategory();
            dump($tickets);

         return  $this->render('ticket/home.html.twig',[
                'mestickets' => $tickets
            ]);
    }

    /**
     * @Route("/ticket-details/{id}" ,name="ticket-Details" ,requirements={"id"="\d+"})
     */

     public function ticketDetails (Ticket $ticket , EntityManagerInterface $em , Request $request, ReponseRepository $reponseRep) {

        $modifierTicketForm = $this->createForm(TicketFormType::class,$ticket);
        $modifierTicketForm->handleRequest($request);
        $reponses = $reponseRep->findAllReponses();

        if($modifierTicketForm->isSubmitted() && $modifierTicketForm->isValid() ) {
            $ticket->setUser($this->getUser());
            $em->persist($ticket);
            $em->flush();

            $this->addFlash('succes','ticket a bien été ajouté avec succes');
            return $this->redirectToRoute('home');
        }
        return $this->render('ticket/details.html.twig', [
            'modifierTicketForm' => $modifierTicketForm->createView(),
            'ticket' => $ticket,
            'reponses' => $reponses
        ]);

     }
}
