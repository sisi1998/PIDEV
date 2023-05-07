<?php

namespace App\Form;

use App\Entity\Competition;
use App\Entity\User;
use App\Entity\PerformanceC;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository; // import the EntityRepository class


class PerformanceCType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Apps')
            ->add('Mins')
            ->add('Buts')
            ->add('PointsDecisives')
            ->add('Jaune')
            ->add('Rouge')
            ->add('TpM')
            ->add('Pr')
            ->add('AeriensG')
            ->add('HdM')
            ->add('Note')

            ->add('joueurP', EntityType::class, [
                'class' => User::class,
                'placeholder' => 'joueur',
                'choice_label'=>'Nom',
                'multiple' => false,
                'expanded' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.role LIKE :role')
                        ->setParameter('role', '%joueur%')
                        ->orderBy('u.nom', 'ASC');
                },
            ])



        
            ->add('competitionP', EntityType::class, [
                'class' => Competition::class,
                'placeholder' => 'competition',
                'choice_label'=>'Nom',
                'multiple' => false,
                'expanded' => false
            ])

            
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PerformanceC::class,
        ]);
    }
}
