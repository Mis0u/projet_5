<?php

namespace App\Controller;

use App\Entity\SearchTags;
use App\Form\SearchTagsType;
use App\Repository\ImageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, ImageRepository $imageRepo) : Response
    {
        $research = new SearchTags();

        $form = $this->createForm(SearchTagsType::class, $research);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $searchImage = $imageRepo->findImagesByTag($research);
            return $this->render('home/search.html.twig', ['searchImage' => $searchImage, 'form' => $form->createView(), 'research' => $research]);
        }

        return $this->render('home/index.html.twig',['form' => $form->createView()]);
    }
}
