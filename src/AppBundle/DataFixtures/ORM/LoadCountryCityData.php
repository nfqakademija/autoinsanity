<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\City;
use AppBundle\Entity\Country;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class LoadCountryCityData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        try {
            $countriesData = Yaml::parse(file_get_contents(__DIR__ . '/data/countries_cities.yml'));
        } catch (ParseException $e) {
            printf("Unable to parse the YAML file: %s", $e->getMessage());
        }
        foreach($countriesData['countries'] as $countryData)
        {
            $country = new Country();
            $country->setName($countryData['name']);
            $manager->persist($country);
            if($countryData['cities'] !== null) {
                foreach($countryData['cities'] as $cityName) {
                    $city = new City();
                    $city->setName($cityName);
                    $city->setCountry($country);
                    $manager->persist($city);
                }
            }
            $manager->flush();
        }
    }
}
