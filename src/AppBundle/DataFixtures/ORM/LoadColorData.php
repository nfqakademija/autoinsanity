<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Color;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class LoadColorData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        try {
            $colorsData = Yaml::parse(file_get_contents(__DIR__ . '/data/colors.yml'));
        } catch (ParseException $e) {
            printf("Unable to parse the YAML file: %s", $e->getMessage());
        }
        foreach($colorsData['colors'] as $colorData)
        {
            $color = new Color();
            $color->setName($colorData['name']);
            $manager->persist($color);
            $manager->flush();
        }
    }
}
