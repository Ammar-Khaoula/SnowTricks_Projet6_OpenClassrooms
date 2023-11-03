<?php

namespace App\Form;

use App\Entity\Tricks;
use App\Form\VideoType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TricksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', options:[
                'label' => 'Nom'
            ])
            ->add('discription', TextareaType::class, [
                'label' => 'description',
                'attr' => [
                    'rows' => 10
                ],
            ])
            ->add('image', FileType::class,[
                'label' => 'image principale',
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
            ->add('imageUrls', FileType::class,[
                'label' => 'illustration',
                'required' => false,
                'mapped' => false,
                'multiple' => true,
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
            ->add('videoUrls', CollectionType::class, [
                'entry_type' => VideoType::class,
                'label' => false,
                'entry_options' => ['label' => false],
                'required' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false
            ])
            ->add('categories')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tricks::class,
        ]);
    }
}
