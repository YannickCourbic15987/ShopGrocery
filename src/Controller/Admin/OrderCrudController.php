<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class OrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            DateTimeField::new('createOrder', 'passé le '),
            TextField::new('user.getFullname', 'utilisateur'),
            MoneyField::new('total', 'Total')->setCurrency('EUR'),
            BooleanField::new('isPaid', 'payée')
        ];
    }
}
