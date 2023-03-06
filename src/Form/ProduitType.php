<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

use Symfony\Component\Form\Extension\Core\Type\FileType;


use Symfony\Component\Validator\Constraints\File;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference')
            ->add('marque')
            ->add('genre',ChoiceType::class,array('choices'=>array(
                'Femme'=>'Femme',
                'Homme'=>'Homme',
            ),
                'expanded' => true
            ))
            ->add('description')
            ->add('prix')
            ->add('stock',
                IntegerType::class,
                [
                    'required' => true,
                    'attr' => [
                        'min' => 1
                    ]
                ])
            ->add('categorie')
        
            ->add('categorie' , EntityType::class,[
            'class'=>Categorie::class,
            'choice_label' => function(Categorie     $categorie) {
                return sprintf(' %s',  $categorie->getNom());
            },
           /* 'placholder'=>'categorie',*/
            'multiple'=>false,
            'expanded' => true
           ])
          
        
           ->add('image', FileType::class, [
            'label' => 'image du produit (des fichiers image uniquement)',

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
                        'application/gif',
                        'application/jpeg',
                        'application/jpg',
                        'application/png',
                        'application/PNG',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid Image',
                ])
            ],
        ]);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
