<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Brand;
use AppBundle\Entity\Model;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class LoadBrandModelData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        try {
            $vehicleData = Yaml::parse(file_get_contents(__DIR__ . '/data/brands_models.yml'));
        } catch (ParseException $e) {
            printf("Unable to parse the YAML file: %s", $e->getMessage());
        }
        foreach($vehicleData['cars'] as $brandData)
        {
            $brand = new Brand();
            $brand->setName($brandData['name']);
            $manager->persist($brand);
            if($brandData['models'] !== null) {
                foreach($brandData['models'] as $modelName) {
                    $model = new Model();
                    $model->setName($modelName);
                    $model->setBrand($brand);
                    $manager->persist($model);
                }
            }
            $manager->flush();
        }
    }
}
