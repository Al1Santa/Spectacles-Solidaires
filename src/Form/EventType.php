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
            ->add('content_2')
            ->add('link_video')
            ->add('link_sound')
            ->add('picture_1')
            ->add('picture_2')
            ->add('picture_3')
            ->add('time')
            ->add('age')
            ->add('technique_1')
            ->add('technique_2')
            ->add('technique_3')
            ->add('category', EntityType::class, 
            [
                'class' => Category::class,
                // https://symfony.com/doc/current/reference/forms/types/entity.html#choice-label
                // Si j'ai plusieur champs : concatenation à faire
                // je créer une function dans l'entité qui le fait
                'choice_label' => 'name', // va apeller getName()
                'mapped' => true
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
