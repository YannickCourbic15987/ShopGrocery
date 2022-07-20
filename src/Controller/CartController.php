<?php

namespace App\Controller;


use App\Classe\Cart;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    #[Route('/mon-panier', name: 'cart')]
    public function index(Cart $cart): Response
    {
        $cart->getTo();
        return $this->render('cart/index.html.twig');
    }
    #[Route('/cart/add/{id}', name: 'add_to_cart')]
    public function add(Cart $cart, $id): Response
    {
        $cart->addTo($id);

        return $this->redirectToRoute('cart');
    }
    #[Route('/cart/remove', name: 'remove_to_cart')]
    public function removeTo(Cart $cart): Response
    {
        $cart->removeTo();

        return $this->redirectToRoute('products');
    }
}
