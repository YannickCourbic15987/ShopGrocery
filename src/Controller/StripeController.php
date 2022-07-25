<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Classe\Cart;
use App\Entity\Order;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class StripeController extends AbstractController
{
    #[Route('/commande/create-session/{reference}', name: 'stripe_create_session')]
    public function index($reference, EntityManagerInterface $manager): Response
    {
        $products_for_stripe = [];
        $YOUR_DOMAIN = 'http://localhost/ShopGrocery/public/index.php';

        $order = $manager->getRepository(Order::class)->findOneByReference($reference);
        if (!$order) {
            new JsonResponse(['error' => 'order']);
        }
        foreach ($order->getOrderDetails()->getValues() as $product) {
            $products_object = $manager->getRepository(Product::class)->findOneByName($product->getProduct());
            $products_for_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product->getPrice(),
                    'product_data' => [
                        'name' => $product->getProduct(),
                        'images' => [$_SERVER['SITE_URL'] . "/uploads/" . $products_object->getIllustration()],
                    ],
                ],
                'quantity' => $product->getQuantity(),
            ];
        }
        $products_for_stripe[] = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $order->getCarrierPrice() * 100,
                'product_data' => [
                    'name' => $order->getCarrierName(),
                ],
            ],
            'quantity' => 1,
        ];
        // dd($products_for_stripe);
        // key secret : 
        Stripe::setApiKey('sk_test_51LOxQUG3M2m1aLWJDmvm5xo3yjSwYJCPwWb7XOVv2umRVabbqXEQqVMIuNSeYCtHzb1j5AZKhRH9frq01P6OMzWd0040aDZR07');

        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail(),
            'payment_method_types' => ['card'],
            'line_items' => [[
                # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                $products_for_stripe
            ]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/commande/merci/{CHECKOUT_SESSION_ID}',
            'cancel_url' => $YOUR_DOMAIN . '/commande/erreur/{CHECKOUT_SESSION_ID}',
        ]);
        // 'stripe_checkout_session' => $checkout_session->id

        $order->setStripeSessionId($checkout_session->id);
        $manager->flush();

        // $responce = new JsonResponse(['id' => $checkout_session->id]);
        // return $responce;


        return $this->redirect($checkout_session->url);
        // return $this->render('stripe/index.html.twig');
    }
}
