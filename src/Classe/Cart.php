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

        if (!is_null($session_get->get('cart'))) {
            return $session_get->get('cart');
        } else {
            return false;
        }
    }


    public function removeTo()
    {
        $session_remove = $this->stack->getSession();
        return $session_remove->remove('cart');
    }

    public function deleteTo($id)
    {
        $session_delete = $this->stack->getSession();
        $cart = $session_delete->get('cart', []);
        unset($cart[$id]);
        return $session_delete->set('cart', $cart);
    }

    public function less($id)
    {
        $session_less = $this->stack->getSession();
        $cart = $session_less->get('cart', []);
        if ($cart[$id] > 1) {
            $cart[$id]--;
        } else {
            unset($cart[$id]);
        }

        return $session_less->set('cart', $cart);
    }

    // public function remove()
    // {

    //     $methodremove = $this->stack->getSession();
    //     return $methodremove->remove('cart');
    // }
}
