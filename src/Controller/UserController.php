<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\Session;

#[Route('/user')]
final class UserController extends AbstractController
{
    #[Route('/mon-compte', name: 'user_index', methods: ['GET'])]
    public function profil(): Response
    {
        $user = $this->getUser();
        dd($user);
        return $this->render('user/index.html.twig');
    }
}
