<?php

namespace App\Form;

use App\Entity\Member;
use App\Entity\Showcase;
use App\Entity\Watch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShowcaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('publiee')
            ->add('createur', EntityType::class, [
                'class' => Member::class,
                'choice_label' => 'id',
            ])
            ->add('watches', EntityType::class, [
                'class' => Watch::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Showcase::class,
        ]);
    }
}
