<?php

namespace App\Form;

use App\Entity\Showcase;
use App\Entity\Watch;
use App\Entity\Member;
use App\Repository\WatchRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShowcaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Récupérer le Showcase à partir des options du formulaire
        $showcase = $options['data'] ?? null;
        $member = $showcase ? $showcase->getCreateur() : null;


        $builder
            ->add('description')
            ->add('publiee')
           ->add('createur', null, [
                    'disabled'   => true,
                  ])
            ->add('watches', null, [
                'query_builder' => function (WatchRepository $er) use ($member) {
                                      return $er->createQueryBuilder('w')
                                                ->leftJoin('w.watchBox', 'wb')
                                                ->leftJoin('wb.member', 'm')
                                                ->andWhere('m.id = :memberId')
                                                ->setParameter('memberId', $member->getId())
                                                ;
                                        }
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
