<?php

namespace App\Form\DataTransformer;

use App\Entity\Tag;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;

class TagsTransformer implements DataTransformerInterface
{
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function transform($value)
    {
        return implode("," , $value->map(function($tag){
            return $tag->getName();
        })->toArray());
    }

    public function reverseTransform($value)
    {
        $tags = explode(",", $value);
        $tagsCollection = new ArrayCollection();
        foreach ($tags as $tagName){
            $tag = $this->manager->getRepository(Tag::class)->findOneBy(["name"=> $tagName]);
            if ($tag == NULL){
                $tag = new Tag();
                $tag->setName($tagName);
            }
            $tagsCollection->add($tag);
        }
        return $tagsCollection; 
    }
}