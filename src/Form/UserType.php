<?php

namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', null, [
                'attr' => [
                    'placeholder' => 'Prénom',
                ],
            ])
            ->add('name', null, [
                'attr' => [
                    'placeholder' => 'Nom',
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => '',
                'attr' => [
                    'placeholder' => 'Email',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter an email',
                    ]),
                    new Email([
                        'message' => 'Please enter a valid email',
                    ])
                ],
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Lead' => 'ROLE_LEAD',
                    'Dev' => 'ROLE_DEV',
                ],
                'choice_label' => function ($value, $key, $index) {
                    return $key;
                },
                'placeholder' => 'Sélectionner un rôle',
                'multiple' => false,
                'expanded' => true,
                'data' => (string) $options['data']->getRoles()[0],
            ])
            ->add('createdAt')
            ->add('updatedAt')
            ->add('Submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
