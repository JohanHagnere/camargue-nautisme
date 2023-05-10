<?php

namespace App\Form;

use App\Entity\Clients;
use App\Entity\Reservations;
use App\Entity\Equipements;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;

class ReservationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'constraints' => [
                    new Date([
                        'message' => 'La date n\'est pas valide',
                    ]),
                    new GreaterThanOrEqual([
                        'value' => 'today',
                        'message' => 'La date doit être ultérieure ou égale à aujourd\'hui',
                    ]),
                    new LessThanOrEqual([
                        'value' => '31 December this year',
                        'message' => 'La date doit être inférieure ou égale au 31 décembre de cette année',
                    ]),
                ],
                "widget" => 'single_text'
            ])
            ->add(
                'localisation',
                ChoiceType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    "choices" => ['Carnon' => 'carnon', "Palavas-les-flots" => 'palavas-les-flots'],
                    'mapped' => false,
                ]
            )
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
                ChoiceType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    "choices" => ['kayak simple' => 'kayak simple', "kayak double" => 'kayak double', "paddle" => 'paddle'],
                    'mapped' => false,
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
