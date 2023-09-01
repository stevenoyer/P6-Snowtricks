<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => '',
                'attr' => [
                    'autocomplete' => 'name',
                    'class' => 'uk-input',
                    'aria-label' => 'Not clickable icon',
                    'placeholder' => 'Full name',
                    'required' => 'true'
                ]
            ])
            ->add('username', TextType::class, [
                'label' => '',
                'attr' => [
                    'autocomplete' => 'username',
                    'class' => 'uk-input',
                    'aria-label' => 'Not clickable icon',
                    'placeholder' => 'Username',
                    'required' => 'true'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => '',
                'attr' => [
                    'autocomplete' => 'email',
                    'class' => 'uk-input',
                    'aria-label' => 'Not clickable icon',
                    'placeholder' => 'Email',
                    'required' => 'true'
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => '',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'uk-input',
                    'placeholder' => 'Password',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ]);

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();

            /**
             * @var User
             */
            $user = $event->getData();

            if ($user->getId() !== null) {
                $form->add('avatar', FileType::class, [
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
                ]);

                $form->remove('password');
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
