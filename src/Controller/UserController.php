<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Tag;
use App\Form\ImageType;
use App\Repository\TagRepository;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/profile", name="user_profile")
     */
    public function userProfile()
    {
        $user = $this->getUser();

        return $this->render('user/user.html.twig', ["user"=>$user]);
    }

    /**
     * @Route("/profile/add", name="add_image")
     */
    public function addImage(EntityManagerInterface $manager, Request $request)
    {
            $image = new Image();
            $user = $this->getUser();
            $form = $this->createForm(ImageType::class, $image);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()){
                /**@var UploadedFile $file */
                $file = $form["file"]->getData();

               // $image->addTag($tag);
                if ($file) {
                    $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $newFilename = $originalFilename.'-'.uniqid().'.'.$file->guessExtension();

                    $image->setName($newFilename);
                    $image->setUser($user);
                    $file->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                };

                $manager->persist($image);
                $manager->flush();

                $this->addFlash("success_upload","Votre image a bien été uploadé");
                return $this->redirectToRoute("user_profile");

            }
            return $this->render("user/add.html.twig",[
                "form" => $form->createView(),
            ]);
    }

    /**
     * @Route("/profile/images", name="display_images")
     */
    public function displayImages(ImageRepository $imageRepository)
    {
        $user = $this->getUser();
        $getAllImages = $imageRepository->findBy(['user' => $user]);
        return $this->render("user/allImages.html.twig", ["images" => $getAllImages, 'user' => $user]);
    }

    /**
     * @Route("/profile/tags/{name}", name="display_images_tags")
     */
    public function displayImagesTags(Tag $tag)
    {  
        return $this->render("user/imagesFromTags.html.twig", ["tag" => $tag]);
    }
}
