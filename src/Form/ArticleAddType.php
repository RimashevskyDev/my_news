<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleAddType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Название статьи'
            ])
            ->add('category', ChoiceType::class, [
                    'choices' => [
                        'Новости' => 'news',
                        'События' => 'events',
                        'Промо' => 'promo'
                    ],
                    'label' => 'Категория статьи'
                ]
            )
            ->add('text', TextareaType::class, [
                'label' => 'Текст статьи'
            ])
            ->add('photoFileName', TextType::class, [
                'label' => 'Путь до фотографии'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
