<?php

namespace App\Form;

use App\Entity\CatMembership;
use App\Entity\PromotionsMem;
use Symfony\Component\Form\AbstractType;
use App\Repository\CatMembershipRepository;
use App\Repository\PromotionsMemRepository;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AddpromotionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name_promo')
            ->add('percentageprom')
            ->add('periodpro')
            ->add('memberships',EntityType::class,[
                'class'=>CatMembership::class,
                // 'query_builder' => function (CatMembershipRepository $cm) {
                
                //     return $cm->createQueryBuilder('c')
                //         ->where('c.promotion_id is NULL');
                // },
                'choice_label'=>function (CatMembership $catMembership){
                    return sprintf('%s',$catMembership->getNameMem());
                },
                'expanded' => false,
                'multiple'=> true,
            ])
            ->add('AddPromotion',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PromotionsMem::class,
        ]);
    }
}
