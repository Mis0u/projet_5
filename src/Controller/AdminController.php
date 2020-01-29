<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Image;
use App\Entity\SearchImages;
use App\Entity\SearchUsers;
use App\Form\SearchUsersType;
use App\Form\SearchImagesType;
use App\Repository\UserRepository;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/admin.html.twig');
    }

     /**
     * @Route("/admin/users", name="admin_users")
     */
    public function displayUsers(UserRepository $users, PaginatorInterface $pi, Request $request)
    {
        $searchUsers = new SearchUsers();
        $form = $this->createForm(SearchUsersType::class, $searchUsers);
        $form->handleRequest($request);

        $getAllUsers = $pi->paginate(
            $users->findAllWithPagination($searchUsers), 
            $request->query->getInt('page', 1), 
            10 
        );
        return $this->render('admin/users.html.twig', ['users' =>$getAllUsers, 'form' => $form->createView()]);
    }

    /**
     * @Route("/admin/images", name="admin_images")
     */
    public function displayImages(ImageRepository $images, PaginatorInterface $pi, Request $request)
    {
        $searchImages = new SearchImages();
        $form = $this->createForm(SearchImagesType::class, $searchImages);
        $form->handleRequest($request);
        
        $getAllImages = $pi->paginate(
            $images->findAllWithPagination($searchImages), 
            $request->query->getInt('page', 1), 
            10 
        );
        return $this->render('admin/images.html.twig', ['images' =>$getAllImages, 'form' => $form->createView()]);
    }

     /**
     * @Route("/admin/userdelete/{id}", name="admin_delete_user")
     */
    public function deleteUser(User $user, EntityManagerInterface $manager){
        $manager->remove($user);
        $manager->flush();

        $this->addFlash("success_delete","L'utilisateur a bien été supprimé");
        return $this->redirectToRoute("admin_users");
    }

     /**
     * @Route("/admin/userimage/{id}", name="admin_delete_image")
     */
    public function deleteImage(Image $image, EntityManagerInterface $manager){
        $manager->remove($image);
        $manager->flush();

        $this->addFlash("success_delete","L'image a bien été supprimé");
        return $this->redirectToRoute("admin_images");
    }


}
