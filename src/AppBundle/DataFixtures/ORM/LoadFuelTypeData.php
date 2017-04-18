<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\FuelType;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class LoadFuelTypeData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        try {
            $fuelTypesData = Yaml::parse(file_get_contents(__DIR__ . '/data/fuel_types.yml'));
        } catch (ParseException $e) {
            printf("Unable to parse the YAML file: %s", $e->getMessage());
        }
        foreach($fuelTypesData['fuel_types'] as $fuelTypeData)
        {
            $fuelType = new FuelType();
            $fuelType->setName($fuelTypeData['name']);
            $manager->persist($fuelType);
            $manager->flush();
        }
    }
}
