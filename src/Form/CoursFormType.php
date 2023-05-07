<?php

namespace App\Form;

use App\Entity\Cours;
use App\Entity\Equipe;
use App\Entity\Arena;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CoursFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom')
            ->add('seance')
            ->add('duree')
            ->add ('arenaC')
            ->add ('equipex')
            ->add('arenaC',EntityType::class,[
                'class' => Arena::class,
                'choice_label' =>function(Arena $arenaC){
                
                    return sprintf('%s',$arenaC->getTERRAIN());
                    
                    
                },

                'expanded' => false,
                'multiple' =>false
            ])
            ->add('equipex',EntityType::class,[
                'class' => Equipe::class,
                'choice_label' =>function(Equipe $equipex){
                
                    return sprintf('%s', $equipex->getNom());
                },

                'expanded' => false,
                'multiple' =>false
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cours::class,
        ]);
    }
}
