<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;


class PerformanceContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,['label'=>'Titre',
            'attr'=>['class'=>'form-control']])
            ->add('email',EmailType::class,['label'=>'votre-email',
            'attr'=>['class'=>'form-control']])
            ->add('message',CKEditorType::class,['label'=>'votre message'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
