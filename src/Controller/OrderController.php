<?php

namespace App\Controller;


use Stripe\Stripe;
use App\Classe\Cart;
use App\Entity\Order;
use App\Form\OrderType;
use App\Entity\OrderDetails;
use Stripe\Checkout\Session;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderController extends AbstractController
{

    private $manager;
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }


    #[Route('/commande', name: 'order')]
    public function index(Cart $cart): Response
    {

        if (!$this->getUser()->getAddresses()->getValues()) {
            return $this->redirectToRoute('account_address_add');
        }

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);

        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     dd($form->getData());
        // }




        // dd($cart->getTo());
        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'siteurl' => $_SERVER['SITE_URL'],
            'cart' => $cart->getFull(),
        ]);
    }


    #[Route('/commande/recapitulatif', name: 'order_recap', methods: ["POST", "GET"])]
    public function addRecap(Cart $cart, Request $request): Response
    {

        $form = $this->createForm(OrderType::class, null, [
            'user' => $this->getUser()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // dd($form->getData());

            //Enrengistrez ma commande Order()
            $carriers = $form->get('carriers')->getData();
            $delivery = $form->get('addresses')->getData();
            $delivery_content = $delivery->getFirstname() . ' ' . $delivery->getLastname();
            $delivery_content .= '<br/>' . $delivery->getPhone();
            if ($delivery->getCompany()) {

                $delivery_content .= '<br/>' . $delivery->getCompany();
            }
            $delivery_content .= '<br/>' . $delivery->getAddress();
            $delivery_content .= '<br/>' . $delivery->getCity() . ' ' . $delivery->getPostal();
            $delivery_content .= '<br/>' . $delivery->getCountry();
            // dd($delivery_content);
            $date = new \DateTime();
            $order = new Order();
            $reference = $date->format('dmY') . '-' . uniqid();
            $order->setReference($reference);
            $order->setUser($this->getUser());
            $order->setCreateOrder($date);
            $order->setCarrierName($carriers->getName());
            $order->setCarrierPrice($carriers->getPrice());
            $order->setDelivery($delivery_content);
            $order->setIsPaid(0);

            $this->manager->persist($order);


            //lier le stripe avec les produits 

            // $products_for_stripe = [];
            // $YOUR_DOMAIN = 'http://localhost:3306/public';
            // Enrengistrez mes produits OrderDetails()

            foreach ($cart->getFull() as $product) {
                $orderDetails = new OrderDetails();
                $orderDetails->setMyOrder($order);
                $orderDetails->setProduct($product['product']->getName());
                $orderDetails->setQuantity($product['quantity']);
                $orderDetails->setPrice($product['product']->getPrice());
                $orderDetails->setTotal($product['product']->getPrice() * $product['quantity']);

                $this->manager->persist($orderDetails);
            }
            // dd($products_for_stripe);
            $this->manager->flush();
            //payment session stripe 

            // dd($order);
            // dump($checkout_session->id);
            // dd($checkout_session);

            // dd($order);

            return $this->render('order/addRecap.html.twig', [
                'siteurl' => $_SERVER['SITE_URL'],
                'cart' => $cart->getFull(),
                'carrier' => $carriers,
                'delivery' => $delivery_content,
                'reference' => $order->getReference()

            ]);
        }

        return $this->redirectToRoute('cart');







        // dd($cart->getTo());

    }
}
