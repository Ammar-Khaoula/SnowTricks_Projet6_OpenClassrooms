<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('avatar', FileType::class,[
            'label' => 'ajouter une photo',
            'required' => false,
            'mapped' => false,
            'constraints' => [
                new File([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'image/gif',
                        'image/jpeg',
                        'image/jpg',
                        'image/png',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid Image',
                ])
            ],
            
        ])
        ->add('name', TextType::class, [
            'label'=>false,
            'attr'=>[
                'placeholder'=> 'Entrer Votre Nom',
                'class'=> 'form-control mt-5'
            ],
            'row_attr'=>[
                'class'=>'form-group mb-3'
            ]
        ])
        ->add('email', EmailType::class, [
            'label'=>false,
            'attr'=>[
                'placeholder'=> 'Entrer Votre Email',
                'class'=> 'form-control mt-4'
            ],
            'row_attr'=>[
                'class'=>'form-group mb-3'
            ]
        ])
        ->add('plainPassword', PasswordType::class, [
            // instead of being set onto the object directly,
            // this is read and encoded in the controller
            'mapped' => false,
            'label'=>false,
            'attr' => [
                'placeholder'=> 'mot de passe',
                'class' => 'form-control',
                'autocomplete' => 'new-password'
            ],
            'constraints' => [
                new Length([
                    'min' => 6,
                    'minMessage' => 'Your password should be at least {{ limit }} characters',
                    // max length allowed by Symfony for security reasons
                    'max' => 4096,
                ]),
            ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
