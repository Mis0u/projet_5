<?php

namespace App\Form;

use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use App\Form\DataTransformer\TagsTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class ImageType extends AbstractType
{
    public function __construct(TagsTransformer $tagsTransformer)
    {
        $this->tagsTransformer = $tagsTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Ensuite le titre '
            ])
            ->add('file', FileType::class, [
                'label' => 'D\'abord l\'image',
                'required' => false,
                'help' => "Maximum 2Mo (jpg, png, jpeg)"
            ])

            ->add('tags', HiddenType::class,[
                'required' => false,
            ]);

        $builder
            ->get('tags')
            ->addModelTransformer($this->tagsTransformer, true);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
            'validation_groups' => ['Default', 'add_image']
        ]);
    }
}
