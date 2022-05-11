<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Event;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('content')
            ->add('link_video')
            ->add('link_sound')
            ->add('picture_1')
            ->add('picture_2')
            ->add('picture_3')
            ->add('time')
            ->add('age')
            ->add('category', EntityType::class, 
            [
                'class' => Category::class,
                // https://symfony.com/doc/current/reference/forms/types/entity.html#choice-label
                // Si j'ai plusieur champs : concatenation à faire
                // je créer une function dans l'entité qui le fait
                'choice_label' => 'name', // va apeller getName()
                "multiple" => true,
                // https://symfony.com/doc/current/reference/forms/types/entity.html#expanded
                // radio buttons or checkboxes
                "expanded" => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
