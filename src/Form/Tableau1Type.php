<?php

namespace App\Form;

use App\Entity\Tableau;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Tableau1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            //->add('createdAt')
            //->add('updatedAt')
            ->add('equipe')
            //->add('lead')
            //->add('manager')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tableau::class,
        ]);
    }
}
