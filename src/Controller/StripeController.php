<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Classe\Cart;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class StripeController extends AbstractController
{
    #[Route('/commande/create-session', name: 'stripe_create_session')]
    public function index(Cart $cart): Response
    {
        $products_for_stripe = [];
        $YOUR_DOMAIN = 'http://localhost/ShopGrocery/public/index.php';


        foreach ($cart->getFull() as $product) {

            $products_for_stripe[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $product['product']->getPrice(),
                    'product_data' => [
                        'name' => $product['product']->getName(),
                        'images' => [$_SERVER['SITE_URL'] . "/uploads/" . $product['product']->getIllustration()],
                    ],
                ],
                'quantity' => $product['quantity'],
            ];
        }
        // key secret : 
        Stripe::setApiKey('sk_test_51LOxQUG3M2m1aLWJDmvm5xo3yjSwYJCPwWb7XOVv2umRVabbqXEQqVMIuNSeYCtHzb1j5AZKhRH9frq01P6OMzWd0040aDZR07');

        $checkout_session = Session::create([
            'line_items' => [[
                # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                $products_for_stripe
            ]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/success.html',
            'cancel_url' => $YOUR_DOMAIN . '/cancel.html',
        ]);
        // 'stripe_checkout_session' => $checkout_session->id


        // $responce = new JsonResponse(['id' => $checkout_session->id]);
        // return $responce;
        return $this->redirect($checkout_session->url);
        // return $this->render('stripe/index.html.twig');
    }
}
