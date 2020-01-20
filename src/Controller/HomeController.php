<?php

namespace App\Controller;

use App\Entity\SearchTags;
use App\Form\SearchTagsType;
use App\Repository\ImageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request,ImageRepository $imageRepo)
    {
        $research = new SearchTags();

        $form = $this->createForm(SearchTagsType::class, $research);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $SearchImage = $imageRepo->findImagesByTag($research);
            return $this->render('home/search.html.twig', ['searchImage' => $SearchImage]);
        }

        return $this->render('home/index.html.twig',['form' => $form->createView()]);
    }

    /**
     * @Route("/search/{tags}", name="search")
     */
    public function searchResult(Request $request, ImageRepository $imageRepo, $tags)
    {
        $research = new SearchTags();

        $form = $this->createForm(SearchTagsType::class, $research);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $tags = $imageRepo->findImagesByTag($research);
            return $this->render('home/search.html.twig', ['tags' => $tags]);
        }
        return $this->render('home/search.html.twig', ['tags' => $tags]);
    }
}
