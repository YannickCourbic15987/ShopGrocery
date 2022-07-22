<?php

namespace App\Form;

use App\Entity\Address;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Quel nom souhaitez-vous donner à votre adresse ?',
                'attr' => [
                    'placeholder' => 'nommez votre adresse '
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Votre Prénom',
                'attr' => [
                    'placeholder' => 'entrez votre prénom '
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre Nom',
                'attr' => [
                    'placeholder' => 'entrez votre nom '
                ]
            ])
            ->add('company', TextType::class, [
                'label' => 'Votre entreprise , si oui laquelle ?',
                'required' => false,
                'attr' => [
                    'placeholder' => 'entrez le nom de l\'entreprise (falcutatif)',

                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'Votre adresse ?',
                'attr' => [
                    'placeholder' => '8 rue des lilas...'
                ]
            ])
            ->add('postal', TextType::class, [
                'label' => 'votre Carte Postal ',
                'attr' => [
                    'placeholder' => 'entrez votre Carte Postal '
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'ville',
                'attr' => [
                    'placeholder' => 'entrez le nom de la ville'
                ]
            ])
            ->add('country', CountryType::class, [
                'label' => 'votre pays ',
                'attr' => [
                    'placeholder' => 'le nom du pays'
                ]
            ])
            ->add('phone', TelType::class, [
                'label' => 'Votre numéro de télèphone',
                'attr' => [
                    'placeholder' => 'numéro de télèphone'
                ]
            ])
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
