<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderValidateController extends AbstractController
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {

        $this->manager = $manager;
    }




    #[Route('/commande/merci/{stripeSessionId}', name: 'order_validate')]
    public function index($stripeSessionId, Cart $cart): Response
    {
        $order = $this->manager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('home');
        }

        if (!$order->isIsPaid()) {
            $cart->removeTo();
            $order->setIsPaid(1);
            $this->manager->flush();
        }

        return $this->render('order_validate/index.html.twig', [
            'order' => $order,
        ]);
    }
}
