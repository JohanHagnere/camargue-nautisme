<?php

namespace App\Form;

use App\Entity\Recrutement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
class RecrutementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class, [ 'attr' => [
                    'class' => 'form-control'
                    ]
                    ])
               
            ->add('prenom',TextType::class, [ 'attr' => [
                'class' => 'form-control'
                ]
                ])
            ->add('age',NumberType::class, [ 'attr' => [
                'class' => 'form-control'
                ]
                ])
            ->add('mail',TextType::class, [ 'attr' => [
                'class' => 'form-control'
                ]
                ])
            ->add('telephone',TextType::class, [ 'attr' => [
                'class' => 'form-control'
                ]
                ])
            ->add('adresse',TextareaType::class, [ 'attr' => [
                'class' => 'form-control'
                ]
                ])
            ->add('posteCandidate',TextType::class, [ 'attr' => [
                'class' => 'form-controlb'
                ]
                ])
            ->add('diplomes',TextareaType::class, [ 'attr' => [
                'class' => 'form-controlc'
                ]
                ])
            ->add('experiences',TextareaType::class, [ 'attr' => [
                'class' => 'form-controlc'
                ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recrutement::class,
        ]);
    }
}
