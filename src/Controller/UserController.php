<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Image;
use App\Form\ImageType;
use App\Form\EditImageType;
use App\Repository\TagRepository;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/profile", name="user_profile")
     */
    public function userProfile(ImageRepository $imageRepository, TagRepository $tagRepository)
    {
        $user = $this->getUser();
        $getAllImages = $imageRepository->findBy(['user' => $user]);
        $test = $tagRepository->findAll()
;        return $this->render('user/user.html.twig', ["user"=>$user, "images" => $getAllImages, 'test' => $test]);
    }

    /**
     * @Route("/profile/add", name="add_image")
     */
    public function addImage(EntityManagerInterface $manager, Request $request, TagRepository $tagRepository, ImageRepository $image)
    {
            $image = new Image();

            $user = $this->getUser();
            $selectTags = $tagRepository->findAll();
            $form = $this->createForm(ImageType::class, $image);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()){
                /**@var UploadedFile $file */
                $file = $form["file"]->getData();

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


                $this->addFlash("success","Votre image a bien été uploadé");

                return $this->redirectToRoute("user_profile");

            }
            return $this->render("user/add.html.twig",[
                "form" => $form->createView(), 'tags' => $selectTags, 'image' => $image
            ]);
    }

    /**
     * @Route("/profile/edit/{id}", name="edit_image")
     */
    public function editImage(EntityManagerInterface $manager, Request $request, TagRepository $tagRepository, Image $image)
    {
        $this->denyAccessUnlessGranted('EDIT', $image);

            $user = $this->getUser();
            $selectTags = $tagRepository->findAll();
            $form = $this->createForm(EditImageType::class, $image);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()){
                /**@var UploadedFile $file */
                $file = $form["file"]->getData();

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

                $this->addFlash("success","Votre image a bien été modifié");
                return $this->redirectToRoute("display_images");

            }
            return $this->render("user/edit.html.twig",[
                "form" => $form->createView(), 'tags' => $selectTags, 'image' => $image
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
    public function displayImagesTags(Tag $tag, ImageRepository $imageRepository, PaginatorInterface $pi, Request $request)
    {  
        $user = $this->getUser();
        $getAllImages = $pi->paginate($imageRepository->findUserImagesByTag($tag, $user),$request->query->getInt('page', 1), 
        10 );
        return $this->render("user/imagesFromTags.html.twig", ["images" => $getAllImages, 'tag' => $tag]);
    }

    /**
     * @Route("/profile/delete/{id}", name="delete_image")
     */
    public function delete(Image $image, EntityManagerInterface $manager){

        $this->denyAccessUnlessGranted('DELETE', $image);

        $manager->remove($image);
        $manager->flush();

        $this->addFlash("success_delete","Votre image a bien été supprimé");
        return $this->redirectToRoute("display_images");
    }

    /**
     * @Route("/profile/tags", name="cloud_tags")
     */
    public function allTags(TagRepository $tagRepo)
    {
        $allTags = $tagRepo->findAll();
        return $this->render("user/allTags.html.twig", ["cloud" => $allTags]);

    }

}
