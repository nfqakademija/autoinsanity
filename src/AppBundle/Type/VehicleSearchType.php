<?php

namespace AppBundle\Type;

use AppBundle\Entity\Brand;
use AppBundle\Entity\City;
use AppBundle\Entity\Color;
use AppBundle\Entity\Country;
use AppBundle\Entity\FuelType;
use AppBundle\Entity\Model;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
        $modelModifier = function (FormInterface $form, Brand $brand = null) {
            $form->add('model', EntityType::class, [
                'class' => Model::class,
                'label' => 'Modelis',
                'placeholder' => 'Visi modeliai',
                'query_builder' => function (EntityRepository $repo) use ($brand) {
                    return $repo->createQueryBuilder('model')
                        ->where('model.brand = :brand')
                        ->setParameter('brand', $brand === null ? null : $brand->getId())
                        ->orderBy('model.name', 'ASC');
                },
                'required' => false,
            ]);
        };
        $cityModifier = function (FormInterface $form, Country $country = null) {
            $form->add('city', EntityType::class, [
                'class' => City::class,
                'label' => 'Miestas',
                'placeholder' => 'Visi miestai',
                'query_builder' => function (EntityRepository $repo) use ($country) {
                    return $repo->createQueryBuilder('city')
                        ->where('city.country = :country')
                        ->setParameter('country', $country === null ? null : $country->getId())
                        ->orderBy('city.name', 'ASC');
                },
                'required' => false,
            ]);
        };
        $builder
            ->setMethod('GET')
            ->add('brand', EntityType::class, [
                'class' => Brand::class,
                'label' => 'Markė',
                'placeholder' => 'Visos markės',
                'query_builder' => function(EntityRepository $repo) {
                    return $repo->createQueryBuilder('brand')->orderBy('brand.name', 'ASC');
                },
                'required' => false,
            ])
            ->add('price_from', IntegerType::class, ['label' => 'Kaina nuo'])
            ->add('price_to', IntegerType::class, ['label' => 'Kaina iki'])
            ->add('year_from', IntegerType::class, ['label' => 'Metai nuo'])
            ->add('year_to', IntegerType::class, ['label' => 'Metai iki'])

            ->add('fuel_type', EntityType::class, [
                'class' => FuelType::class,
                'label' => 'Kuro tipas',
                'placeholder' => 'Visi kuro tipai',
                'query_builder' => function(EntityRepository $repo) {
                    return $repo->createQueryBuilder('fuel_type')->orderBy('fuel_type.name', 'ASC');
                },
                'required' => false,
            ])
            ->add('provider', TextType::class, ['label' => 'Šaltinis', ])
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'label' => 'Valstybė',
                'placeholder' => 'Visos valstybės',
                'query_builder' => function(EntityRepository $repo) {
                    return $repo->createQueryBuilder('country')->orderBy('country.name', 'ASC');
                },
                'required' => false,
            ])
            ->add('engine_size_from', IntegerType::class, ['label' => 'Variklio tūris nuo'])
            ->add('engine_size_to', IntegerType::class, ['label' => 'Variklio tūris iki'])
            ->add('power_from', IntegerType::class, ['label' => 'Galia nuo'])
            ->add('power_to', IntegerType::class, ['label' => 'Galia iki'])
            ->add('doors_number', IntegerType::class, ['label' => 'Durų skaičius'])
            ->add('seats_number', IntegerType::class, ['label' => 'Sėdimų vietų skaičius'])
            ->add('drive_type', TextType::class, ['label' => 'Varantieji ratai'])
            ->add('climate_control', TextType::class, ['label' => 'Klimato kontrolė'])
            ->add('color', EntityType::class, [
                'class' => Color::class,
                'label' => 'Spalva',
                'placeholder' => 'Visos spalvos',
                'query_builder' => function(EntityRepository $repo) {
                    return $repo->createQueryBuilder('color')->orderBy('color.name', 'ASC');
                },
                'required' => false,
            ])
            ->add('defects', TextType::class, ['label' => 'Defektai'])
            ->add('steering_wheel', ChoiceType::class, [
                'choices' => [
                    'Kairė' => 0,
                    'Dešinė' => 1,
                ],
                'data' => 0,
                'label' => 'Vairo padėtis',
                'placeholder' => 'Bet kokia padėtis',
                'required' => false,
            ])
            ->add('wheelsDiameter', IntegerType::class, ['label' => 'Padangų diametras'])
            ->add('mileage_from', IntegerType::class, ['label' => 'Rida nuo'])
            ->add('mileage_to', IntegerType::class, ['label' => 'Rida iki'])
            ->add('sort', ChoiceType::class, [
                'choices' => [
                    'pirmiau pigiausi' => 'cost_min',
                    'pirmiau brangiausi' => 'cost_max',
                    'pirmiau naujausi' => 'date_new',
                    'pirmiau seniausi' => 'date_old',
                ],
                'data' => 'cost_min',
                'label' => 'Skelbimų rodymas',
                'placeholder' => false,
                'required' => false,
            ]);

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) use ($modelModifier)
            {
                $data = $event->getData();
                $brand = ($data === null) ? null : $data->getBrand();
                $modelModifier($event->getForm(), $brand);
            }
        );


        $builder->get('brand')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($modelModifier)
            {
                $brand = $event->getForm()->getData();
                $modelModifier($event->getForm()->getParent(), $brand);
            }
        );

        $builder->addEventListener(
            FormEvents::POST_SET_DATA,
            function (FormEvent $event) use ($cityModifier)
            {
                $data = $event->getData();
                $country = ($data === null) ? null : $data->getCountry();
                $cityModifier($event->getForm(), $country);
            }
        );


        $builder->get('country')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($cityModifier)
            {
                $country = $event->getForm()->getData();
                $cityModifier($event->getForm()->getParent(), $country);
            }
        );
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
        ));
    }

    public function getBlockPrefix()
    {
        return null;
    }
}
