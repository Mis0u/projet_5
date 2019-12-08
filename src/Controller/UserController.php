<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
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
}
