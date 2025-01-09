<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Products;
use App\Entity\OrderProduct;
use App\Entity\User;
use DateTime;
use App\Repository\ProductsRepository;
use App\Repository\OrderRepository;
use App\Repository\OrderProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

#[Route('/mes-commandes')]
class OrderController extends AbstractController
{
    #[Route(name: 'app_order')]
    public function index(ProductsRepository $productsRepository, OrderRepository $orderRepository, OrderProductRepository $orderproductRepository): Response
    {
        $user = $this->getUser();

        if (!$user instanceof User) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        $orders = $orderRepository->findBy(['user' => $user->getId()]);
        // dd($orders);
        
        $orderP = $orders[3]->getOrderProducts();
        // dd($orderP);
        
        // $products = $productsRepository->findby(['id' => $orderP->getProduct()]);
        // dd($products);
        
        // $product = $productsRepository->find();

        return $this->render('order/index.html.twig', [
            // 'products' => $productsRepository->findBy(1),
            'commande' => $orders,
            // 'orderproduct' => $orderproductRepository->findByService(1),
        ]);
    }

    #[Route('/{numero}', name: 'app_order_show', methods: ['GET'])]
    public function show(/*Products $product, OrderProduct $orderproduct,*/ $numero, OrderRepository $orderRepository): Response
    {
        $order = $orderRepository->findBy(['numero' => $numero]);
        // dd($order);
        
        $orderP = $order[0]->getOrderProducts();
        // dd($orderP[0]->getQuantite());

        $products = [];
        $qte = [];
        
        foreach($orderP as $orderP){
            $products[] = ['product' => $orderP->getProduct(),
                'qte' => $orderP->getQuantite()
            ];
        }
        // dd($products);
        return $this->render('order/show.html.twig', [
            'products' => $products,
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
            $orderP = new OrderProduct();
            $product = $productsRepository->find($id);
            
            $total += $product->getPrix() * $quantite;
            
            $orderP->setProduct($product);
            $orderP->setQuantite($quantite);
            $orderP->setCommande($order);
            $entityManager->persist($orderP);
        }
        
        $order->setNumero($orderNumber);
        $order->setDateCommande($date);
        $order->setPrix($total);
        $order->setStatut('en cours');
        $order->setUser($user);
        

        $entityManager->persist($order);
        $entityManager->flush();
        
        $session->remove('panier');

        return $this->redirectToRoute('app_panier', [], Response::HTTP_SEE_OTHER);
    }
}
