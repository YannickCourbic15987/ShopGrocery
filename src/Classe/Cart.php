<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\RequestStack;
// use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{
    private $stack;

    public function __construct(RequestStack $stack)

    {
        return $this->stack = $stack;
    }

    public function addTo($id)
    {

        $session = $this->stack->getSession();

        $cart = $session->get('cart', []);



        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }





        $session->set('cart', $cart);
    }

    public function getTo()
    {
        $session_get = $this->stack->getSession();
        return dd($session_get->get('cart'));
    }


    public function removeTo()
    {
        $session_remove = $this->stack->getSession();
        return $session_remove->remove('cart');
    }

    // public function remove()
    // {

    //     $methodremove = $this->stack->getSession();
    //     return $methodremove->remove('cart');
    // }
}
