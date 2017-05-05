<?php
namespace AppBundle\Command;

use AppBundle\Model\Vehicle;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Entity;

class StartCrawlerCommand extends Command
{
    private $adsProviders;
    private $em;
    private $imgDirectory;

    public function __construct(array $adsProviders, EntityManager $em, string $imgDirectory)
    {
        parent::__construct();

        $this->adsProviders = $adsProviders;
        $this->em = $em;
        $this->imgDirectory = $imgDirectory;
    }

    protected function configure()
    {
        $this->setName('crawler:start')
            ->setDescription('Start a crawler');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ads = [];

        if (!is_dir($this->imgDirectory)) {
            mkdir($this->imgDirectory);
        }

        foreach ($this->adsProviders as $adsProvider) {
            $crawlerManager = new $adsProvider($this->em, $this->imgDirectory);
            $ads = $crawlerManager->getNewAds();

//            $ads = array_merge($ads, $providerAds);
//            dump($ads);
            $this->save($ads);
        }


//
    }

    private function save(array $ads)
    {
        $em = $this->em;
        /**
         * @var Vehicle[] $ads
         */
        foreach ($ads as $ad) {
            $repository = $em->getRepository("AppBundle:Brand");
            $brand = $repository->findOneBy(array(
                'name' => $ad->getBrand(),
            ));

            $repository = $em->getRepository("AppBundle:Model");
            $model = $repository->findOneBy(array(
                'name' => $ad->getModel(),
            ));

            $repository = $em->getRepository("AppBundle:Country");
            $country = $repository->findOneBy(array(
                'name' => $ad->getCountry(),
            ));

            $repository = $em->getRepository("AppBundle:City");
            $city = $repository->findOneBy(array(
                'name' => $ad->getCity(),
            ));

            $repository = $em->getRepository("AppBundle:BodyType");
            $bodyType = $repository->findOneBy(array(
                'name' => $ad->getBodyType(),
            ));

            $repository = $em->getRepository("AppBundle:FuelType");
            $fuelType = $repository->findOneBy(array(
                'name' => $ad->getFuelType(),
            ));

            $repository = $em->getRepository("AppBundle:Color");
            $color = $repository->findOneBy(array(
                'name' => $ad->getColor(),
            ));

            $vehicle = new Entity\Vehicle();
            $vehicle->setBrand($brand);
            $vehicle->setModel($model);
            $vehicle->setCountry($country);
            $vehicle->setCity($city);
            $vehicle->setBodyType($bodyType);
            $vehicle->setFuelType($fuelType);
            $vehicle->setColor($color);
            $vehicle->setProviderId($ad->getProviderId());
            $vehicle->setProvider($ad->getProvider());
            $vehicle->setLink($ad->getLink());
            $vehicle->setPrice($ad->getPrice());
            $vehicle->setYear($ad->getYear());
            $vehicle->setEngineSize($ad->getEngineSize());
            $vehicle->setPower($ad->getPower());
            $vehicle->setDoorsNumber($ad->getDoorsNumber());
            $vehicle->setDriveType($ad->getDriveType());
            $vehicle->setTransmission($ad->getTransmission());
            $vehicle->setClimateControl($ad->getClimateControl());
            $vehicle->setDefects($ad->getDefects());
            $vehicle->setSteeringWheel($ad->getSteeringWheel());
            $vehicle->setWheelsDiameter($ad->getWheelsDiameter());
            $vehicle->setWeight($ad->getWeight());
            $vehicle->setMileage($ad->getMileage());
            $vehicle->setImage($ad->getImage());
            $em->persist($vehicle);
        }

        $em->flush();
        echo "Saved to DB";
    }
}
