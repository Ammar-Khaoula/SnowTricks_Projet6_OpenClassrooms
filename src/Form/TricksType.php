<?php

namespace App\Form;

use App\Entity\Tricks;
use App\Form\VideoType;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TricksType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', options:[
                'label' => false
            ])
            ->add('discription', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'rows' => 10
                ],
            ])
            ->add('pictureTrick', FileType::class,[
                'label' => false,
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
            ->add('categories',options:[
                'label' => false, 
            ])
            ->add('imageUrls', FileType::class,[
                'label' => false,
                'required' => false,
                'mapped' => false,
                'multiple' => true,
                'constraints' => [
                ],
                
            ])
            ->add('videoUrls', CollectionType::class, [
                'entry_type' => VideoType::class,
                'entry_options' => ['label' =>false],
                'allow_add' => true,
                'allow_delete' => true,
                'label'=> false,
                'prototype' => true,
                'required' => false,
                'by_reference' => false
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tricks::class,
        ]);

    }
}
