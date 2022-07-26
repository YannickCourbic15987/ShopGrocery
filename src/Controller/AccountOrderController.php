<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountOrderController extends AbstractController
{


    public function __construct(EntityManagerInterface $manager)
    {

        $this->manager = $manager;
    }
    #[Route('/compte/mes-commande', name: 'account_order')]
    public function index(): Response
    {
        $orders = $this->manager->getRepository(Order::class)->findSuccessOrders($this->getUser());
        // dd($orders);
        return $this->render('account/order.html.twig', [
            'orders' => $orders,
        ]);
    }
    #[Route('/compte/mes-commande/{reference}', name: 'account_order_show')]


    public function show($reference): Response
    {
        $order = $this->manager->getRepository(Order::class)->findOneByReference($reference);
        // dd($orders);


        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account_order');
        }

        return $this->render('account/order_show.html.twig', [
            'order' => $order,
            'reference' => $reference
        ]);
    }
}
