<?php

namespace App\Form;

use App\Entity\Stock;
use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class StockType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('quantite', IntegerType::class, [
            'label' => 'Quantité',
            'constraints' => [
                new Positive(['message' => 'La quantité doit être un entier positif']),
            ],
        ])
            ->add('produits')
            ->add('produits' , EntityType::class,[
                'class'=>Produit::class,
                'choice_label' => function(Produit    $produits) {
                    return sprintf(' %s',  $produits->getReference());
                },
               /* 'placholder'=>'categorie',*/
                'multiple'=>true,
                'expanded' => false 
               ])
               ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Stock::class,
        ]);
    }
}
