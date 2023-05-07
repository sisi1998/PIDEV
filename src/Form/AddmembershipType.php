<?php

namespace App\Form;

use App\Entity\CatMembership;
use App\Entity\PromotionsMem;
use App\Form\Type\JsonType;
use Doctrine\DBAL\Types\SimpleArrayType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AddmembershipType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name_mem')
            ->add('price_mem')
            ->add('period_mem')
            // ->add ('description',CollectionType::class,[
            //     'entry_type' => TextType::class,
            //     'allow_add' => true,
            //     'allow_delete' => true,
                
            //     'delete_empty' => true,

            //     'entry_options' => [
            //         'attr' => ['class' => 'email-box'],
                
            //     ],
            //     ])
            ->add('description')
            ->add('AddMembership',SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CatMembership::class,
        ]);
    }
}
