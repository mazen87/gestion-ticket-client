<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email' ,EmailType::class,

            [   'label'=>false,
                'attr' => [
                'placeholder' => 'votre Email'
            ]
            ])
      
            ->add('password',RepeatedType::class,[
                'type' => PasswordType::class,
                'invalid_message' => 'mot de passe et confirmation sont pas identiques.',
                'first_options' => ['label' => false, 'attr' => [
                    'placeholder' => 'Mot de passe '
                ]],
                'second_options' => ['label' => false, 'attr' => [
                    'placeholder' => 'Confirmation  mot de passe '
                ]]
            ])
            ->add('nom',TextType::class,

            [   'label'=>false,
                'attr' => [
                'placeholder' => 'votre nom'
            ]
            ])
            ->add('prenom' ,TextType::class,

            [   'label'=>false,
                'attr' => [
                'placeholder' => 'votre prénom'
            ]
            ])
            ->add('status' ,ChoiceType::class,

            [  
                'choices' =>[
                    'Client' => 'cli',
                    'Admin'=> 'adm',
                    'Support' => 'sup'
                   
                ],
                'label'=>false,
                'attr' => [
                'value' => 'cli',
                'required'   => false,
                'selected' => 'cli',
            ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
