<?php

namespace AppBundle\AdsProvider;

use AppBundle\Entity\Vehicle;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\PropertyAccess\PropertyAccess;

class AutopliusAdsProvider implements AdsProviderInterface
{
    protected $em;
    private $provider;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->provider = $this->em->getRepository("AppBundle:Provider")->findOneBy(
            ['name' => 'Autoplius.lt']
        );
    }

    public function getNewAds()
    {
        $hasItems = true;
        $cars = [];
        $details = [];

        $pageNumber = 1;
        $accessor = PropertyAccess::createPropertyAccessor();
        while ($hasItems) {
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

                $providerId = $innerCrawler->filter('.announcement-id strong')->text();
                $providerId = preg_replace("/[^0-9,.]/", "", $providerId);

                $location = trim($innerCrawler->filter('.owner-contacts .owner-location')->text());
                $tempArr = explode(",", $location);
                $city = trim($tempArr[0]);
                $country = trim($tempArr[1]);

                $imageUrl = ($innerCrawler->filter('.announcement-media-gallery .thumbnail')->count()) ?
                    trim($innerCrawler->filter('.announcement-media-gallery .thumbnail')->eq(0)->attr('style')):
                    'No image';
                preg_match("/\(([^\)]*)\)/", $imageUrl, $matches);
                $imageUrl = $matches[1];
                $imageUrl = trim($imageUrl, " ' ");
                $this->saveImages($imageUrl);

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
                    'url' => $innerUrl,
                    'providerId' => $providerId,
                    'details' => $details,
                ];

                $vehicle = $this->saveToModel($accessor, $car);

                $cars[] = $vehicle;
            }

            $pageNumber++;

            sleep(1);

            if ($pageNumber > 1) {
                break;
            }
        }

        return $cars;
    }

    public function saveToModel($accessor, $car)
    {
        $tempArr = explode("-", $car['details']['Pagaminimo data']);
        $year = $tempArr[0];

//        preg_match("/\(([^\)]*)\)/", $car['details']['Variklis'], $matches);
//        $enginePower = (int)$matches[1];
//        var_dump($enginePower);
//        die();
        $enginePower = 60;

        $vehicle = new \AppBundle\Model\Vehicle();
        $vehicle
            ->setBrand(
                $accessor->getValue($car, '[brand]')
            )
            ->setModel(
                $accessor->getValue($car, '[model]')
            )
            ->setCountry(
                $accessor->getValue($car, '[country]')
            )
            ->setCity(
                $accessor->getValue($car, '[city]')
            )
            ->setBodyType(
                $accessor->getValue($car, '[details][Kėbulo tipas]')
            )
            ->setFuelType(
                $accessor->getValue($car, '[details][Kuro tipas]')
            )
            ->setColor(
                $accessor->getValue($car, '[details][Spalva]')
            )
            ->setProviderId(
                $accessor->getValue($car, '[providerId]')
            )
            ->setProvider($this->provider)
            ->setLink(
                $accessor->getValue($car, '[url]')
            )
            ->setPrice(
                $accessor->getValue($car, '[price]')
            )
            ->setYear($year)
            ->setEngineSize(
                $accessor->getValue($car, '[engineSize]')
            )
            ->setPower($enginePower)
            ->setDoorsNumber(
                $accessor->getValue($car, '[details][Durų skaičius]')
            )
            ->setSeatsNumber(
                $accessor->getValue($car, '[details][Sėdimų vietų skaičius]')
            )
            ->setDriveType(
                $accessor->getValue($car, '[details][Vairo padėtis]')
            )
            ->setTransmission(
                $accessor->getValue($car, '[details][Pavarų dėžė]')
            )
            ->setClimateControl(
                $accessor->getValue($car, '[details][Klimato valdymas]')
            )
            ->setDefects(
                $accessor->getValue($car, '[details][Defektai]')
            )
            ->setSteeringWheel(
                $accessor->getValue($car, '[details][Varantieji ratai]')
            )
            ->setWheelsDiameter(
                $accessor->getValue($car, '[details][Ratlankių skersmuo]')
            )
            ->setWeight(
                $accessor->getValue($car, '[details][Nuosava masė, kg]')
            )
            ->setMileage(
                $accessor->getValue($car, '[details][Rida]')
            );

        return $vehicle;
    }

    public function saveImages($imageUrl)
    {
    }

    public function getHtml($url)
    {
        $curl = curl_init($url);
        curl_setopt(
            $curl,
            CURLOPT_USERAGENT,
            "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) 
            Chrome/57.0.2987.133 Safari/537.36"
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $html = curl_exec($curl);
        curl_close($curl);
        return $html;
    }
}
