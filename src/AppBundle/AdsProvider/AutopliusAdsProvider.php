<?php

namespace AppBundle\AdsProvider;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\PropertyAccess\PropertyAccess;

class AutopliusAdsProvider extends AdsProvider
{
    public function __construct(EntityManager $em, string $imgDirectory)
    {
        $this->em = $em;
        $this->imgDirectory = $imgDirectory;
        $this->link = 'https://autoplius.lt/skelbimai/naudoti-automobiliai?older_not=30&page_nr=%psl%';
        $this->providerName = 'Autoplius.lt';
    }

    protected function parseAdsPage($html)
    {
        $cars = [];

        $crawler = new Crawler($html);
        $crawler = $crawler->filter('.item');

        foreach ($crawler as $domRow) {
            $row = new Crawler($domRow);

            //vehicle is not saved if it is sold
            if ($row->filter('.is-sold')->count() == 0) {
                $lastUpdate = $row->filter('.details-list  .tools-right');
                $lastUpdateDate = null;
                if ($lastUpdate->count() > 0) {
                    $lastUpdate = preg_replace('/\W\w+\s*(\W*)$/', '$1', $lastUpdate->text());
                    $lastUpdateDate = $this->parseDate($lastUpdate);
                    $innerUrl = $row->filter('.title-list a')->attr('href');
                    $car = $this->parseAd($innerUrl);
                    if ($car !== null && $car['']) {
                        $car['last_update'] = $lastUpdateDate;
                        $accessor = PropertyAccess::createPropertyAccessor();
                        $vehicle = $this->saveToModel($accessor, $car);
                        $cars[] = $vehicle;
                    }
                }
            }
            sleep(1);
        }
        return $cars;
    }

    private function parseAd(string $innerUrl)
    {
        $car = [];
        $innerHtml = $this->getHtml($innerUrl);
        $innerCrawler = new Crawler($innerHtml);

        $brand = trim($innerCrawler->filter('.content-container .breadcrumbs li')->eq(2)->text());
        $model = trim($innerCrawler->filter('.content-container .breadcrumbs li')->eq(3)->text());

        $brandModelRegex = '~(?<=[A-Za-z0-9])-(?=[A-Za-z0-9])~';
        preg_replace($brandModelRegex, ' ', $brand);
        preg_replace($brandModelRegex, ' ', $model);

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
        $imageUrl = str_replace('ann_25_', 'ann_25_', $imageUrl);
        $car['image'] = $this->saveImages($imageUrl, $this->provider->getName(), $providerId);

        $items = $innerCrawler->filterXPath('//table[@class="announcement-parameters"][1]//tr');
        foreach ($items as $innerDomRow) {
            $row = new Crawler($innerDomRow);
            $key = $row->filterXPath("//th")->text();
            $value = $row->filterXPath("//td")->text();
            $key = $this->getKeyName($key);
            if ($key !== null) {
                $func = $this->getFunctionFromKey($key);
                $value = $this->$func($value);
                $car[$key] = $value;
            }
        }
        $car = array_merge(
            $car, [
            'brand' => $brand,
            'model' => $model,
            'price' => $price,
            'city' => $city,
            'country' => $country,
            'url' => $innerUrl,
            'providerId' => $providerId,
            ]
        );
        return $car;
    }

    public function parseDate(string $dateString): \DateTime
    {
        $date = new \DateTime();
        $dateString = substr($dateString, 0, -1);
        $dateString = str_replace("prieš ", "-", $dateString);
        $dateString = str_replace('val. ', 'hours -', $dateString);
        $dateString = str_replace('val.', 'hours', $dateString);
        $dateString = str_replace('min.', 'minutes', $dateString);
        $dateString = str_replace('d.', 'days', $dateString);
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

    protected function getKeyName(string $title)
    {
        $keyMap = [
            'Pagaminimo data' => 'year',
            'Variklis' => 'engine',
            'Kuro tipas' => 'fuel_type',
            'Kėbulo tipas' => 'body_type',
            'Spalva' => 'color',
            'Pavarų dėžė' => 'drive_type',
            'Rida' => 'mileage',
            'Varantieji ratai' => 'transmission',
            'Defektai' => 'defects',
            'Vairo padėtis' => 'steering_wheel',
            'Durų skaičius' => 'doors_number',
            'Sėdimų vietų skaičius' => 'seats_number',
            'Tech. apžiūra iki' => 'next_check',
            'Nuosava masė, kg' => 'weight',
            'Pirmosios registracijos šalis' => 'first_country',
            'Ratlankių skersmuo' => 'wheels_diameter',
            'Klimato valdymas' => 'climate_control',
        ];
        if (isset($keyMap[$title])) {
            return $keyMap[$title];
        } else {
            return null;
        }
    }

    protected function adParseYear($value)
    {
        $dummy = explode("-", $value);
        $value = intval($dummy[0]);
        return $value;
    }

    protected function adParseEngine($value)
    {
        $dummy = explode(",", $value);
        $value = [];
        // parsing engine size
        if (isset($dummy[0])) {
            $dummy[0] = intval(preg_replace("/[^0-9,.]/", "", $dummy[0]));
            $value['engine_size'] = $dummy[0];
        }
        // parsing engine power
        if (isset($dummy[1])) {
            $power = null;
            preg_match('~\((.*?)\)~', $dummy[1], $power);
            $power = intval(preg_replace("/[^0-9,.]/", "", $power[1]));
            $value['power'] = $power;
        }
        return $value;
    }

    protected function adParseFuelType($value)
    {
        return $value;
    }

    protected function adParseBodyType($value)
    {
        return $value;
    }

    protected function adParseColor($value)
    {
        if ($value == 'Geltona / aukso') {
            $value = 'Geltona';
        } elseif ($value == 'Mėlyna / žydra') {
            $value = 'Mėlyna';
        } elseif ($value == 'Pilka / sidabrinė') {
            $value = 'Sidabrinė';
        } elseif ($value == 'Ruda / smėlio') {
            $value = 'Ruda';
        }
        return $value;
    }

    protected function adParseDriveType($value)
    {
        if ($value == 'Mechaninė') {
            $value = 0;
        } elseif ($value == 'Automatinė') {
            $value = 1;
        }
        return $value;
    }

    protected function adParseMileage($value)
    {
        $value = intval(preg_replace("/[^0-9,.]/", "", $value));
        return $value;
    }

    protected function adParseTransmission($value)
    {
        return $value;
    }

    protected function adParseDefects($value)
    {
        return $value;
    }

    protected function adParseSteeringWheel($value)
    {
        if ($value == 'Kairėje') {
            $value = 0;
        } elseif ($value == 'Dešinėje') {
            $value = 1;
        }
        return $value;
    }

    protected function adParseDoorsNumber($value)
    {
        $firstNum = $secondNum = null;
        sscanf($value, "%d/%d", $firstNum, $secondNum);
        $value = $firstNum;
        return $value;
    }

    protected function adParseSeatsNumber($value)
    {
        $value = intval($value);
        return $value;
    }

    protected function adParseNextCheck($value)
    {
        $dummy = explode('-', $value);
        $value = intval($dummy[0]);
        return $value;
    }

    protected function adParseWeight($value)
    {
        $value = intval(preg_replace("/[^0-9,.]/", "", $value));
        return $value;
    }

    protected function adParseFirstCountry($value)
    {
        return $value;
    }

    protected function adParseWheelsDiameter($value)
    {
        $value = intval(preg_replace("/[^0-9,.]/", "", $value));
        return $value;
    }

    protected function adParseClimateControl($value)
    {
        return $value;
    }
}
