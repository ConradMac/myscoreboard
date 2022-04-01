<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class, [
                "constraints" => [
                    new NotNull(['message' => "Veuillez saisir un pseudo pour pouvoir vous connecter"]),
                    new Length([
                        "min" => 4,
                        "minMessage" => "Le pseudo doit comporter au moins 4 caractères"
                    ])
                ]
            ])
            ->add('email', EmailType::class, [
                'mapped' => false,
                'label' => "E-mail",
                'constraints' => [
                    new NotNull(['message' => "L'email ne peut pas être vide"])
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Administrateur' => 'ROLE_ADMIN',
                    'Joueur' => 'ROLE_PLAYER',
                    'Arbitre' => 'ROLE_REFEREE',
                    'Utilisateur' => 'ROLE_USER',
                ],
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('password', TexteType::class, [
                'mapped'   => false,
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
