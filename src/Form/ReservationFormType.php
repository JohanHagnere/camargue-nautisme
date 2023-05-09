<?php

namespace App\Form;

use App\Entity\Clients;
use App\Entity\Reservations;
use App\Entity\Equipements;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                "widget" => 'single_text'
            ])
            ->add(
                'prenom',
                TextType::class,
                [
                    'mapped' => false,
                ]
            )
            ->add(
                'nom',
                TextType::class,
                [
                    'mapped' => false,
                ]
            )
            ->add(
                'mail',
                TextType::class,
                [
                    'mapped' => false,
                ]
            )
            ->add(
                'telephone',
                TextType::class,
                [
                    'mapped' => false,
                ]
            )
            ->add(
                'equipement',
                EntityType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    'class' => Equipements::class
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
        ]);
    }
}
