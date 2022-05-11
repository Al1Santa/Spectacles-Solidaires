<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('roles', ChoiceType::class,
            [
                'choices' => [
                    'user' => 'ROLE_USER',
                    'admin' => 'ROLE_ADMIN',
                    'manager' => 'ROLE_MANAGER',
                ],
                "multiple" => true,
                // radio buttons or checkboxes
                "expanded" => true
            ])
            ->add('password', PasswordType::class, 
            [
                "always_empty" => false
            ])
            ->add('firstname')
            ->add('lastname')
            ->add('avatar')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}