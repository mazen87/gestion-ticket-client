<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Ticket;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,

            [   'label'=>false,
                'attr' => [
                'placeholder' => 'Titre'
            ]
            ])
            ->add('description',TextareaType::class,

            [   'label'=>false,
                'attr' => [
                'placeholder' => 'Description',
                'class' => 'Tinymce'
            ]
            ])
            ->add('termine',ChoiceType::class,[
                'label'=>false,
                'required'=> false,
                'empty_data' => '0',
                'choices' =>[
                    'Encours' => '0',
                    'Terminé' => '1'
                 
                    
                   
                ],
            ])
            ->add('categorie',EntityType::class,[
                'label'=>false,
                'class' => Categorie::class,
                'choice_label' => 'title'
            ])
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
