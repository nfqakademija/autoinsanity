<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Brand;
use AppBundle\Entity\Model;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class LoadBrandData implements FixtureInterface
{
    private $brandNames = [
        'Abarth',
        'AC',
        'Acura',
        'Aixam',
        'Alfa Romeo',
        'Alpina',
        'AMC',
        'ARO',
        'Asia',
        'Aston Martin',
        'Audi',
        'Austin Rover',
        'Bentley',
        'BMW',
        'Briliance',
        'Bugatti',
        'Buick',
        'Cadillac',
        'Chevrolet',
        'Chrysler',
        'Citroen',
        'Cobra',
        'Dacia',
        'Daewoo',
        'DAF',
        'Daihatsu',
        'Datsun',
        'Delorean',
        'Desoto',
        'Dodge',
        'DR Motor',
        'Eagle',
        'Ferrari',
        'Fiat',
        'Fisker',
        'Ford',
        'GAZ',
        'Geo',
        'GMC',
        'Gonow',
        'Great Wall',
        'Honda',
        'Hummer',
        'Hyundai',
        'Infiniti',
        'International',
        'Isuzu',
        'Iveco',
        'Jaguar',
        'Jeep',
        'Kia',
        'Koenigsegg',
        'Lada',
        'Lamborghini',
        'Lancia',
        'Land Rover',
        'Landwind',
        'Lexus',
        'Ligier',
        'Lincoln',
        'Lotus',
        'LuAZ',
        'Mahindra',
        'Maserati',
        'Maybach',
        'Mazda',
        'Mclaren',
        'Mercedes-Benz',
        'Mercury',
        'MG',
        'Microcar',
        'Mini',
        'Mitsubishi',
        'Morgan',
        'Moskvich',
        'Nissan',
        'Norster',
        'Nysa',
        'Oldsmobile',
        'Opel',
        'Packard',
        'Peugeot',
        'Plymouth',
        'Pontiac',
        'Porsche',
        'Proton',
        'Renault',
        'Rolls-Royce',
        'Roosevelt',
        'Rover',
        'Saab',
        'Santana',
        'Saturn',
        'Scion',
        'Seat',
        'Secma',
        'Shuanghuan',
        'Skoda',
        'Smart',
        'Spartan',
        'Spyker',
        'SsangYong',
        'Studebaker',
        'Subaru',
        'Suzuki',
        'Talbot',
        'Tartan',
        'Tata',
        'Tatra',
        'Tazzari',
        'Tesla',
        'Think',
        'Toyota',
        'Trabant',
        'Triumph',
        'UAZ',
        'Vauxhall',
        'Venturi',
        'Volkswagen',
        'Volvo',
        'Wanderer',
        'Wartburg',
        'ZAZ',
    ];
    public function load(ObjectManager $manager)
    {
        try {
            $vehicleData = Yaml::parse(file_get_contents(__DIR__ . '/../brands_models.yml'));
        } catch (ParseException $e) {
            printf("Unable to parse the YAML string: %s", $e->getMessage());
        }
        foreach($vehicleData as $brandData)
        {
            $brand = new Brand();
            $brand->setName(key($vehicleData));
            $manager->persist($brand);
            $manager->flush();
            foreach($brandData['models'] as $modelName) {
                $model = new Model();
                $model->setName((string) $modelName);
                //$model->setBrand($brand->getId());
                $brand->addModel($model);
                $manager->persist($model);
                //$manager->flush();
            }
            //$manager->persist($brand);
            var_dump($brand);
            //$manager->flush();
        }
    }
}
