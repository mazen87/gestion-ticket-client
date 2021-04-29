<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieFormType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie", name="categorie")
     */
    public function findCategories(CategorieRepository $categorieRep): Response
    {
            $categories = $categorieRep->findAll();
        return $this->render('categorie/categories.html.twig', [
        'categories' => $categories
        ]);
    }

    /**
     * @Route("/categorie-details/{id}", name="categorie-details",requirements={"id"="\d+"} )
     */

     public function modifierCategorie(Request $request,Categorie $categorie, EntityManagerInterface $em) {
         $categorieForm = $this->createForm(CategorieFormType::class, $categorie);
         $categorieForm->handleRequest($request);
         if($categorieForm->isSubmitted() && $categorieForm->isValid()){
            $em->persist($categorie);
            $em->flush();

            $this->addFlash('succes','Catégorie a bien été modifiée avec succes');
            return $this->redirectToRoute('categorie');
         }

         return $this->render('categorie/details.html.twig',[
                'categorieForm' => $categorieForm->createView(),
                'categorie' => $categorie
         ]) ;
     }


     /**
      * @Route("/categorie-add", name="categorie-add")
      */
      public function ajouterCategorie (Request $request,EntityManagerInterface $em) {
          $categorie = new Categorie();
          $categorieForm = $this->createForm(CategorieFormType::class, $categorie);
          $categorieForm->handleRequest($request);
          if($categorieForm->isSubmitted() && $categorieForm->isValid()){
             $em->persist($categorie);
             $em->flush();
 
             $this->addFlash('succes','Catégorie a bien été ajoutée avec succes');
             return $this->redirectToRoute('categorie');
          }
 
          return $this->render('categorie/details.html.twig',[
                 'categorieForm' => $categorieForm->createView(),
                 'categorie' => $categorie
          ]) ;
      }

      /**
       * @Route("/categorie-remove/{id}" , name="categorie-remove",requirements={"id"="\d+"})
       */
      public function supprimerCategorie (Categorie $categorie,EntityManagerInterface $em ){

        $em->remove($categorie);
        $em->flush();
        $this->addFlash('succes','Catégorie a bien été supprimée avec succes');
        return $this->redirectToRoute('categorie');

    
      } 

}
