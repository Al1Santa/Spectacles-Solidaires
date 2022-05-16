<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, 
            [
                "label" => "Votre E-Mail :",
                "attr" => [
                    "placeholder" => "saisissez votre email ..."
                ]
            ])
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
                "always_empty" => false,
                "label" => "Mot de passe :",
                "attr" => [
                    "placeholder" => "saisissez un mot de passe ..."
                ]
            ])
            ->add('firstname', TextType::class, 
            [
                "label" => "Prénom:",
                "attr" => [
                    "placeholder" => "saisissez votre prénom ..."
                ]
            ])
            ->add('lastname', TextType::class, 
            [
                "label" => "Nom :",
                "attr" => [
                    "placeholder" => "saisissez votre nom ..."
                ]
            ])
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