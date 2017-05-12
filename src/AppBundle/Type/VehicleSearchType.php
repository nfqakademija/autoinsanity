<?php

namespace AppBundle\Type;

use AppBundle\Entity\BodyType;
use AppBundle\Entity\Brand;
use AppBundle\Entity\City;
use AppBundle\Entity\ClimateControl;
use AppBundle\Entity\Color;
use AppBundle\Entity\Country;
use AppBundle\Entity\Defects;
use AppBundle\Entity\FuelType;
use AppBundle\Entity\Model;
use AppBundle\Entity\Provider;
use AppBundle\Entity\Transmission;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehicleSearchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $currentYear = intval(date('Y'));
        $modelModifier = function (FormInterface $form, Brand $brand = null) {
            $form->add(
                'model', EntityType::class, [
                'class' => Model::class,
                'label' => 'form.field.model',
                'multiple' => true,
                'query_builder' => function (EntityRepository $repo) use ($brand) {
                    return $repo->createQueryBuilder('model')
                        ->where('model.brand = :brand')
                        ->setParameter('brand', $brand === null ? null : $brand->getId())
                        ->orderBy('model.name', 'ASC');
                },
                'required' => false,
                ]
            );
        };
        $cityModifier = function (FormInterface $form, Country $country = null) {
            $form->add(
                'city', EntityType::class, [
                'class' => City::class,
                'label' => 'form.field.city',
                'multiple' => true,
                'query_builder' => function (EntityRepository $repo) use ($country) {
                    return $repo->createQueryBuilder('city')
                        ->where('city.country = :country')
                        ->setParameter('country', $country === null ? null : $country->getId())
                        ->orderBy('city.name', 'ASC');
                },
                'required' => false,
                ]
            );
        };
        $builder
            ->setMethod('GET')
            ->add(
                'brand', EntityType::class, [
                    'class' => Brand::class,
                    'label' => 'form.field.brand',
                    'placeholder' => 'form.placeholder.all.brand',
                    'query_builder' => function (EntityRepository $repo) {
                        return $repo->createQueryBuilder('brand')->orderBy('brand.name', 'ASC');
                    },
                    'required' => false,
                ]
            )
            ->add('price_from', IntegerType::class, ['label' => 'form.field.price_from'])
            ->add('price_to', IntegerType::class, ['label' => 'form.field.price_to'])
            ->add('year_from', IntegerType::class, ['label' => 'form.field.year_from'])
            ->add('year_to', IntegerType::class, ['label' => 'form.field.year_to'])

            ->add(
                'fuel_type', EntityType::class, [
                'class' => FuelType::class,
                'label' => 'form.field.fuel_type',
                'multiple' => true,
                'query_builder' => function (EntityRepository $repo) {
                    return $repo->createQueryBuilder('fuel_type')->orderBy('fuel_type.name', 'ASC');
                },
                'required' => false,
                ]
            )
            ->add(
                'body_type', EntityType::class, [
                'class' => BodyType::class,
                'label' => 'form.field.body_type',
                'multiple' => true,
                'query_builder' => function (EntityRepository $repo) {
                    return $repo->createQueryBuilder('body_type')->orderBy('body_type.name', 'ASC');
                },
                'required' => false,
                ]
            )
            ->add(
                'provider', EntityType::class, [
                'class' => Provider::class,
                'label' => 'form.field.provider',
                'multiple' => true,
                'query_builder' => function (EntityRepository $repo) {
                    return $repo->createQueryBuilder('provider')->orderBy('provider.name', 'ASC');
                },
                'required' => false,
                ]
            )
            ->add(
                'country', EntityType::class, [
                'class' => Country::class,
                'label' => 'form.field.country',
                'placeholder' => 'form.placeholder.all.country',
                'query_builder' => function (EntityRepository $repo) {
                    return $repo->createQueryBuilder('country')->orderBy('country.name', 'ASC');
                },
                'required' => false,
                ]
            )
            ->add('engine_size_from', IntegerType::class, ['label' => 'form.field.engine_size_from'])
            ->add('engine_size_to', IntegerType::class, ['label' => 'form.field.engine_size_to'])
            ->add('power_from', IntegerType::class, ['label' => 'form.field.power_from'])
            ->add('power_to', IntegerType::class, ['label' => 'form.field.power_to'])
            ->add('doors_number', IntegerType::class, ['label' => 'form.field.doors_number'])
            ->add('seats_number', IntegerType::class, ['label' => 'form.field.seats_number'])
            ->add(
                'drive_type', ChoiceType::class, [
                'choices' => [
                    'form.choice.drive_type.manual' => 0,
                    'form.choice.drive_type.auto' => 1,
                ],
                'label' => 'form.field.drive_type',
                'placeholder' => 'form.placeholder.all.drive_type',
                'required' => false,
                ]
            )
            ->add(
                'climate_control', EntityType::class, [
                'class' => ClimateControl::class,
                'label' => 'form.field.climate_control',
                'multiple' => true,
                'query_builder' => function (EntityRepository $repo) {
                    return $repo->createQueryBuilder('climate_control')->orderBy('climate_control.id', 'ASC');
                },
                'required' => false,
                ]
            )
            ->add(
                'color', EntityType::class, [
                    'class' => Color::class,
                    'label' => 'form.field.color',
                    'multiple' => true,
                    'query_builder' => function (EntityRepository $repo) {
                        return $repo->createQueryBuilder('color')->orderBy('color.name', 'ASC');
                    },
                    'required' => false,
                    //'multiple' => true,
                ]
            )
            ->add(
                'defects', EntityType::class, [
                    'class' => Defects::class,
                    'label' => 'form.field.defects',
                    'multiple' => true,
                    'query_builder' => function (EntityRepository $repo) {
                        return $repo->createQueryBuilder('defects')->orderBy('defects.name', 'ASC');
                    },
                    'required' => false,
                ]
            )
            ->add(
                'transmission', EntityType::class, [
                    'class' => Transmission::class,
                    'label' => 'form.field.transmission',
                    'multiple' => true,
                    'query_builder' => function (EntityRepository $repo) {
                        return $repo->createQueryBuilder('transmission')->orderBy('transmission.id', 'ASC');
                    },
                    'required' => false,
                ]
            )
            ->add(
                'steering_wheel', ChoiceType::class, [
                    'choices' => [
                        'form.choice.steering_wheel.left' => 0,
                        'form.choice.steering_wheel.right' => 1,
                    ],
                    'label' => 'form.field.steering_wheel',
                    'placeholder' => 'form.placeholder.all.steering_wheel',
                    'required' => false,
                ]
            )
            ->add('wheelsDiameter', IntegerType::class, ['label' => 'form.field.wheels_diameter'])
            ->add('mileage_from', IntegerType::class, ['label' => 'form.field.mileage_from'])
            ->add('mileage_to', IntegerType::class, ['label' => 'form.field.mileage_to'])
            ->add(
                'sort_type', ChoiceType::class, [
                'choices' => [
                    'form.choice.sort.cost_min' => '0',
                    'form.choice.sort.cost_max' => '1',
                    'form.choice.sort.date_new' => '2',
                    'form.choice.sort.date_old' => '3',
                ],
                'label' => 'form.field.sort',
                'placeholder' => false,
                'required' => false,
                ]
            )
            ->add(
                'next_check_year', ChoiceType::class, [
                'choice_translation_domain' => false,
                'choices' => [
                    $currentYear => $currentYear,
                    $currentYear + 1 => $currentYear + 1,
                    $currentYear + 2 => $currentYear + 2,
                    $currentYear + 3 => $currentYear + 3,
                    $currentYear + 4 => $currentYear + 4,
                    $currentYear + 5 => $currentYear + 5,
                ],
                'label' => 'form.field.next_check',
                'placeholder' => 'form.placeholder.all.next_check',
                'required' => false,
                ]
            )
            ->add(
                'first_country', EntityType::class, [
                'class' => Country::class,
                'label' => 'form.field.first_country',
                'multiple' => true,
                'query_builder' => function (EntityRepository $repo) {
                    return $repo->createQueryBuilder('first_country')->orderBy('first_country.name', 'ASC');
                },
                'required' => false,
                ]
            )
            ->add('gears_number', IntegerType::class, ['label' => 'form.field.gears_number'])
            ->add(
                'last_ad_update', ChoiceType::class, [
                'choices' => [
                    'form.choice.not_older_than.1_day' => 1,
                    'form.choice.not_older_than.3_days' => 3,
                    'form.choice.not_older_than.1_week' => 7,
                    'form.choice.not_older_than.2_weeks' => 14,
                    'form.choice.not_older_than.1_month' => 30,
                    'form.choice.not_older_than.3_months' => 90,
                ],
                'label' => 'form.field.not_older_than',
                'placeholder' => 'form.placeholder.all.not_older_than',
                'required' => false,
                ]
            );

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) use ($modelModifier) {
                $data = $event->getData();
                $brand = ($data === null) ? null : $data->getBrand();
                $modelModifier($event->getForm(), $brand);
            }
        );


        $builder->get('brand')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($modelModifier) {
                $brand = $event->getForm()->getData();
                $modelModifier($event->getForm()->getParent(), $brand);
            }
        );

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) use ($cityModifier) {
                $data = $event->getData();
                $country = ($data === null) ? null : $data->getCountry();
                $cityModifier($event->getForm(), $country);
            }
        );


        $builder->get('country')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($cityModifier) {
                $country = $event->getForm()->getData();
                $cityModifier($event->getForm()->getParent(), $country);
            }
        );
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false,
            'data_class' => 'AppBundle\Entity\VehicleSearch'
        ]);
    }

    public function getBlockPrefix()
    {
        return null;
    }
}
