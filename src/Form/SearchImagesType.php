<?php

namespace App\Form;

use App\Entity\SearchImages;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SearchImagesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,[
                'required' => false,
                'label' => "Recherche une image (titre)"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchImages::class,
            'method' => "GET",
            'csrf_protection' => false
        ]);
    }

    
    public function getBlockPrefix()
    {
        return '';
    }
}
