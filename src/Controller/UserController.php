<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription")
     */
    public function index(Request $request, UserPasswordEncoderInterface $motPassEncoder,EntityManagerInterface $em): Response
    {

            $user = new User();
            $formInscription = $this->createForm(RegisterUserType::class,$user);

            $formInscription->handleRequest($request);

            if($formInscription ->isSubmitted() && $formInscription->isValid()){
                $user ->setPassword(
                    $motPassEncoder->encodePassword($user,$formInscription->get('password')->getData())
                );
                $em->persist($user);
                $em->flush();

                $this->addFlash('succes','votre inscription a été effectuée avec succes');
                return $this->redirectToRoute('home');
            }


        return $this->render('user/inscription.html.twig', [
           'formInscription' => $formInscription->createView()
        ]);
    }

    /**
     * @Route("/login", name="login")
     */

    public function connexion(AuthenticationUtils $authentificationUtils) {
        $error = $authentificationUtils->getLastAuthenticationError();
        $lastUSerName = $authentificationUtils->getLastUsername();

        return $this->render('user/connexion.html.twig' ,[
            'last_username' => $lastUSerName,
            'error' => $error
            ]);
    }
}
