<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountAddressController extends AbstractController
{
    private $manager;


    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    #[Route('/compte/adresses', name: 'account_address')]
    public function index(): Response
    {
        // dd($this->getUser());
        return $this->render('account/address.html.twig');
    }
    #[Route('/compte/ajouter-une-adresse', name: 'account_address_add')]
    public function addAddress(Request $request): Response
    {
        $address = new Address();

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $address->setUser($this->getUser());
            $this->manager->persist($address);
            $this->manager->flush();
            // dd($address);
            return $this->redirectToRoute('account_address');
        }

        // dd($this->getUser());
        return $this->render('account/address_add.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    //function mod address 
    #[Route('/compte/modifier-une-adresse/{id}', name: 'account_address_mod')]
    public function modAddress(Request $request, $id): Response
    {
        $address = $this->manager->getRepository(Address::class)->findOneById($id);

        if (!$address || $address->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account_address');
        }

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->manager->flush();
            // dd($address);
            return $this->redirectToRoute('account_address');
        }

        // dd($this->getUser());
        return $this->render('account/address_add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/compte/supprimer-une-adresse/{id}', name: 'account_address_sup')]
    public function supAddress($id): Response
    {
        $address = $this->manager->getRepository(Address::class)->findOneById($id);

        if ($address && $address->getUser() == $this->getUser()) {
            $this->manager->remove($address);
            $this->manager->flush();
        }

        return $this->redirectToRoute('account_address');
        // dd($this->getUser())
    }
}
