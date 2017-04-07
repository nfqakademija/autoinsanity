<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Brand;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

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
        foreach($this->brandNames as $name)
        {
            $brand = new Brand();
            $brand->setName($name);
            $manager->persist($brand);
            $manager->flush();
        }
    }
}
