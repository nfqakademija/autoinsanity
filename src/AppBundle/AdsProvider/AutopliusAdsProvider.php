<?php

namespace AppBundle\AdsProvider;

use AppBundle\Entity\Vehicle;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\PropertyAccess\PropertyAccess;

class AutopliusAdsProvider implements AdsProviderInterface
{
    protected $em;
    protected $imgDirectory;
    private $provider;

    public function __construct(EntityManager $em, string $imgDirectory)
    {
        $this->em = $em;
        $this->imgDirectory = $imgDirectory;
    }

    public function getNewAds()
    {
        $this->provider = $this->em->getRepository("AppBundle:Provider")->findOneBy(
            ['name' => 'Autoplius.lt']
        );
        $cars = [];
        $hasItems = true;
        $pageNumber = 1;
        while ($hasItems) {
            $hasItems = false;
            $url = "https://autoplius.lt/skelbimai/naudoti-automobiliai?older_not=30&page_nr=" . $pageNumber;
            $html = $this->getHtml($url);
            $pageCars = $this->parseAdsPage($html);
            $cars = array_merge($cars, $pageCars);
            if ($pageCars !== null) {
                $hasItems = true;
                $pageNumber++;
                sleep(1);
            }

            if ($pageNumber > 1) {
                break;
            }
        }
        return $cars;
    }

    private function parseAdsPage($html)
    {
        $cars = [];

        $crawler = new Crawler($html);
        $crawler = $crawler->filter('.item');

        foreach ($crawler as $domRow) {
            $row = new Crawler($domRow);

            $lastUpdate = $row->filter('.details-list  .tools-right');
            if ($lastUpdate->count() > 0) {
                $lastUpdate = preg_replace('/\W\w+\s*(\W*)$/', '$1', $lastUpdate->text());
                $lastUpdateDate = $this->parseDate($lastUpdate);
            }
            $innerUrl = $row->filter('.title-list a')->attr('href');
            $car = $this->parseAd($innerUrl);

            $car['last_update'] = $lastUpdateDate;
            $accessor = PropertyAccess::createPropertyAccessor();
            $vehicle = $this->saveToModel($accessor, $car);
            $cars[] = $vehicle;
        }
        return $cars;
    }

    private function parseAd($innerUrl)
    {
        $dummy = null;
        $details = [];
        $innerHtml = $this->getHtml($innerUrl);
        $innerCrawler = new Crawler($innerHtml);

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
        str_replace('ann_25_', $imageUrl, 'ann_7_');
        $details['image'] = $this->saveImages($imageUrl, $this->provider->getName(), $providerId);

        $items = $innerCrawler->filterXPath('//table[@class="announcement-parameters"][1]//tr');
        foreach ($items as $innerDomRow) {
            $row = new Crawler($innerDomRow);
            $key = $row->filterXPath("//th")->text();
            $value = $row->filterXPath("//td")->text();
            if ($key == 'Rida') {
                $value = intval(preg_replace("/[^0-9,.]/", "", $value));
            } elseif ($key == 'Durų skaičius') {
                $firstNum = $secondNum = null;
                sscanf($value, "%d/%d", $firstNum, $secondNum);
                $value = $firstNum;
            } elseif ($key == 'Sėdimų vietų skaičius') {
                $value = intval($value);
            } elseif ($key == 'Pagaminimo data') {
                $dummy = explode("-", $value);
                $value = intval($dummy[0]);
            } elseif ($key == 'Variklis') {
                $tempValues = explode(",", $value);
                $value = [];
                // parsing engine size
                if (isset($tempValues[0])) {
                    $tempValues[0] = intval(preg_replace("/[^0-9,.]/", "", $tempValues[0]));
                    $value['engine_size'] = $tempValues[0];
                }
                // parsing engine power
                if (isset($tempValues[1])) {
                    $power = null;
                    preg_match('~\((.*?)\)~', $tempValues[1], $power);
                    $power = intval(preg_replace("/[^0-9,.]/", "", $power[1]));
                    $value['power'] = $power;
                }
            } elseif ($key == 'Vairo padėtis') {
                if ($value == 'Kairėje') {
                    $value = 0;
                } else if ($value == 'Dešinėje') {
                    $value = 1;
                }
            } elseif ($key == 'Pavarų dėžė') {
                if ($value == 'Mechaninė') {
                    $value = 0;
                } else if ($value == 'Automatinė') {
                    $value = 1;
                }
            } elseif ($key == 'Ratlankių skersmuo') {
                $value = intval(preg_replace("/[^0-9,.]/", "", $value));
            } elseif ($key == 'Tech. apžiūra iki') {
                $dummy = explode('-', $value);
                $value = intval($dummy[0]);
            }
            $details[$key] = $value;
        }
        $car = [
            'brand' => $brand,
            'model' => $model,
            'price' => $price,
            'city' => $city,
            'country' => $country,
            'url' => $innerUrl,
            'providerId' => $providerId,
            'details' => $details,
        ];
        return $car;
    }

    public function saveToModel($accessor, $car)
    {
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
            ->setYear(
                $accessor->getValue($car, '[details][Pagaminimo data]')
            )
            ->setEngineSize(
                $accessor->getValue($car, '[details][Variklis][engine_size]')
            )
            ->setPower(
                $accessor->getValue($car, '[details][Variklis][power]')
            )
            ->setDoorsNumber(
                $accessor->getValue($car, '[details][Durų skaičius]')
            )
            ->setSeatsNumber(
                $accessor->getValue($car, '[details][Sėdimų vietų skaičius]')
            )
            ->setDriveType(
                $accessor->getValue($car, '[details][Pavarų dėžė]')
            )
            ->setTransmission(
                $accessor->getValue($car, '[details][Varantieji ratai]')
            )
            ->setClimateControl(
                $accessor->getValue($car, '[details][Klimato valdymas]')
            )
            ->setDefects(
                $accessor->getValue($car, '[details][Defektai]')
            )
            ->setSteeringWheel(
                $accessor->getValue($car, '[details][Vairo padėtis]')
            )
            ->setWheelsDiameter(
                $accessor->getValue($car, '[details][Ratlankių skersmuo]')
            )
            ->setWeight(
                $accessor->getValue($car, '[details][Nuosava masė, kg]')
            )
            ->setMileage(
                $accessor->getValue($car, '[details][Rida]')
            )
            ->setImage(
                $accessor->getValue($car, '[details][image]')
            )
            ->setNextCheckYear(
                $accessor->getValue($car, '[details][Tech. apžiūra iki]')
            )
            ->setFirstCountry(
                $accessor->getValue($car, '[details][Pirmosios registracijos šalis]')
            )
            ->setLastAdUpdate(
                $accessor->getValue($car, '[last_update]')
            );

        return $vehicle;
    }

    public function saveImages($imageUrl, $providerName, $id)
    {
        $fileName = $providerName . '-' . $id . '.jpg';
        $path = $this->imgDirectory . '/' . $fileName;
        $image = file_get_contents($imageUrl);
        $insert = file_put_contents($path, $image);
        if (!$insert) {
            throw new \Exception('Failed to write image');
        }
        return $fileName;
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

    public function parseDate(string $dateString): \DateTime
    {
        $date = new \DateTime();
        $dateString = substr($dateString, 0, -1);
        $dateString = str_replace("prieš ", "-", $dateString);
        $dateString = str_replace('val. ', 'hours -', $dateString);
        $dateString = str_replace('val.', 'hours', $dateString);
        $dateString = str_replace('min.', 'minutes', $dateString);
        $dateString = str_replace('d.', 'day', $dateString);

        $months = [
            ["Sausio", "January"],
            ["Vasario", "February"],
            ["Kovo", "March"],
            ["Balandžio", "April"],
            ["Gegužės", "May"],
            ["Birželio", "June"],
            ["Liepos", "July"],
            ["Rugpjūčio", "August"],
            ["Rugsėjo", "September"],
            ["Spalio", "October"],
            ["Lapkričio", "November"],
            ["Gruodžio", "December"],
        ];
        foreach ($months as $month) {
            $count = 0;
            $dateString = str_replace($month[0], $month[1], $dateString, $count);
            if ($count > 0) {
                $dateString = str_replace(' day', '', $dateString);
            }
        }
        $date->setTimestamp(strtotime($dateString));
        return $date;
    }
}
