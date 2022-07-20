<?php

namespace App\Controller;

use ArrayAccess;
use App\Classe\Search;
use App\Entity\Product;
use App\Form\SearchType;
use App\Repository\ProductRepository;

use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/nos-produit', name: 'products')]


    public function index(ProductRepository $repoProducts, CategoryRepository $category): Response
    {


        return $this->render('product/index.html.twig', [


            'products' => $repoProducts->findAll(),
            'siteurl' => $_SERVER['SITE_URL'],
            'categories' => $category->findAll(),

        ]);
    }

    #[Route('/produit/recherche/', name: 'searchProduct')]
    public function search(Request $request, ProductRepository $products, CategoryRepository $categories): Response
    {
        // dd(
        //     $_SERVER
        // );
        return $this->render('product/index.html.twig', [
            'siteurl' => $_SERVER['SITE_URL'],
            'products' => $products->findBy(
                [
                    'category' => $request->request->get('category'),
                ]
            ),
            'categories' => $categories->findAll()
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
