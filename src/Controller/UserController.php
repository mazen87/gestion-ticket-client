<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterUserType;
use App\Repository\UserRepository;
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
           'formInscription' => $formInscription->createView(),
           'user'=> $user
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

    /**
     * @Route("/monProfil/{id}" , name="mon-profil" ,requirements={"id"="\d+"} )
     */

     public function monProfil (User $user , Request $request , EntityManagerInterface $em ){
            $formMonOrofil = $this->createForm(RegisterUserType::class,$user);
            $formMonOrofil ->handleRequest($request);

            if($formMonOrofil->isSubmitted() && $formMonOrofil ->isValid()){
                $em->persist($user);
                $em->flush();
    
                $this->addFlash('succes','Profil a bien été modifié avec succes');
                return $this->redirectToRoute('home');
            }


        return $this->render('user/inscription.html.twig',[
            'formInscription' => $formMonOrofil->createView()
        ]);
     }

     /**
      *@Route("/allProfils"  , name="allProfils")
      */
      public function tousLesProfils(UserRepository $userRep ){
          $users = $userRep->findAll();

          return $this->render('user/tousLesProfils.html.twig',[
              'users' => $users
          ]);

      }

      
     /**
      *@Route("/allProfils/{id}"  , name="allProfils",requirements={"id"="\d+"} )
      */
    /*   public function userDetails(UserRepository $userRep,User $user, EntityManagerInterface $rm, Request $request){
        

        return $this->render('user/tousLesProfils.html.twig',[
          
        ]);

    } */
}
