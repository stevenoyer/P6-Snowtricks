<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Trick;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class TrickFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('state', ChoiceType::class, [
                'label' => '',
                'choices' => [
                    'Published' => 1,
                    'Unpublished' => 0
                ],
                'attr' => [
                    'class' => 'uk-select'
                ],
                'placeholder' => '-- Choose state --',
            ])
            ->add('title', TextType::class, [
                'label' => '',
                'attr' => [
                    'autocomplete' => 'name',
                    'class' => 'uk-input',
                    'aria-label' => 'Not clickable icon',
                    'placeholder' => 'Trick name',
                    'required' => 'true'
                ]
            ])
            ->add('introtext', TextareaType::class, [
                'label' => '',
                'attr' => [
                    'class' => 'uk-textarea',
                    'aria-label' => 'Not clickable icon',
                    'placeholder' => 'Intro text',
                    'required' => 'true'
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => '',
                'attr' => [
                    'class' => 'uk-textarea',
                    'aria-label' => 'Not clickable icon',
                    'placeholder' => 'Content',
                    'required' => 'true',
                    'rows' => 10
                ]
            ])
            ->add('mainPicture', FileType::class, [
                'required' => false,
                'mapped' => false,
                'attr' => [
                    'accept' => '.jpg, .png, .jpeg',
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpg',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Votre fichier contient une extension non autorisé. Les extensions acceptés sont : .jpg, .jpeg, .png.',
                    ])
                ]
            ])
            ->add('category', EntityType::class, [
                'label' => '',
                'attr' => [
                    'class' => 'uk-select'
                ],
                'placeholder' => '-- Choose category --',
                'class' => Category::class,
                'choice_label' => 'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
            'allow_extra_fields' => true
        ]);
    }
}
