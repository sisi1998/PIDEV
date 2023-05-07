<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nombreProduit',
        IntegerType::class,
        [
            'required' => true,
            'attr' => [
                'min' => 1
            ]
        ])
            ->add('produit', EntityType::class, [
                'class'=>Produit::class,
                'choice_label' => function(Produit $prdouit) {
                    return sprintf('%s', $prdouit->getReference());
                }
            ])
         
       
     
           ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
