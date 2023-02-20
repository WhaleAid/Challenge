<?php

namespace App\Form;

use App\Entity\Personne;
use App\Entity\Role;
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
            ->add('Lead', EntityType::class, [
                'class' => Personne::class,
                'choice_label' => 'name',
                'placeholder' => 'Select Lead',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->where('r.role = :role_id')
                        ->setParameter('role_id', 3);
                },
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
