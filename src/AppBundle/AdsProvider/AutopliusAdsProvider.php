<?php

namespace AppBundle\AdsProvider;

use AppBundle\Entity\Vehicle;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DomCrawler\Crawler;

class AutopliusAdsProvider implements AdsProviderInterface
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getNewAds() {
        $hasItems = true;
        $cars = [];
        $details = [];

        $pageNumber = 1;
        while ( $hasItems ) {
            $url = "https://autoplius.lt/skelbimai/naudoti-automobiliai?older_not=30&page_nr=" . $pageNumber;
            $html = $this->getHtml($url);

            $hasItems = false;
            $crawler = new Crawler($html);
            $crawler = $crawler->filter('.item-section');

            foreach ($crawler as $domRow) {
                $hasItems = true;
                $row = new Crawler($domRow);

                $innerUrl = $row->filter('.title-list a')->attr('href');
                $innerHtml = $this->getHtml($innerUrl);
                $innerCrawler = new Crawler($innerHtml);

                $engineSize = $innerCrawler->filter('.classifieds-info h1')->text();
                $tempArr = explode(",", $engineSize);
                $engineSize = (float)trim($tempArr[1]);

                $brand = trim($innerCrawler->filter('.content-container .breadcrumbs li')->eq(2)->text());
                $model = trim($innerCrawler->filter('.content-container .breadcrumbs li')->eq(3)->text());
                $price = trim($innerCrawler->filter('.classifieds-info .view-price')->text());
                $price = (int)str_replace(' ', '', $price);

                $location = trim($innerCrawler->filter('.owner-contacts .owner-location')->text());
                $tempArr = explode(",", $location);
                $city = trim($tempArr[0]);
                $country = trim($tempArr[1]);

                $items = $innerCrawler->filterXPath('//table[@class="announcement-parameters"][1]//tr');

                foreach ($items as $innerDomRow) {
                    $row = new Crawler($innerDomRow);
                    $key = $row->filterXPath("//th")->text();
                    $value = $row->filterXPath("//td")->text();

                    $details[$key] = $value;
                }

                $car = [
                    'brand' => $brand,
                    'model' => $model,
                    'engineSize' => $engineSize,
                    'price' => $price,
                    'city' => $city,
                    'country' => $country,
                    'details' => $details,
                ];
                $cars[] = $car;
            }

            $pageNumber++;

            sleep(1);

            if ($pageNumber > 1) {
                break;
            }

        }

//        var_dump($cars);
//        foreach ($cars as $car) {
////            echo $car['details']['Variklis'];
//            preg_match("/\(([^\)]*)\)/", $car['details']['Variklis'] ,$matches);
//            $enginePower = (int)$matches[1];
//            echo $enginePower;
//        }
        $this->saveToDb($cars);
    }

    public function saveToDb($cars)
    {

        $array = [];
        foreach ($cars as $car) {
            $em = $this->em;
            $repository = $em->getRepository("AppBundle:Brand");

            $brand = $repository->findOneBy(array(
                'name' => $car['brand']
            ));

            $repository = $em->getRepository("AppBundle:Model");
            $model = $repository->findOneBy(array(
                'name' => $car['model']
            ));

            $repository = $em->getRepository("AppBundle:Country");
            $country = $repository->findOneBy(array(
                'name' => $car['country']
            ));

            $repository = $em->getRepository("AppBundle:City");
            $city = $repository->findOneBy(array(
                'name' => $car['city']
            ));

            $repository = $em->getRepository("AppBundle:BodyType");
            $bodyType = $repository->findOneBy(array(
                'name' => $car['details']['Kėbulo tipas']
            ));

            $repository = $em->getRepository("AppBundle:FuelType");
            $fuelType = $repository->findOneBy(array(
                'name' => $car['details']['Kuro tipas']
            ));

            $repository = $em->getRepository("AppBundle:Color");
            $color = $repository->findOneBy(array(
                'name' => $car['details']['Spalva']
            ));

            $vehicle = new Vehicle();
            $vehicle->setBrand($brand);
            $vehicle->setModel($model);
            $vehicle->setCountry($country);
            $vehicle->setCity($city);
            $vehicle->setBodyType($bodyType);
            $vehicle->setFuelType($fuelType);
            $vehicle->setColor($color);

            $vehicle->setProviderId(99);
            $vehicle->setProvider('autoplius');
            $vehicle->setLink('autoplius');

            $vehicle->setPrice($car['price']);

            $tempArr = explode("-", $car['details']['Pagaminimo data']);
            $year = $tempArr[0];
            $vehicle->setYear($year);

            $vehicle->setEngineSize($car['engineSize']);

            preg_match("/\(([^\)]*)\)/", $car['details']['Variklis'] ,$matches);
            $enginePower = (int)$matches[1];

            $vehicle->setPower($enginePower);

            $vehicle->setDoorsNumber($car['details']['Durų skaičius']);

            $vehicle->setSeatsNumber($car['details']['Sėdimų vietų skaičius']);

            $vehicle->setDriveType($car['details']['Vairo padėtis']);
            $vehicle->setTransmission($car['details']['Pavarų dėžė']);
            $vehicle->setClimateControl($car['details']['Klimato valdymas']);
            $vehicle->setDefects($car['details']['Defektai']);
            $vehicle->setSteeringWheel($car['details']['Varantieji ratai']);

            $vehicle->setWheelsDiameter($car['details']['Ratlankių skersmuo']);

            if (array_key_exists('Nuosava masė, kg', $car['details'])) {
                $vehicle->setWeight($car['details']['Nuosava masė, kg']);
            }
            if (array_key_exists('Rida', $car['details'])) {
                $vehicle->setMileage($car['details']['Rida']);
            }
            $em = $this->em;

            $em->persist($vehicle);
            $em->flush();


//            dump($color);

//            $array[] = $brand->id;
//            $array[] = $model->name;
        }

//        var_dump($array);
    }

    public function getHtml($url)	{
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $html = curl_exec($curl);
        curl_close($curl);
        return $html;
    }
}