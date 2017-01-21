<?php

namespace Caldera\Bundle\CriticalmassCoreBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\Extension\Core\Type\TimezoneType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichFileType;

class StandardCityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'city',
                TextType::class,
                [
                    'required' => false
                ]
            )
            ->add(
                'title',
                TextType::class,
                [
                    'required' => false
                ]
            )
            ->add(
                'description',
                TextareaType::class,
                [
                    'required' => false
                ]
            )
            ->add(
                'url',
                TextType::class,
                [
                    'required' => false
                ]
            )
            ->add(
                'facebook',
                TextType::class,
                [
                    'required' => false
                ]
            )
            ->add(
                'twitter',
                TextType::class,
                [
                    'required' => false
                ]
            )
            ->add(
                'longitude',
                HiddenType::class
            )
            ->add(
                'latitude',
                HiddenType::class
            )
            ->add(
                'cityPopulation',
                IntegerType::class,
                [
                    'required' => false
                ]
            )
            ->add(
                'region',
                EntityType::class,
                [
                    'class' => 'CalderaBundle:Region',
                    'query_builder' => function (\Caldera\Bundle\CalderaBundle\Repository\RegionRepository $er) {
                        $builder = $er->createQueryBuilder('region');

                        $builder->join('region.parent', 'region2');
                        $builder->join('region2.parent', 'region3');

                        $builder->where($builder->expr()->isNotNull('region3.parent'));

                        $builder->orderBy('region2.name', 'ASC');
                        $builder->addOrderBy('region.name', 'ASC');

                        return $builder;
                    },
                    'group_by' => 'parent'
                ]
            )
            ->add(
                'punchLine',
                TextType::class,
                [
                    'required' => false
                ]
            )
            ->add(
                'longDescription',
                TextareaType::class,
                [
                    'required' => false
                ]
            )
            ->add(
                'enableBoard', CheckboxType::class
            )
            ->add(
                'timezone',
                TimezoneType::class
            )
            ->add(
                'isStandardable',
                CheckboxType::class,
                [
                    'required' => false
                ]
            )
            ->add(
                'standardDayOfWeek',
                ChoiceType::class,
                [
                    'label' => 'Wochentag',
                    'choices' => [
                        1 => 'Montag',
                        2 => 'Dienstag',
                        3 => 'Mittwoch',
                        4 => 'Donnerstag',
                        5 => 'Freitag',
                        6 => 'Sonnabend',
                        0 => 'Sonntag'
                    ],
                    'required' => true
                ]
            )
            ->add(
                'standardWeekOfMonth',
                ChoiceType::class,
                [
                    'label' => 'Woche im Monat',
                    'choices' => [
                        1 => 'Erste Woche im Monat',
                        2 => 'Zweite Woche im Monat',
                        3 => 'Dritte Woche im Monat',
                        4 => 'Vierte Woche im Monat',
                        0 => 'Letzte Woche im Monat'
                    ],
                    'required' => true
                ]
            )
            ->add(
                'isStandardableTime',
                CheckboxType::class,
                [
                    'required' => false
                ]
            )
            ->add(
                'standardTime',
                TimeType::class,
                [
                    'required' => false
                ]
            )
            ->add(
                'isStandardableLocation',
                CheckboxType::class,
                [
                    'required' => false
                ]
            )
            ->add(
                'standardLocation',
                TextType::class,
                [
                    'required' => false
                ]
            )
            ->add(
                'standardLatitude',
                HiddenType::class,
                [
                    'required' => false
                ]
            )
            ->add(
                'standardLongitude',
                HiddenType::class,
                [
                    'required' => false
                ]
            )
            ->add(
                'imageFile',
                VichFileType::class,
                [
                    'required' => false
                ]
            )
            ->add(
                'archiveMessage',
                TextType::class,
                [
                    'required' => true
                ]
            );
    }

    public function getName()
    {
        return 'city';
    }
}