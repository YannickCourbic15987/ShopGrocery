<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/nos-produit', name: 'products')]





    public function index(EntityManagerInterface $Manager): Response
    {
        $this->Manager = $Manager;
        $products = $this->Manager->getRepository(Product::class)->findAll();


        // dd($products);



        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }



    #[Route('/produit/{slug}', name: 'product')]



    public function show(EntityManagerInterface $Manager, $slug): Response
    {
        $this->Manager = $Manager;
        $product = $this->Manager->getRepository(Product::class)->findOneBySlug($slug);

        // dd($product);
        // dd($products);
        // dd($slug);
        if (!$product) {
            return $this->redirectToRoute('products');
        }

        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
    }
}
