<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Event;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, 
            [
                "label" => "Titre:",
                "attr" => [
                    "placeholder" => "saisissez un titre ..."
                ]
            ])
            ->add('content', TextType::class, 
            [
                "label" => "Premier contenu",
                "attr" => [
                    "placeholder" => "saisissez votre contenu ..."
                ]
            ])
            ->add('content_2', TextType::class, 
            [
                "label" => "Deuxième contenu",
                "attr" => [
                    "placeholder" => "saisissez votre second contenu ..."
                ]
            ])
            ->add('link_video', TextType::class, 
            [
                "label" => "Lien vers une vidéo",
                "attr" => [
                    "placeholder" => "saisissez le lien vers la vidéo ..."
                ]
            ])
            ->add('link_sound', TextType::class, 
            [
                "label" => "Lien vers le son",
                "attr" => [
                    "placeholder" => "saisissez le lien vers la bande sonore ..."
                    ]
            ])
            ->add('picture_1', TextType::class, 
            [
                "label" => "Lien vers l'image 1",
                "attr" => [
                    "placeholder" => "saisissez le lien vers la 1ère image ..."
                    ]
            ])
            ->add('picture_2', TextType::class, 
            [
                "label" => "Lien vers l'image 2",
                "attr" => [
                    "placeholder" => "saisissez le lien vers la 2ème image ..."
                    ]
            ])
            ->add('picture_3', TextType::class, 
            [
                "label" => "Lien vers l'image 3",
                "attr" => [
                    "placeholder" => "saisissez le lien vers la 3ème image ..."
                    ]
            ])
            ->add('time')
            ->add('age', TextType::class, 
            [
                "label" => "Age",
                "attr" => [
                    "placeholder" => "saisissez la tranche d'âge du public ..."
                    ]
            ])
            ->add('technique_1')
            ->add('technique_2')
            ->add('technique_3')
            ->add('category', EntityType::class, 
            [
                'class' => Category::class,
                // https://symfony.com/doc/current/reference/forms/types/entity.html#choice-label
                // If I have multiple fields : concatenation to do
                // I create a function in the entity that does this
                'choice_label' => 'name', // va apeller getName()
                    "multiple" => true,
                // https://symfony.com/doc/current/reference/forms/types/entity.html#expanded
                // radio buttons or checkboxes
                "expanded" => true,
            ])
            ->add('bonus_1')
            ->add('bonus_2')
        ;
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}