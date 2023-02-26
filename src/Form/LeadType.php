<?php

namespace App\Form;

use App\Entity\Lead;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LeadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('roles')
            ->add('password')
            ->add('email')
            ->add('isVerified')
            ->add('firstname')
            ->add('name')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('tableaus')
            ->add('equipe')
            ->add('tableau')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lead::class,
        ]);
    }
}
