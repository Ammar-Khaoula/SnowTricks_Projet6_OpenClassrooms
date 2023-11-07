<?php

namespace App\Form;


use App\Entity\VideoUrls;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
      ->add('name', UrlType::class,  [
            "label" => "Lien de la vidéo",
            "label_attr" => [
                "class" => "form-label"
            ],
            "required" => false,
            "row_attr" => [
                "class" => "mb-3"
            ],
            "attr" => [
                "class" => "form-control"
            ],
            "mapped" => false,
            "constraints" => [
                new Url([
                    "protocols" => ["https"],
                    "message" => "L'URL n'est pas valide.",
                ]),

            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VideoUrls::class,
        ]);
    }
}
