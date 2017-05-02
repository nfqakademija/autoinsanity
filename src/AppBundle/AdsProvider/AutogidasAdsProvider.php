<?php

namespace AppBundle\AdsProvider;

use AppBundle\Entity\Vehicle;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DomCrawler\Crawler;

class AutogidasAdsProvider implements AdsProviderInterface
{
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getNewAds()
    {
        $hasItems = true;
        $cars = [];
        $details = [];

        $pageNumber = 1;
        while ($hasItems) {
            $url = "https://autogidas.lt/automobiliai/?f_60=732&f_50=kaina_asc";
            $html = $this->getHtml($url);

            $hasItems = false;
            $crawler = new Crawler($html);
            $crawler = $crawler->filter('.item-link');

            foreach ($crawler as $domRow) {
                $hasItems = true;
                $row = new Crawler($domRow);

                $innerUrl = $row->filter('.item-link')->attr('href');
                $innerUrl = 'https://autogidas.lt' . $innerUrl;

                $innerHtml = $this->getHtml($innerUrl);
                $innerCrawler = new Crawler($innerHtml);

//                $engineSize = $innerCrawler->filter('.classifieds-info h1')->text();
//                $tempArr = explode(",", $engineSize);
//                $engineSize = (float)trim($tempArr[1]);
//
                $brand = trim($innerCrawler->filter('.bread-crumb a')->eq(1)->text()) . "autogidas";
                $model = trim($innerCrawler->filter('.bread-crumb a')->eq(2)->text());

                $price = trim($innerCrawler->filter('.params-block .price')->text());
                $price = (int)str_replace(' ', '', $price);

                $location = ($innerCrawler->filter('.contacts-wrapper .seller-location')->count()) ? trim($innerCrawler->filter('.contacts-wrapper .seller-location')->text()): 'Not set, Not set';
                $tempArr = explode(",", $location);
                $city = trim($tempArr[0]);
                $country = trim($tempArr[1]);

                $items = $innerCrawler->filterXPath('//div[@class="params-block"]//div[@class="param"]');

                foreach ($items as $innerDomRow) {
                    $row = new Crawler($innerDomRow);
                    $key = ($row->filterXPath('//div[@class="left"]')->count()) ? trim($row->filterXPath('//div[@class="left"]')->text()) : 'Not set';
                    $value = ($row->filterXPath('//div[@class="right"]')->count()) ? trim($row->filterXPath('//div[@class="right"]')->text()) : '';

                    $details[$key] = $value;
                }

                $car = [
                    'brand' => $brand,
                    'model' => $model,
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

        return $cars;
//        var_dump($cars);
//        $this->saveToDb($cars);
    }

    public function saveImages($imageUrl)
    {
    }

    public function saveToModel($accessor, $car)
    {
    }

    public function getHtml($url)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $html = curl_exec($curl);
        curl_close($curl);
        return $html;
    }
}
