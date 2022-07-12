<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('email', EmailType::class, [
            //     'attr' => [
            //         'disabled' => true
            //     ],
            //     'label' => 'votre email '
            // ])
            // ->add('firstname', TextType::class, [
            //     'attr' => [
            //         'disabled' => true
            //     ],
            //     'label' => 'votre prénom '
            // ])
            // ->add('lastname', TextType::class, [
            //     'attr' => [
            //         'disabled' => true
            //     ],
            //     'label' => 'votre nom '
            // ])
            ->add('old_password', PasswordType::class, [
                'mapped' => false,
                'label' => 'votre mot de passe actuel',
                'attr' => [
                    'placeholder' => 'veuillez saisir votre mot de passe actuel'
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'mapped' => false,
                'type' => PasswordType::class,
                'label' => 'votre nouveau mot de passe',
                'invalid_message' => 'le nouveau mot de passe et la confimation doivent être identitique',
                'required' => true,
                'first_options' => [
                    'label' => 'vérifiez que votre nouveau mot de passe contienne au moins 8 caractères, dont au moins une minuscule, une majuscule et un chiffre',
                    'attr' => [
                        'placeholder' => 'Votre nouveau mot de passe à saisir'
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
                'label' => "Mettre à jour",

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
