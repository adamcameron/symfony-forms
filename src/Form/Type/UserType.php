<?php

namespace App\Form\Type;

use App\Entity\User;
use App\Validator\UniqueLoginId;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('givenName', TextType::class)
            ->add('familyName', TextType::class)
            ->add('email', EmailType::class)
            ->add('loginId', TextType::class, [
                'label' => 'Login ID',
                'constraints' => [
                    new UniqueLoginId(),
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => [
                    'label' => 'Password',
                    'constraints' => [
                        new Assert\Regex([
                            'pattern' => '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).{8,}$/',
                            'message' => 'Password must be at least 8 characters long and include an uppercase letter, a lowercase letter, and a number.',
                        ]),
                    ],
                ],
                'second_options' => ['label' => 'Confirm Password'],
                'invalid_message' => 'The password fields must match.',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
