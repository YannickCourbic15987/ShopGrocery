<?php

namespace App\Controller;


use App\Classe\Cart;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class CartController extends AbstractController
{


    private $manager;

    public function __construct(
        EntityManagerInterface $manager
    ) {
        $this->manager = $manager;
    }




    #[Route('/mon-panier', name: 'cart')]
    public function index(Cart $cart): Response
    {
        $cartComplete = [];

        foreach ($cart->getTo() as $id => $quantity) {
            $cartComplete[] = [
                'product' => $this->manager->getRepository(Product::class)->findOneById($id),
                'quantity' => $quantity
            ];
        }

        // dd($cartComplete);

        return $this->render('cart/index.html.twig', [
            'siteurl' => $_SERVER['SITE_URL'],
            'cart' => $cartComplete
        ]);
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
