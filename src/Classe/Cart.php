<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart
{



    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }
    public function add($id)
    {
        $this->session->set('cart', [
            [
                '$id' => $id,
                'quantity' => 1
            ]
        ]);
    }
}
