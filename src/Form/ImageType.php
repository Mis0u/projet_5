<?php

namespace App\Form;

use App\Entity\Tag;
use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use App\Form\DataTransformer\TagsTransformer;
use Symfony\Bridge\Doctrine\Form\DataTransformer\CollectionToArrayTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Quel sera le titre de l\'image ?'
            ])
            ->add('file', FileType::class, [
                'label' => 'Ajouter une image',
                'required' => true,
                'help' => "Maximum 2Mo (jpg, png, jpeg)"
                
            ])
            ->add('tags', EntityType::class, [
                'class'=> Tag::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
            ])

            ->add('hiddenTags', HiddenType::class,[
                'required' => false,
            ]);

        $builder
            ->get('tags')
            //->addModelTransformer(new CollectionToArrayTransformer(), true)
            ->addModelTransformer(new TagsTransformer(), true);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
