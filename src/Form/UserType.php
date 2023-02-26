<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('mdp', PasswordType::class)
            ->add('role', ChoiceType::class, [
                'choices' => [
                    'Joueur' => 'joueur',
                    'Coach' => 'coach',
                    'Agent admin' => 'agent_admin',
                    'Agent magasin' => 'agent_magasin'
                ],

                'required' => true,
            ])
            ->add('date_birth', DateType::class, [
                'years' => range(date('Y') - 70, date('Y') - 16),
                'format' => 'dd-MM-yyyy',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
