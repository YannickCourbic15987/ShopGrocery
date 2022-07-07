<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [

                'label' => "Votre Prénom",
                'label_attr' => [
                    'class'  => 'mt-2'
                ],
                'attr' => [
                    'placeholder' => 'Votre prénom ',
                    'class' => 'mb-4  '
                ]
            ]) //input firstname
            ->add('lastname',  TextType::class, [

                'label' => "Votre nom",
                'label_attr' => [
                    'class'  => ''
                ],
                'attr' => [
                    'placeholder' => 'Votre nom  ',
                    'class' => 'mb-4  '
                ]
            ]) //input firstname
            ->add('email', EmailType::class, [
                'label' => "Votre email",
                'label_attr' => [
                    'class'  => ''
                ],
                'attr' => [
                    'placeholder' => 'Un email valide ',
                    'class' => 'mb-4  '
                ]
            ]) //input email 
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'label' => 'votre mot de passe',
                'invalid_message' => 'le mot de passe et la confimation doivent être identitique',
                'required' => true,
                'first_options' => ['label' => 'mot de passe '],
                'second_options' => ['label' => 'confimer votre mot de passe']
            ]) //input password


            ->add('submit', SubmitType::class, [
                'label' => "s'inscrire",

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
