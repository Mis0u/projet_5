<?php

namespace App\Form;

use App\Entity\SearchUsers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SearchUsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                "required" => false,
                "label" => "Rechercher un utilisateur"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchUsers::class,
            'method' => "GET",
            'csrf_protection' => false
        ]);
    }

    
    public function getBlockPrefix()
    {
        return '';
    }
}
