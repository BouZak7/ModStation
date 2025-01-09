<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\User;
use DateTime;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

#[Route('/mes-commandes')]
class OrderController extends AbstractController
{
    #[Route(name: 'app_order')]
    public function index(): Response
    {
        return $this->render('order/index.html.twig', [
            'controller_name' => 'OrderController',
        ]);
    }

    #[Route('/add', name: 'order_new', methods: ['GET', 'POST'])]
    public function new(Session $session, ProductsRepository $productsRepository, EntityManagerInterface $entityManager): Response
    {
        $date = new DateTime();
        $user = $this->getUser();
        $panier = $session->get('panier', []);
        if (!$user instanceof User) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }
        $orderNumber = $user->getId(). '-' . date('YmdHis');

        $data = [];
        $total = 0;

        $order = new Order();

        foreach($panier as $id => $quantite){
            $product = $productsRepository->find($id);

            $data[] = [
                'product' => $product,
                'quantite' => $quantite
            ];
            $total += $product->getPrix() * $quantite;
            for($i=0; $i<$quantite; $i++ ){
                $order->addProduit($product);
            }
        }

        $order->setNumero($orderNumber);
        $order->setPrix($total);
        $order->setDateCommande($date);
        $order->setStatut('en cours');
        $order->setUser($user);

        // dd($order);


        $entityManager->persist($order);
        $entityManager->flush();

        return $this->redirectToRoute('app_order', [], Response::HTTP_SEE_OTHER);
    }
}
