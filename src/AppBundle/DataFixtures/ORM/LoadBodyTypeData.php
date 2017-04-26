<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\BodyType;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class LoadBodyTypeData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        try {
            $bodyTypesData = Yaml::parse(file_get_contents(__DIR__ . '/data/body_types.yml'));
        } catch (ParseException $e) {
            printf("Unable to parse the YAML file: %s", $e->getMessage());
        }
        foreach ($bodyTypesData['body_types'] as $bodyTypeData) {
            $bodyType = new BodyType();
            $bodyType->setName($bodyTypeData['name']);
            $manager->persist($bodyType);
            $manager->flush();
        }
    }
}
