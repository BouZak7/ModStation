<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ProductsType;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/products')]
final class ProductsController extends AbstractController
{
    #[Route(name: 'app_products_index', methods: ['GET'])]
    public function index(ProductsRepository $productsRepository): Response
    {
        return $this->render('products/index.html.twig', [
            'products' => $productsRepository->findByService(1),
        ]);
    }

    #[Route('/{categorie}', name: 'app_products_category', methods: ['GET'], requirements: ['categorie' => '[a-zA-Z]+[a-zA-Z0-9-]*'])]
    public function category(ProductsRepository $productsRepository, $categorie): Response
    {
        return $this->render('products/index.html.twig', [
            'products' => $productsRepository->findByCategoryAndService($categorie, 1),
        ]);
    }

    #[Route('/{id}', name: 'app_products_show', methods: ['GET'], requirements: ['id' => '\d+'])]
    public function show(Products $product): Response
    {
        return $this->render('products/show.html.twig', [
            'product' => $product,
        ]);
    }

    // #[Route('/mod', name: 'app_mod_index', methods: ['GET'])]
    // public function mod(ProductsRepository $productsRepository): Response
    // {
    //     return $this->render('products/index.html.twig', [
    //         'products' => $productsRepository->findByService(1),
    //     ]);
    // }

    // #[Route('/new', name: 'app_products_new', methods: ['GET', 'POST'])]
    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $product = new Products();
    //     $form = $this->createForm(ProductsType::class, $product);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->persist($product);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_products_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('admin/products/new.html.twig', [
    //         'product' => $product,
    //         'form' => $form,
    //     ]);
    // }


    // #[Route('/{id}/edit', name: 'app_products_edit', methods: ['GET', 'POST'])]
    // public function edit(Request $request, Products $product, EntityManagerInterface $entityManager): Response
    // {
    //     $form = $this->createForm(ProductsType::class, $product);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_products_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('admin/products/edit.html.twig', [
    //         'product' => $product,
    //         'form' => $form,
    //     ]);
    // }

    // #[Route('/{id}', name: 'app_products_delete', methods: ['POST'])]
    // public function delete(Request $request, Products $product, EntityManagerInterface $entityManager): Response
    // {
    //     if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->getPayload()->getString('_token'))) {
    //         $entityManager->remove($product);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_products_index', [], Response::HTTP_SEE_OTHER);
    // }
}
