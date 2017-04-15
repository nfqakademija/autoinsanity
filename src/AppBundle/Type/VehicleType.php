<?php

namespace AppBundle\Type;

use AppBundle\Entity\Brand;
use AppBundle\Entity\City;
use AppBundle\Entity\Color;
use AppBundle\Entity\Country;
use AppBundle\Entity\FuelType;
use AppBundle\Entity\Model;
use AppBundle\Entity\Vehicle;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehicleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('GET')
            ->add('provider', TextType::class)
            ->add('brand', EntityType::class, [
                'class' => Brand::class,
                'query_builder' => function(EntityRepository $repo) {
                    return $repo->createQueryBuilder('brand')->orderBy('brand.name', 'ASC');
                },
                'required' => false,
            ])
            ->add('model', EntityType::class, [
                'class' => Model::class,
                'query_builder' => function(EntityRepository $repo) {
                    return $repo->createQueryBuilder('model')->orderBy('model.name', 'ASC');
                },
                'required' => false,
            ])
            ->add('price_from', IntegerType::class)
            ->add('price_to', IntegerType::class)
            ->add('year_from', IntegerType::class)
            ->add('year_to', IntegerType::class)
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'query_builder' => function(EntityRepository $repo) {
                    return $repo->createQueryBuilder('country')->orderBy('country.name', 'ASC');
                },
                'required' => false,
            ])
            ->add('city', EntityType::class, [
                'class' => City::class,
                'query_builder' => function(EntityRepository $repo) {
                    return $repo->createQueryBuilder('city')->orderBy('city.name', 'ASC');
                },
                'required' => false,
            ])
            ->add('engine_size_from', IntegerType::class)
            ->add('engine_size_to', IntegerType::class)
            ->add('power_from', IntegerType::class)
            ->add('power_to', IntegerType::class)
            ->add('fuel_type', EntityType::class, [
                'class' => FuelType::class,
                'query_builder' => function(EntityRepository $repo) {
                    return $repo->createQueryBuilder('fuel_type')->orderBy('fuel_type.name', 'ASC');
                },
                'required' => false,
            ])
            ->add('doors_number', IntegerType::class)
            ->add('seats_number', IntegerType::class)
            ->add('drive_type', TextType::class)
            ->add('climate_control', TextType::class)
            ->add('color', EntityType::class, [
                'class' => Color::class,
                'query_builder' => function(EntityRepository $repo) {
                    return $repo->createQueryBuilder('color')->orderBy('color.name', 'ASC');
                },
                'required' => false,
            ])
            ->add('defects', TextType::class)
            ->add('steering_wheel', ChoiceType::class, [
                'choices' => [
                    'Kairė' => 0,
                    'Dešinė' => 1,
                ],
                'required' => false,
            ])
            ->add('wheelsDiameter', IntegerType::class)
            ->add('mileage_from', IntegerType::class)
            ->add('mileage_to', IntegerType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
            'csrf_protection' => false,
        ]);
    }
}
