<?php

namespace App\Form;

use App\Entity\Lead;
use App\Entity\Tableau;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TableauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('name')
            //->add('lead',UserType::class)
            ->add('lead', EntityType::class, [
                'class' => Lead::class,
                'choice_label' => 'firstname',
                'placeholder' => 'Select Lead',
                'required'=>'true'
            ])
            ->add('Soumettre', SubmitType::class)
        ;

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tableau::class,
        ]);
    }
}
