<?php

namespace App\Form;

use App\Entity\SearchTags;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SearchTagsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                "required" => false,
                "label" => "Rechercher",
                "attr" =>[ "placeholder" => "Exemple : Lune, Mars, Météorite..."]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchTags::class,
            'method' => "GET",
            'csrf_protection' => false
        ]);
    }

    
    public function getBlockPrefix()
    {
        return '';
    }
}
