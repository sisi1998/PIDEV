<?php

namespace App\Form;

use App\Entity\Competition;
use App\Entity\Equipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Arena;
use App\Entity\User;
use App\Entity\PerformanceC;
use Symfony\Component\Form\Extension\Core\Type\SubmitType; 
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;





class CompetitionUpadateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Date')
            ->add('etat')
            ->add('Nom')
            ->add('winner', EntityType::class, [
                'class' => Equipe::class,
                'placeholder' => 'Equipe Gagnant ',
                'choice_label'=>'Nom',
                'multiple' => false,
                'expanded' => false
            ])
            ->add('arena', EntityType::class, [
                'class' => Arena::class,
                'placeholder' => 'arena',
                'choice_label'=>'Nom',
                'multiple' => false,
                'expanded' => false
            ])
            ->add('equipes', EntityType::class, [
                'class' => Equipe::class,
                'placeholder' => 'Equipes',
                'choice_label'=>'Nom',
                'multiple' => true,
                'expanded' => false
            ])
            
            ->add('image', FileType::class, [
                'label' => 'Votre image de profil (Des fichiers images uniquement)',
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,
                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/gif',
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Competition::class,
        ]);
    }
}
