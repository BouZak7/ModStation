<?php

namespace App\Controller;

use App\Entity\Products;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(Session $session, ProductsRepository $productsRepository): Response
    {
        $panier = $session->get('panier', []);

        $data = [];
        $total = 0;

        foreach($panier as $id => $quantite){
            $product = $productsRepository->find($id);

            $data[] = [
                'product' => $product,
                'quantite' => $quantite
            ];
            $total += $product->getPrix() * $quantite;
        }

        // dd($data);

        return $this->render('panier/index.html.twig', compact('data','total'));
    }

    #[Route('/add/{id}', name: 'app_panier_add', methods: ['GET', 'POST'])]
    public function add(Products $product, Session $session)
    {
        // on récupère l'id du produit
        $id = $product->getId();

        //on récupère le panier existant
        $panier = $session->get('panier', []);

        // clé = id du produit, valeur = qté
        // $panier[17] = 1;

        //On ajoute le produit dans le panier ou incrémente la qté s'il y est déjà
        if(empty($panier[$id])){
            $panier[$id] = 1;
        }
        else{
            $panier[$id]++;
        }

        $session->set('panier', $panier);
        // dd($session);

        return $this->redirectToRoute('app_panier');
    }

    #[Route('/remove/{id}', name: 'app_panier_remove', methods: ['GET', 'POST'])]
    public function remove(Products $product, Session $session)
    {
        // on récupère l'id du produit
        $id = $product->getId();

        //on récupère le panier existant
        $panier = $session->get('panier', []);

        //On retire le produit dans le panier ou décrémente la qté s'il y est plus d'une fois
        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id] --;
            }
            else{
                unset($panier[$id]);
            }
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('app_panier');
    }

    #[Route('/delete/{id}', name: 'app_panier_delete', methods: ['GET', 'POST'])]
    public function delete(Products $product, Session $session)
    {
        // on récupère l'id du produit
        $id = $product->getId();

        //on récupère le panier existant
        $panier = $session->get('panier', []);

        //On retire le produit dans le panier ou décrémente la qté s'il y est plus d'une fois
        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('app_panier');
    }
}
