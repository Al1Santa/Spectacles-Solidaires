<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Event;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, 
            [
                "label" => "Nom de catégorie :",
            ])
                    // ->add('events', EntityType::class, 
            // [
            //     'class' => Event::class,
            //     // https://symfony.com/doc/current/reference/forms/types/entity.html#choice-label
            //     // Si j'ai plusieur champs : concatenation à faire
            //     // je créer une function dans l'entité qui le fait
            //     'choice_label' => 'title', // will call getTitle()
            //     "multiple" => true,
            //     // https://symfony.com/doc/current/reference/forms/types/entity.html#expanded
            //     // radio buttons or checkboxes
            //     "expanded" => true,
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
