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
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

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
                ],
                'constraints' => new Length(min: 2, max: 30),
                'constraints' => new NotBlank()
            ]) //input firstname
            ->add('lastname',  TextType::class, [

                'label' => "Votre nom",
                'label_attr' => [
                    'class'  => ''
                ],
                'attr' => [
                    'placeholder' => 'Votre nom  ',
                    'class' => 'mb-4  '
                ],
                'constraints' => new NotBlank(),
                'constraints' => new Length(min: 2, max: 30)
            ]) //input firstname
            ->add('email', EmailType::class, [
                'label' => "Votre email",
                'label_attr' => [
                    'class'  => ''
                ],
                'attr' => [
                    'placeholder' => 'Un email valide ',
                    'class' => 'mb-4  '
                ],
                'constraints' => new NotBlank(),

            ]) //input email 
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'label' => 'votre mot de passe',
                'invalid_message' => 'le mot de passe et la confimation doivent être identitique',
                'required' => true,
                'first_options' => [
                    'label' => 'vérifiez que votre mot de passe contienne au moins 8 caractères, dont au moins une minuscule, une majuscule et un chiffre',
                    'attr' => [
                        'placeholher' => 'Votre mot de passe à saisir'
                    ]
                ],
                'second_options' => [
                    'label' => 'confimer votre mot de passe',
                    'attr' => ['placeholder' => 'merci de saisir votre confirmation de mot de passe']
                ],
                // 'constraints' => new Length(min: 7),
                'constraints' => new NotBlank(),
                'constraints' => new Regex('/(?=\P{Ll}*\p{Ll})(?=\P{Lu}*\p{Lu})(?=\P{N}*\p{N})(?=[\p{L}\p{N}]*[^\p{L}\p{N}])[\s\S]{8,}/'),
                'constraints' => new Length(min: 7),
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
