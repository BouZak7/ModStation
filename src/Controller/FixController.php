<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProductsRepository;

#[Route('/reparation')]
class FixController extends AbstractController
{
    #[Route(name: 'app_fix')]
    public function index(): Response
    {
        return $this->render('fix/index.html.twig', [
            'controller_name' => 'FixController',
        ]);
    }

    #[Route('/{categorie}', name: 'app_fix_category', methods: ['GET'])]
    public function category(ProductsRepository $productsRepository, $categorie): Response
    {
        return $this->render('fix/fix.html.twig', [
            'products' => $productsRepository->findByCategoryAndService($categorie, 2),
        ]);
    }
}
